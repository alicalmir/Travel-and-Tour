<?php

require_once './services/UserServices.php';

Flight::route('POST /register', function() {
    $request = Flight::request();
    $data = $request->data->getData();

    $userService = new UserService(new UserDao());
    try {
        $user = $userService->register($data);
        Flight::json($user);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});


Flight::route('POST /login', function() {
    $request = Flight::request();
    $email = $request->data->email;
    $password = $request->data->password;

    $userService = new UserService(new UserDao());
    try {
        $jwt = $userService->login($email, $password);
        Flight::json(['token' => $jwt]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 401);
    }
});


Flight::route('GET /user/@id', function($id) {
    $userService = new UserService(new UserDao());
    try {
        $user = $userService->getUser($id);
        Flight::json($user);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 404);
    }
});

?>