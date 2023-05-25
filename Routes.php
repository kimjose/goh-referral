<?php

use Bramus\Router\Router;
use Infinitops\Referral\Models\County;
use Infinitops\Referral\Models\Facility;
use Infinitops\Referral\Models\SubCounty;
use Infinitops\Referral\Models\Department;
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
$router->get('/counties', function(){
    $counties = County::all();
    foreach($counties as $county) {
        $subcounties = SubCounty::where('county_code', $county->code)->get();
        $county->sub_counties = $subcounties;
    }
    response(SUCCESS_RESPONSE_CODE, "Counties", $counties);
});
$router->get('/facilities', function(){
    $facilities = Facility::all();
    response(SUCCESS_RESPONSE_CODE, "Facilities", $facilities);
});
$router->get('/departments', function(){
    $departments = Department::all();
    response(SUCCESS_RESPONSE_CODE, "Departments", $departments);
});
$router->mount('/user', function () use ($router) {
    $controller = new UsersController();
    //Get requests
    $router->get('/all', function () use ($controller) {
        $controller->getUsers();
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
});
$router->mount('/patient', function() use ($router) {
    //GET
    $router->get('/all', function () {
        $controller = new PatientsController();
        $controller->getPatients();
    });
    $router->get('/search_by_identifier/{identifier}', function ($identifier) {
        $controller = new PatientsController();
        $controller->searchPatientByIdentifier($identifier); 
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
$router->mount('/referral', function() use ($router){
    $router->get('/all', function(){
        $controller = new ReferralsController();
        $controller->getReferrals();
    });

    //POST
    $data = json_decode(file_get_contents('php://input'), true);
    $router->post('/create', function() use($data){
        $controller = new ReferralsController();
        $controller->createReferral($data);
    });
    $router->post('/update/{id}', function($id) use($data){
        $controller = new ReferralsController();
        $controller->updateReferral($id, $data);
    });
});

$router->get('/verify_session', function(){
    $controller = new UsersController();
    $controller->getLoggedInUser();
});


$router->all('/logout', function () {
    session_start();
    unset($_SESSION[$_ENV['SESSION_APP_NAME']]);
});

$router->mount('/web', function () use($router){
    $router->post('/patient/create', function () use($router){
        $controller = new WebController();
        $data = json_decode(file_get_contents('php://input'), true);
        $controller->createPatient($data);
    });
    $router->post('/patient/create/{id}', function ($id) use($router){
        $controller = new WebController();
        $data = json_decode(file_get_contents('php://input'), true);
        $controller->updatePatient($id, $data);
    });
});

// Thunderbirds are go!
$router->run();
