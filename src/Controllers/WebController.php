<?php

namespace Infinitops\Referral\Controllers;

use Infinitops\Referral\Models\Patient;
use Infinitops\Referral\Controllers\Utils\Utility;
use Infinitops\Referral\Models\PatientReferral;

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

}
