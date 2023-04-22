<?php

use Bramus\Router\Router;
use Infinitops\Referral\Controllers\PatientsController;
use Infinitops\Referral\Controllers\UsersController;
use Infinitops\Referral\Models\County;
use Infinitops\Referral\Models\SubCounty;

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
$router->get('/verify_session', function(){
    $controller = new UsersController();
    $controller->getLoggedInUser();
});





$router->all('/logout', function () {
    session_start();
    unset($_SESSION[$_ENV['SESSION_APP_NAME']]);
});

// Thunderbirds are go!
$router->run();
