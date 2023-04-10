<?php
namespace Infinitops\Referral\Controllers;

use Infinitops\Referral\Controllers\Utils\Utility;

class UsersController extends Controller{


    public function createUser($data){
        try {
            $attributes = ['first_name', 'middle_name', 'surname', 'email', 'phone_number', 'password', 'category_id'];
            $missing = Utility::checkMissingAttributes($data, $attributes);
            throw_if(sizeof($missing) > 0, new \Exception("Missing parameters passed : " . json_encode($missing)));
            if($data['password'] == '') {
                unset($data['password']);
            } else{
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }
        } catch (\Throwable $th) {
            Utility::logError($th->getCode(), $th->getMessage());
            $this->response(PRECONDITION_FAILED_ERROR_CODE, $th->getMessage());

        }
    }

}

