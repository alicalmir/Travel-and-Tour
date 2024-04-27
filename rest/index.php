<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header("Access-Control-Allow-Headers: Content-Type, Authorization, userToken");

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require "./vendor/autoload.php";
require "services/UserServices.php";
require "services/BookingServices.php";
require "services/TodoServices.php";
require "services/CustomerServices.php";
require "services/FavouriteServices.php";

Flight::register('user_services', "UserServices");
Flight::register('booking_services', "BookingServices");
Flight::register('todo_services', "TodoServices");
Flight::register('customer_services', "CustomerServices");
Flight::register('favourite_services', "FavouriteServices");

require_once "routes/UserRoutes.php";
require_once "routes/BookingRoutes.php";
require_once "routes/TodoRoutes.php";
require_once "routes/CustomerSupportRoutes.php";
require_once "routes/FavouriteRoutes.php";

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('HTTP/1.1 200 OK');
    exit;
}

$secretKey = bin2hex(random_bytes(32));
Flight::set('jwt_secret', $secretKey);

// Middleware to verify JWT token
Flight::route('/*', function() {
    $request = Flight::request();
    $data = $request->data->getData();
    $path = Flight::request()->url;
    if ($path == '/login' || $path == '/docs.json') return TRUE; 

    $bookingService = new BookingService(new BookingDao());
    try {
        $booking = $bookingService->createBooking($data);
        Flight::json($booking);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

 /*REST API documentation endpoint 
Flight::route('GET /docs.json', function(){
    $openapi = \OpenApi\scan('routes');
    header('Content-Type: application/json');
    echo $openapi->toJson();
});*/

Flight::start();

?>
