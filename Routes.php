<?php

use Bramus\Router\Router;
use Infinitops\Referral\Models\Otp;
use Infinitops\Referral\Models\User;
use Infinitops\Referral\Models\County;
use Infinitops\Referral\Models\Facility;
use Infinitops\Referral\Models\Insurance;
use Infinitops\Referral\Models\SubCounty;
use Infinitops\Referral\Models\Department;
use Infinitops\Referral\Controllers\Utils\Utility;
use Infinitops\Referral\Controllers\WebController;
use Infinitops\Referral\Controllers\UsersController;
use Infinitops\Referral\Controllers\PatientsController;
use Infinitops\Referral\Controllers\ReferralsController;

require_once __DIR__ . "/vendor/autoload.php";

$router = new Router();

// Custom 404 Handler
$router->set404(function () {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    $notFound = file_get_contents("404.html");
    echo $notFound;
});
$router->get('/counties', function () {
    $counties = County::all();
    foreach ($counties as $county) {
        $subcounties = SubCounty::where('county_code', $county->code)->get();
        $county->sub_counties = $subcounties;
    }
    response(SUCCESS_RESPONSE_CODE, "Counties", $counties);
});
$router->get('/facilities', function () {
    $facilities = Facility::all();
    response(SUCCESS_RESPONSE_CODE, "Facilities", $facilities);
});
$router->get('/departments', function () {
    $departments = Department::all();
    response(SUCCESS_RESPONSE_CODE, "Departments", $departments);
});
$router->get('/insurances/all', function(){
    $insurances = Insurance::where('deleted', 0)->get();
    response(SUCCESS_RESPONSE_CODE, "Insurances", $insurances);
});
$router->mount('/user', function () use ($router) {
    $controller = new UsersController();
    //Get requests
    $router->get('/all', function () use ($controller) {
        $controller->getUsers();
    });
    $router->get('/user_categories', function () use ($controller) {
        $controller->getUserCategories();
    });
    
    // POST Requests
    $data = json_decode(file_get_contents('php://input'), true);
    $router->post('/create', function () use ($controller, $data) {
        $controller->createUser($data);
    });
    $router->post('/update/{id}', function ($id) use ($controller, $data) {
        $controller->updateUser($id, $data);
    });
    $router->post('/login', function () use ($controller, $data) {
        $controller->login($data);
    });
    $router->post('/register', function () use ($controller, $data) {
        $controller->register($data);
    });
    $router->post('/update_profile', function () use ($controller, $data) {
        $controller->updateUserProfile($data);
    });
    $router->post('/update_password', function () use ($controller, $data) {
        $controller->updatePassword($data);
    });
});
$router->mount('/patient', function () use ($router) {
    //GET
    $router->get('/all', function () {
        $controller = new PatientsController();
        $controller->getPatients();
    });
    $router->get('/search_by_identifier/{identifier}', function ($identifier) {
        $controller = new PatientsController();
        $controller->searchPatientByIdentifier($identifier);
    });
    $router->get('/search_patients/{searchString}', function($searchString){
        $controller = new PatientsController();
        $controller->searchPatient($searchString);
    });

    //POST
    $data = json_decode(file_get_contents('php://input'), true);
    $router->post('/create', function () use ($data) {
        $controller = new PatientsController();
        $controller->createPatient($data);
    });
    $router->post('/update/{id}', function ($id) use ($data) {
        $controller = new PatientsController();
        $controller->updatePatient($id, $data);
    });
});
$router->mount('/referral', function () use ($router) {
    $router->get('/all', function () {
        $controller = new ReferralsController();
        $controller->getReferrals();
    });

    //POST
    $data = json_decode(file_get_contents('php://input'), true);
    $router->post('/create', function () use ($data) {
        $controller = new ReferralsController();
        $controller->createReferral($data);
    });
    $router->post('/update/{id}', function ($id) use ($data) {
        $controller = new ReferralsController();
        $controller->updateReferral($id, $data);
    });
});

$router->get('/verify_session', function () {
    $controller = new UsersController();
    $controller->getLoggedInUser();
});


$router->all('/logout', function () {
    session_start();
    unset($_SESSION[$_ENV['SESSION_APP_NAME']]);
});


