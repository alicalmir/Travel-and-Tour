<?php

require_once 'BaseDao.class.php';

class BookingDao extends BaseDao {
    public function __construct() {
        parent::__construct('bookings');
    }

    public function getBookingById($id) {
        return $this->get_by_id($id);
    }

    public function createBooking($booking) {
        return $this->add($booking);
    }

    public function getAllBookings() {
        return $this->get_all();
    }

    public function getBookingsByUserId($userId) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table_name WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateBooking($id, $data) {
        $name = $data['name'];
        $arrival_date = $data['arrival_date'];
        $quantity = $data['quantity'];
        $address = $data['address'];
    
        $stmt = $this->conn->prepare("UPDATE bookings SET name = ?, arrival_date = ?, quantity = ?, address = ? WHERE id = ?");
        $stmt->execute([$name, $arrival_date, $quantity, $address, $id]);
    
        return $stmt->rowCount() > 0;
    }

    public function deleteBooking($id) {
        $stmt = $this->conn->prepare("DELETE FROM bookings WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
?>
