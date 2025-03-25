<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/models/User.php');  // Include User model

class UserController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }

    public function registerUser($name, $email, $hashedPassword,$role){
        return $this->userModel->createUser($name, $email, $hashedPassword,$role);
    }

    public function loginUser($email, $password) {
        return $this->userModel->getUserByEmailAndPassword($email, $password);
    }

    public function getAllUsers() {
        return $this->userModel->getAllUsers();
    }

    public function insertUser($data) {
        return $this->userModel->insertUser($data);
    }

    public function updateUser($data) {
        return $this->userModel->updateUser($data);
    }

    public function deleteUser($userId) {
        return $this->userModel->deleteUser($userId);
    }

    public function getUserById($userId) {
        return $this->userModel->getUserById($userId);
    }

    public function getUserCount() {
        return $this->userModel->getUserCount();
    }

    public function getRecentActivities() {
        return $this->userModel->getRecentActivities();
    }

    public function getUserByEmail($email) {
        return $this->userModel->getUserByEmail($email);
    }

}
?>
