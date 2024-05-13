<?php

require_once './services/CustomerServices.php';

/**
 * @OA\Post(
 *      path="/customer-support",
 *      summary="Add a new support email",
 *      tags={"customer-support"},
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="name", type="string", example="John Doe"),
 *              @OA\Property(property="email", type="string", example="john@example.com"),
 *              @OA\Property(property="message", type="string", example="This is a support message.")
 *          )
 *      ),
 *      @OA\Response(
 *          response="200",
 *          description="Support email added successfully",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="emailId", type="integer", example=1)
 *          )
 *      )
 * )
 */

// Route to add a new support email
Flight::route('POST /customer-support', function() {
    $name = Flight::request()->data->name;
    $email = Flight::request()->data->email;
    $message = Flight::request()->data->message;

    $customerSupportService = new CustomerSupportService(new CustomerSupportDao());
    $emailId = $customerSupportService->addEmail($name, $email, $message);

    Flight::json(['emailId' => $emailId]);
});

/**
 * @OA\Get(
 *      path="/customer-support",
 *      summary="Get all support emails",
 *      tags={"customer-support"},
 *      @OA\Response(
 *          response="200",
 *          description="List of support emails",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(
 *                  property="emails",
 *                  type="array",
 *                  @OA\Items(
 *                      type="object",
 *                      @OA\Property(property="emailId", type="integer", example=1),
 *                      @OA\Property(property="name", type="string", example="John Doe"),
 *                      @OA\Property(property="email", type="string", example="john@example.com"),
 *                      @OA\Property(property="message", type="string", example="This is a support message.")
 *                  )
 *              )
 *          )
 *      )
 * )
 */

// Route to get all support emails
Flight::route('GET /customer-support', function() {
    $customerSupportService = new CustomerSupportService(new CustomerSupportDao());
    $emails = $customerSupportService->getAllEmails();

    Flight::json(['emails' => $emails]);
});

?>
