<?php

require_once './dao/BookingDao.class.php';
require_once './services/UserServices.php';
require_once './services/BookingServices.php';

/**
 * @OA\Get(
 *      path="/booking/{id}",
 *      summary="Fetch individual booking",
 *      tags={"bookings"},
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          description="Booking ID",
 *          @OA\Schema(type="integer", format="int64")
 *      ),
 *      @OA\Response(
 *          response="404",
 *          description="Booking not found",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="error", type="string", example="Booking not found")
 *          )
 *      )
 * )
 */

Flight::route('GET /booking/@id', function($id) {
    $bookingService = new BookingService(new BookingDao());
    try {
        $booking = $bookingService->getBooking($id);
        Flight::json($booking);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 404);
    }
});

/**
 * @OA\Get(
 *      path="/bookings",
 *      summary="Fetch all bookings",
 *      tags={"bookings"},
 *      @OA\Response(
 *          response="404",
 *          description="Booking not found",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="error", type="string", example="Booking not found")
 *          )
 *      )
 * )
 */

Flight::route('GET /bookings', function() {
    $bookingService = new BookingService(new BookingDao());
    try {
        $bookings = $bookingService->getAllBookings();
        Flight::json($bookings);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

 /**
* @OA\Post(
*     path="/add_booking", 
*     description="Booking",
*     tags={"bookings"},
*     @OA\RequestBody(description="Booking", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*             @OA\Property(property="name", type="string", example="test",description="Booking name" ),
*             @OA\Property(property="email", type="string", example="test@hotmail.com",	description="Email" ),
*             @OA\Property(property="phone", type="numerical", example="123456789",	description="Phone number" ),
*             @OA\Property(property="address", type="string", example="Ulica 1",	description="Address" ),
*             @OA\Property(property="destination", type="string", example="New York",	description="destination" ),
*             @OA\Property(property="quantity", type="numerical", example="12345",	description="Number of guests" ),
*             @OA\Property(property="arrival_date", type="string", example="23.02.2018",	description="Arrival Date" ),
*             @OA\Property(property="departure_date", type="string", example="23.04.2019",	description="Departure Date" ),
*        )
*     )),
*     @OA\Response(
*         response=200,
*         description="Booking was successfull"
*     ),
*     @OA\Response(
*         response=500,
*         description="Error"
*     )
* )
*/
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

/**
 * @OA\Put(
 *      path="/edit_booking/{id}",
 *      summary="Update a booking",
 *      tags={"bookings"},
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          description="Booking ID",
 *          @OA\Schema(type="integer", format="int64")
 *      ),
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
*             @OA\Property(property="name", type="string", example="test",description="Booking name" ),
 *          )
 *      ),
 *      @OA\Response(
 *          response="200",
 *          description="Booking updated successfully",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="message", type="string", example="Booking updated successfully")
 *          )
 *      ),
 *      @OA\Response(
 *          response="404",
 *          description="Booking not found",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="error", type="string", example="Booking not found")
 *          )
 *      )
 * )
 */
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

/**
 * @OA\Delete(
 *      path="/delete_booking/{id}",
 *      summary="Delete a booking",
 *      tags={"bookings"},
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          description="Booking ID",
 *          @OA\Schema(type="integer", format="int64")
 *      ),
 *      @OA\Response(
 *          response="200",
 *          description="Booking deleted successfully",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="message", type="string", example="Booking deleted successfully")
 *          )
 *      ),
 *      @OA\Response(
 *          response="404",
 *          description="Booking not found",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="error", type="string", example="Booking not found")
 *          )
 *      )
 * )
 */

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
