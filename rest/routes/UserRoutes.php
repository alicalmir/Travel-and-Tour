<?php

require_once './services/UserServices.php';

 /**
* @OA\Post(
*     path="/register", 
*     description="Register",
*     tags={"users"},
*     @OA\RequestBody(description="Register", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*             @OA\Property(property="email", type="string", example="demo@gmail.com",description="Student email" ),
*             @OA\Property(property="password", type="string", example="12345",	description="Password" ),
*             @OA\Property(property="name", type="string", example="Test",	description="First and Last Name" )

*        )
*     )),
*     @OA\Response(
*         response=200,
*         description="Registered successfuly"
*     ),
*     @OA\Response(
*         response=500,
*         description="Error"
*     )
* )
*/
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

 /**
* @OA\Post(
*     path="/login", 
*     description="Login",
*     tags={"users"},
*     @OA\RequestBody(description="Login", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*             @OA\Property(property="email", type="string", example="demo@gmail.com",	description="Student email" ),
*             @OA\Property(property="password", type="string", example="12345",	description="Password" ),
*        )
*     )),
*     @OA\Response(
*         response=200,
*         description="Logged in successfuly"
*     ),
*     @OA\Response(
*         response=500,
*         description="Error"
*     )
* )
*/
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

/**
 * @OA\Get(
 *      path="/user/{id}",
 *      summary="Fetch individual user",
 *      tags={"users"},
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          description="User ID",
 *          @OA\Schema(type="integer", format="int64")
 *      ),
 *      @OA\Response(
 *          response="404",
 *          description="User not found",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="error", type="string", example="User not found")
 *          )
 *      )
 * )
 */

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