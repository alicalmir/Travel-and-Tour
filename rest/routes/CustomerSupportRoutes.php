<?php

require_once './services/CustomerServices.php';


// Route to add a new support email
Flight::route('POST /customer-support', function() {
    $name = Flight::request()->data->name;
    $email = Flight::request()->data->email;
    $message = Flight::request()->data->message;

    $customerSupportService = new CustomerSupportService(new CustomerSupportDao());
    $emailId = $customerSupportService->addEmail($name, $email, $message);

    Flight::json(['emailId' => $emailId]);
});


// Route to get all support emails
Flight::route('GET /customer-support', function() {
    $customerSupportService = new CustomerSupportService(new CustomerSupportDao());
    $emails = $customerSupportService->getAllEmails();

    Flight::json(['emails' => $emails]);
});

?>
