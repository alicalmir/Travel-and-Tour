<?php

require_once './dao/BookingDao.class.php';

class BookingService {
    protected $bookingDao;

    public function __construct(BookingDao $bookingDao) {
        $this->bookingDao = $bookingDao;
    }

    public function getBooking($id) {
        $booking = $this->bookingDao->getBookingById($id);

        if (!$booking) {
            throw new Exception("Booking not found.");
        }

        return $booking;
    }

    public function createBooking($data) {
        // Create a new booking in the database
        $booking = $this->bookingDao->createBooking($data);
        return $booking;
    }

    public function getUserBookings($userId) {
        $bookings = $this->bookingDao->getBookingsByUserId($userId);
        return $bookings;
    }

    public function getAllBookings() {
        $bookings = $this->bookingDao->getAllBookings();

        return $bookings;
    }

    public function updateBooking($id, $data) {
        $booking = $this->bookingDao->getBookingById($id);

        if (!$booking) {
            throw new Exception("Booking not found.");
        }

        // Update the booking data
        if (isset($data['name'])) {
            $booking['name'] = $data['name'];
        }
        if (isset($data['email'])) {
            $booking['email'] = $data['email'];
        }
        if (isset($data['phone'])) {
            $booking['phone'] = $data['phone'];
        }
        if (isset($data['address'])) {
            $booking['address'] = $data['address'];
        }
        if (isset($data['destination'])) {
            $booking['destination'] = $data['destination'];
        }
        if (isset($data['quantity'])) {
            $booking['quantity'] = $data['quantity'];
        }
        if (isset($data['arrival_date'])) {
            $booking['arrival_date'] = $data['arrival_date'];
        }
        if (isset($data['departure_date'])) {
            $booking['departure_date'] = $data['departure_date'];
        }

        // Save the updated booking in the database
        $updatedBooking = $this->bookingDao->updateBooking($id, $booking);

        return $updatedBooking;
    }

    public function deleteBooking($id) {
        $booking = $this->bookingDao->getBookingById($id);
    
        if (!$booking) {
            throw new Exception("Booking not found.");
        }
    
        // Delete the booking from the database
        $deleted = $this->bookingDao->deleteBooking($id);
    
        if ($deleted) {
            return true;
        } else {
            throw new Exception("Failed to delete booking.");
        }
    }
}

?>
