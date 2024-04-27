<?php

require_once 'BaseDao.class.php';

class CustomerSupportDao extends BaseDao {
    public function __construct() {
        parent::__construct('customer_support');
    }

    public function addEmail($name, $email, $message) {
        $data = [
            'name' => $name,
            'email' => $email,
            'message' => $message
        ];
        return $this->add($data);
    }

    public function getAllEmails() {
        return $this->get_all();
    }
}

?>