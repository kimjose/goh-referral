<?php

namespace Infinitops\Referral\Controllers;

use Infinitops\Referral\Models\Otp;
use Infinitops\Referral\Models\User;
use Infinitops\Referral\Models\Patient;
use Infinitops\Referral\Models\UserCategory;
use Infinitops\Referral\Models\PatientReferral;
use Infinitops\Referral\Controllers\Utils\Utility;

class WebController
{

    protected $user = null;

    public function __construct()
    {
        session_start();
        if (!isset($_SESSION[$_ENV['SESSION_APP_NAME']])) {
            http_response_code(401);
            //    die(401);
        }
        $sessionData = $_SESSION[$_ENV['SESSION_APP_NAME']];
        if (!isset($sessionData['expires_at'])) {
            http_response_code(401);
            //    die(401);
        } else {
            if (time() > $sessionData['expires_at']) {
                session_unset();
                session_destroy();
                http_response_code(401);
                //        die(401);
            } else {
                $this->user = $sessionData['user'];
                $sessionData['expires_at'] = time() + ($_ENV['SESSION_DURATION'] * 60);
                $_SESSION[$_ENV['SESSION_APP_NAME']] = $sessionData;
            }
        }
    }

    public function createUserCategory($data){
        try {
            if(!hasPermission(PERM_SYSTEM_ADMINISTRATION, $this->user)) throw new \Exception("Forbidden", 403);
            $attributes = ["name", "description", "permissions"];
            $missing = Utility::checkMissingAttributes($data, $attributes);
            throw_if(sizeof($missing) > 0, new \Exception("Missing parameters passed : " . json_encode($missing)));
            $data['created_by'] = $this->user->id;
            UserCategory::create($data);
            response(SUCCESS_RESPONSE_CODE, "The user category created successfully.");
        } catch (\Throwable $th) {
            Utility::logError($th->getCode(), $th->getMessage());
            response(PRECONDITION_FAILED_ERROR_CODE, $th->getMessage());
        }
    }

    public function updateUserCategory($id, $data){
        try {
            if(!hasPermission(PERM_SYSTEM_ADMINISTRATION, $this->user)) throw new \Exception("Forbidden", 403);
            $attributes = ["name", "description", "permissions"];
            $missing = Utility::checkMissingAttributes($data, $attributes);
            throw_if(sizeof($missing) > 0, new \Exception("Missing parameters passed : " . json_encode($missing)));
            $userCategory = UserCategory::findOrFail($id);
            $userCategory->update($data);
            response(SUCCESS_RESPONSE_CODE, "The user category updated successfully.");
        } catch (\Throwable $th) {
            Utility::logError($th->getCode(), $th->getMessage());
            response(PRECONDITION_FAILED_ERROR_CODE, $th->getMessage());
        }
    }


    public function createPatient($data)
    {
        try {
            $attributes = [
                "surname", "first_name", "other_names", "gender", "dob", "marital_status", "education", "primary_occupation",
                "identifier", "identifier_type", "phone_no", "alt_phone_no", "email", "nationality", "county_code", "sub_county", "nearest_health_centre",
                "nok_name", "nok_relationship", "nok_phone_no", "has_nhif", "nhif_number", "preferred_mop", "other_insurance"
            ];
            $missing = Utility::checkMissingAttributes($data, $attributes);
            throw_if(sizeof($missing) > 0, new \Exception("Missing parameters passed : " . json_encode($missing)));
            $exists = Patient::where('identifier', $data['identifier'])->first();
            if ($exists) throw new \Exception("Patient already exists", -1);
            $data['created_by'] = $this->user->id;
            $patient = Patient::create($data);
            response(SUCCESS_RESPONSE_CODE, "Patient created successfully.", $patient);
        } catch (\Throwable $th) {
            Utility::logError($th->getCode(), $th->getMessage());
            response(PRECONDITION_FAILED_ERROR_CODE, $th->getMessage());
        }
    }