$router->mount('/web', function () use ($router) {
    $router->get('/get_map_data', function () {
        $controller = new WebController();
        response(200, "map_data", $controller->getMapData());
    });
    $router->post('/user_category/create', function () {
        $controller = new WebController();
        $data = json_decode(file_get_contents('php://input'), true);
        $controller->createUserCategory($data);
    });
    $router->post('/user_category/update/{id}', function ($id) {
        $controller = new WebController();
        $data = json_decode(file_get_contents('php://input'), true);
        $controller->updateUserCategory($id, $data);
    });
    $router->post('/patient/create', function () {
        $controller = new WebController();
        $data = json_decode(file_get_contents('php://input'), true);
        $controller->createPatient($data);
    });
    $router->post('/patient/update/{id}', function ($id) {
        $controller = new WebController();
        $data = json_decode(file_get_contents('php://input'), true);
        $controller->updatePatient($id, $data);
    });
    $router->post('/referral/update-status', function () {
        $controller = new WebController();
        $data = json_decode(file_get_contents('php://input'), true);
        $controller->updateReferralStatus($data);
    });
    $router->post('/user/create', function () {
        $controller = new WebController();
        $data = json_decode(file_get_contents('php://input'), true);
        $controller->createUser($data);
    });
    $router->post('/user/activate', function () {
        $controller = new WebController();
        $data = json_decode(file_get_contents('php://input'), true);
        $controller->activateUserAccount($data);
    });
    $router->post('/user/update/{id}', function ($id) {
        $controller = new WebController();
        $data = json_decode(file_get_contents('php://input'), true);
        $controller->updateUser($id, $data);
    });
    $router->post('/update_user_profile/{id}', function ($id) {
        $controller = new WebController();
        $data = json_decode(file_get_contents('php://input'), true);
        $controller->updateUserProfile($id, $data);
    });
    $router->post('/department/create', function () {
        $controller = new WebController();
        $data = json_decode(file_get_contents('php://input'), true);
        $controller->createDepartment($data);
    });
    $router->post('/department/update/{id}', function ($id) {
        $controller = new WebController();
        $data = json_decode(file_get_contents('php://input'), true);
        $controller->updateDepartment($id, $data);
    });

    $router->post('/insurance/create', function () {
        $controller = new WebController();
        $data = json_decode(file_get_contents('php://input'), true);
        $controller->createInsurance($data);
    });
    $router->post('/insurance/update/{id}', function ($id) {
        $controller = new WebController();
        $data = json_decode(file_get_contents('php://input'), true);
        $controller->updateInsurance($id, $data);
    });
    $router->post('/insurance/delete', function () {
        $controller = new WebController();
        $data = json_decode(file_get_contents('php://input'), true);
        $controller->deleteInsurance($data);
    });
    $router->post('/facility/create', function () {
        $controller = new WebController();
        $data = json_decode(file_get_contents('php://input'), true);
        $controller->createFacility($data);
    });
    $router->post('/facility/update/{id}', function ($id) {
        $controller = new WebController();
        $data = json_decode(file_get_contents('php://input'), true);
        $controller->updateFacility($id, $data);
    });
    $router->post('/request-otp', function () {
        $data = json_decode(file_get_contents('php://input'), true);
        WebController::requestOtp($data);
    });
});
$router->post('request-otp', function () {
    $data = json_decode(file_get_contents('php://input'), true);
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
        $sent = Utility::sendMail($recipients, "System OTP", "Hello {$user->first_name}, Your OTP for Systems backup is {$otp->pin }. The OTP expires at {$otp->expires_at} ");
        if(!$sent) throw new Exception("Error sending OTP");
        response(SUCCESS_RESPONSE_CODE, "OTP sent successfully");
    } catch (\Throwable $th) {
        Utility::logError($th->getCode(), $th->getMessage());
        response(PRECONDITION_FAILED_ERROR_CODE, $th->getMessage());
    }
});
$router->post('reset-password', function(){
    $data = json_decode(file_get_contents('php://input'), true);
    try{
        $attributes = ['phone_number', 'pin', 'password'];
        $missing = Utility::checkMissingAttributes($data, $attributes);
        throw_if(sizeof($missing) > 0, new \Exception("Missing parameters passed : " . json_encode($missing)));
        if(strlen($data['password']) < 6) throw new \Exception("The password is too short");
        $user = User::where('phone_number', $data['phone_number'])->first();
        if($user == null) throw new Exception("User does not exist");
        $otp = Otp::where('user_id', $user->id)->where('is_used', 0)->where('pin', $data['pin'])->where('expires_at', '>', date('Y-m-d H:i:s'))->first();
        if($otp == null) throw new Exception("Invalid|Expired OTP ");
        $user->update(['password' => password_hash($data['password'], PASSWORD_DEFAULT)]);
        $otp->is_used = 1;
        $otp->save();
        response(SUCCESS_RESPONSE_CODE, 'Password reset successfully');
    } catch(Throwable $th){
        Utility::logError($th->getCode(), $th->getMessage());
        response(PRECONDITION_FAILED_ERROR_CODE, $th->getMessage());
    }
});

// Thunderbirds are go!
$router->run();
