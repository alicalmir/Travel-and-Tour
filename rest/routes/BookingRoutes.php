<?php

require_once './dao/BookingDao.class.php';
require_once './services/UserServices.php';
require_once './services/BookingServices.php';

Flight::route('GET /booking/@id', function($id) {
    $bookingService = new BookingService(new BookingDao());
    try {
        $booking = $bookingService->getBooking($id);
        Flight::json($booking);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 404);
    }
});


Flight::route('GET /bookings', function() {
    $bookingService = new BookingService(new BookingDao());
    try {
        $bookings = $bookingService->getAllBookings();
        Flight::json($bookings);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('POST /add_booking', function() {
    $request = Flight::request();
    $data = $request->data->getData();

    $bookingService = new BookingService(new BookingDao());
    try {
        $booking = $bookingService->createBooking($data);
        Flight::json($booking);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('PUT /edit_booking/@id', function($id) {
    $data = Flight::request()->data->getData();
    
    $bookingService = new BookingService(new BookingDao());
    try {
        $success = $bookingService->updateBooking($id, $data);
        if ($success) {
            Flight::json(['message' => 'Booking updated successfully'], 200);
        } else {
            Flight::json(['message' => 'Failed to update booking'], 500);
        }
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 404);
    }
});

Flight::route('DELETE /delete_booking/@id', function($id) {
    $bookingService = new BookingService(new BookingDao());
    try {
        $success = $bookingService->deleteBooking($id);
        if ($success) {
            Flight::json(['message' => 'Booking deleted successfully'], 200);
        } else {
            Flight::json(['message' => 'Failed to delete booking'], 500);
        }
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 404);
    }
});

?>