    public function updatePatient($id, $data)
    {
        try {
            $attributes = [
                "surname", "first_name", "other_names", "gender", "dob", "marital_status", "education", "primary_occupation",
                "identifier", "identifier_type", "phone_no", "alt_phone_no", "email", "nationality", "county_code", "sub_county", "nearest_health_centre",
                "nok_name", "nok_relationship", "nok_phone_no", "has_nhif", "nhif_number", "preferred_mop", "other_insurance"
            ];
            $missing = Utility::checkMissingAttributes($data, $attributes);
            throw_if(sizeof($missing) > 0, new \Exception("Missing parameters passed : " . json_encode($missing)));
            $patient = Patient::find($id);
            if ($patient == null) throw new \Exception("Patient not found.");
            $patient->update($data);
            response(SUCCESS_RESPONSE_CODE, "Patient updated successfully.", $patient);
        } catch (\Throwable $th) {
            Utility::logError($th->getCode(), $th->getMessage());
            response(PRECONDITION_FAILED_ERROR_CODE, $th->getMessage());
        }
    }

    public function updateReferralStatus($data){
        try{
            $attributes = ['status', 'id'];
            $missing = Utility::checkMissingAttributes($data, $attributes);
            throw_if(sizeof($missing) > 0, new \Exception("Missing parameters passed : " . json_encode($missing)));
            $referral = PatientReferral::find($data['id']);
            if($referral == null) throw new \Exception("Invalid data");
            $referral->status = $data['status'];
            $referral->updated_by = $this->user->id;
            $referral->save();
            response(SUCCESS_RESPONSE_CODE, "Updated successfully");
        }  catch (\Throwable $th) {
            Utility::logError($th->getCode(), $th->getMessage());
            response(PRECONDITION_FAILED_ERROR_CODE, $th->getMessage());
        }
    }

    public static function requestOtp($data){
        try {
            $attributes = ['phone_number'];
            $missing = Utility::checkMissingAttributes($data, $attributes);
            throw_if(sizeof($missing) > 0, new \Exception("Missing parameters passed : " . json_encode($missing)));
            $user = User::where('phone_number', $data['phone_number'])->first();
            if($user == null) throw new \Exception("User does not exist");

            $otp = Otp::where('user_id', $user->id)->where('is_used', 0)->where('expires_at', '>', date('Y-m-d H:i:s'))->first();
            if($otp == null) {
                $d = date("Y-m-d G:i:s");
                $expirely = date("Y-m-d G:i:s", strtotime($d .' + 10 minute'));
                $otp = Otp::create([
                    "user_id" => $user->id,
                    "pin" => rand(1000, 9999),
                    "expires_at" => $expirely
                ]);
            }
            $recipient['address'] = $user->email;
            $recipient['name'] = $user->username;
            $recipients[] = $recipient;
            Utility::sendMail($recipients, "System OTP", "Hello {$user->first_name}, Your OTP for Systems backup is {$otp->pin }. The OTP expires at {$otp->expires_at} ");
        } catch (\Throwable $th) {
            Utility::logError($th->getCode(), $th->getMessage());
            response(PRECONDITION_FAILED_ERROR_CODE, $th->getMessage());
        }
    }

    public function createUser($data)
    {
        try {
            $attributes = ['first_name', 'middle_name', 'surname', 'email', 'phone_number', 'password', 'category_id'];
            $missing = Utility::checkMissingAttributes($data, $attributes);
            throw_if(sizeof($missing) > 0, new \Exception("Missing parameters passed : " . json_encode($missing)));
            if ($data['password'] == '') {
                unset($data['password']);
            } else {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }
            $user = User::create($data);
            response(SUCCESS_RESPONSE_CODE, "User Created successfully.", $user);
        } catch (\Throwable $th) {
            Utility::logError($th->getCode(), $th->getMessage());
            if ($th->getCode() == 23000) response(PRECONDITION_FAILED_ERROR_CODE, "User already exists. Email | Phonenumber found");
            else response(PRECONDITION_FAILED_ERROR_CODE, $th->getCode() . $th->getMessage());
        }
    }

    public function updateUser($id, $data)
    {
        try {
            $attributes = ['first_name', 'middle_name', 'surname', 'email', 'phone_number', 'password', 'category_id'];
            $missing = Utility::checkMissingAttributes($data, $attributes);
            throw_if(sizeof($missing) > 0, new \Exception("Missing parameters passed : " . json_encode($missing)));
            if ($data['password'] == '') {
                unset($data['password']);
            } else {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }
            $user = User::find($id);
            if ($user == null) throw new \Exception('User not found', -1);
            $user->update($data);
            response(SUCCESS_RESPONSE_CODE, "User updated successfully", $user);
        } catch (\Throwable $th) {
            Utility::logError($th->getCode(), $th->getMessage());
            response(PRECONDITION_FAILED_ERROR_CODE, $th->getMessage());
        }
    }

}
