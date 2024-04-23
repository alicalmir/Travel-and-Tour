<?php

require_once './dao/UserDao.class.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class UserService {
    protected $userDao;

    public function __construct(UserDao $userDao) {
        $this->userDao = $userDao;
    }

    public function register($data) {
        // Check if email already exists
        $email = $data['email'];
        $existingUser = $this->userDao->getUserByEmail($email);
        if ($existingUser) {
            throw new Exception("Email already exists.");
        }

        // Hash password
        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        // Save user to database
        $data['password'] = $password;
        $user = $this->userDao->add($data);

        return $user;
    }

    public function login($email, $password) {
        $user = $this->userDao->getUserByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            throw new Exception("Invalid email or password.");
        }

        // Generate JWT token
        $jwt_secret = Flight::get('jwt_secret');
        $payload = array(
            "user_id" => $user['id'],
            "email" => $user['email']
        );
        $jwt = JWT::encode($payload, $jwt_secret, 'HS256');

        return $jwt;
    }

    public function getUser($id) {
        $user = $this->userDao->getById($id);

        if (!$user) {
            throw new Exception("User not found.");
        }

        return $user;
    }
}
?>