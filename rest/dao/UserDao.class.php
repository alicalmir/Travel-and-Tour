<?php

require_once 'BaseDao.class.php';

class UserDao extends BaseDao {
    public function __construct() {
        parent::__construct('users');
    }

    public function getUserByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table_name WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table_name WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}

?>
