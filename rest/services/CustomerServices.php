<?php

require_once './dao/CustomerSupport.class.php';

class CustomerSupportService {
    protected $customerSupportDao;

    public function __construct(CustomerSupportDao $customerSupportDao) {
        $this->customerSupportDao = $customerSupportDao;
    }

    public function addEmail($name, $email, $message) {
        return $this->customerSupportDao->addEmail($name, $email, $message);
    }

    public function getAllEmails() {
        return $this->customerSupportDao->getAllEmails();
    }
}

?>