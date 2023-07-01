<?php

namespace Infinitops\Referral\Controllers;

use Firebase\JWT\JWT;
use Infinitops\Referral\Models\User;
use Infinitops\Referral\Models\UserToken;
use Infinitops\Referral\Controllers\Utils\Utility;
use Infinitops\Referral\Controllers\Controller;
use Infinitops\Referral\Models\UserCategory;
use Illuminate\Database\Capsule\Manager as DB;

class UsersController extends Controller
{


    public function createUser($data)
    {
        try {
            $this->verifyTokenAuth();
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
            $this->verifyTokenAuth();
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

    public function getUsers(){
        try {
            $this->verifyTokenAuth();
            response(SUCCESS_RESPONSE_CODE, "Users", User::all());
        } catch (\Throwable $th) {
            Utility::logError($th->getCode(), $th->getMessage());
            response(PRECONDITION_FAILED_ERROR_CODE, $th->getMessage());
        }
    }

    public function login($data)
    {
        try {
            $attributes = ['phone_number', 'password'];
            $missing = Utility::checkMissingAttributes($data, $attributes);
            throw_if(sizeof($missing) > 0, new \Exception("Missing parameters passed : " . json_encode($missing)));
            $user = User::where('phone_number', $data['phone_number'])->first();
            if ($user == null) throw new \Exception("User does not exist", -1);
            if (password_verify($data['password'], $user->password)) {
                $user->last_login = date("Y:m:d h:i:s", time());
                $user->save();
                $privateKey = file_get_contents(__DIR__ . '/../../mykey.pem');
                $issuer_claim = 'infinitops';
                $issuedat_claim = time();
                $expire_claim = $issuedat_claim + TOKEN_TIME;
                $token = array(
                    "iss" => $issuer_claim,
                    "iat" => $issuedat_claim,
                    "exp" => $expire_claim,
                    "data" => array(
                        "id" => $user->id
                    )
                );

                $jwt = JWT::encode($token, $privateKey, 'RS256');
                UserToken::create([
                    'user_id' => $user->id, 'access_token' => $jwt, 'refresh_token' => $jwt
                ]);
                $user->access_token = $jwt;
                response(SUCCESS_RESPONSE_CODE, "Login successful.", $user);
            } else throw new \Exception('Invalid credentials', -1);
        } catch (\Throwable $th) {
            Utility::logError($th->getCode(), $th->getMessage());
            response(UNAUTHORIZED_ERROR_CODE, "Unable to login. Try again later::" . $th->getMessage());
            http_response_code(UNAUTHORIZED_ERROR_CODE);
        }
    }

    public function register($data){
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
            response(SUCCESS_RESPONSE_CODE, "User account Created successfully.", $user);
        } catch (\Throwable $th) {
            Utility::logError($th->getCode(), $th->getMessage());
            if ($th->getCode() == 23000) response(PRECONDITION_FAILED_ERROR_CODE, "User already exists. Email | Phonenumber found");
            else response(PRECONDITION_FAILED_ERROR_CODE, $th->getCode() . $th->getMessage());
        }
    }

    public function getUserCategories(){
        $userCategories = DB::select("select * from user_categories uc where '1' in (uc.permissions);");
        response(SUCCESS_RESPONSE_CODE, "User categories", $userCategories);
    }

    public function getLoggedInUser(){
        try {
            $data = $this->verifyTokenAuth();
            $userData = $data['data'];
            response(SUCCESS_RESPONSE_CODE, "Success", User::findOrFail($userData->id));
        } catch (\Throwable $th) {
            Utility::logError($th->getCode(), $th->getMessage());
            response(UNAUTHORIZED_ERROR_CODE, "Unable to login. Try again later::" . $th->getMessage());
        }
    }

}
