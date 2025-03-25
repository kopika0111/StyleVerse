<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/models/Admin.php');

class AdminController {
    private $adminModel;

    public function __construct($pdo) {
        $this->adminModel = new Admin($pdo);
    }

    public function addAdmin($data) {
        return $this->adminModel->createAdmin($data);
    }

    public function loginAdmin($email, $password) {
        return $this->adminModel->authenticateAdmin($email, $password);
    }
}
?>
