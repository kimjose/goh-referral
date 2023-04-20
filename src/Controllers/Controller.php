<?php

namespace Infinitops\Referral\Controllers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Infinitops\Referral\Models\User;
use Infinitops\Referral\Models\UserToken;
use Illuminate\Support\Facades\Notification;
use Infinitops\Referral\Controllers\Utils\Utility;

class Controller
{

    protected User $user;

    public function __construct()
    {
        
    }

    public function verifyTokenAuth()
    {
        try {
            $token = $_SERVER['HTTP_TOKEN'];
            $publicKey = file_get_contents(__DIR__ . '/../../mykey.pub');
            $userToken = UserToken::where('access_token', $token)->first();
            if ($userToken == null) throw new \Exception("Invalid token", UNAUTHORIZED_ERROR_CODE);

            $jwt = JWT::decode($userToken->refresh_token, new Key($publicKey,  'RS256'));
            $decoded_array = (array) $jwt;

            $privateKey = file_get_contents(__DIR__ . '/../../mykey.pem');
            $issuer_claim = 'infinitops';
            $issuedat_claim = time();
            $expire_claim = $issuedat_claim + TOKEN_TIME;
            $token = array(
                "iss" => $issuer_claim,
                "iat" => $issuedat_claim,
                "exp" => $expire_claim,
                "data" => array(
                    "id" => $userToken->user_id
                )
            );
            $jwt = JWT::encode($token, $privateKey, 'RS256');
            $userToken->update(['refresh_token' => $jwt]);
            $this->user = User::find($decoded_array['id']);
            return $decoded_array;
            // print_r($decoded_array);
        } catch (\Throwable $th) {
            response(UNAUTHORIZED_ERROR_CODE, $th->getMessage());
            http_response_code(UNAUTHORIZED_ERROR_CODE);
            exit(UNAUTHORIZED_ERROR_CODE);
        }
    }

    /*******
     * Creates a notification for the user whose id is passed.
     *
     * @param $userId int id for the user;
     * @param $message string The naughty-fication message
     *
     */
    public function createNotification(int $userId, string $message)
    {
        Notification::create([
            "user_id" => $userId,
            "message" => $message
        ]);
    }
}
