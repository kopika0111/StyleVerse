<?php
class Admin {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Create a new admin
    public function createAdmin($name, $email, $password) {
        $sql = "INSERT INTO admin (name, email, password) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Hash the password
        return $stmt->execute([$name, $email, $hashedPassword]);
    }

    // Read admin details by ID
    public function getAdminById($adminId) {
        $sql = "SELECT * FROM admin WHERE admin_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$adminId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Read admin details by email
    public function getAdminByEmail($email) {
        $sql = "SELECT * FROM admin WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update admin details
    public function updateAdmin($adminId, $name, $email, $password = null) {
        if ($password) {
            // Update with a new password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $sql = "UPDATE admin SET name = ?, email = ?, password = ? WHERE admin_id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$name, $email, $hashedPassword, $adminId]);
        } else {
            // Update without changing the password
            $sql = "UPDATE admin SET name = ?, email = ? WHERE admin_id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$name, $email, $adminId]);
        }
    }

    // Delete an admin
    public function deleteAdmin($adminId) {
        $sql = "DELETE FROM admin WHERE admin_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$adminId]);
    }

    // Authenticate admin login
    public function authenticateAdmin($email, $password) {
        $admin = $this->getAdminByEmail($email);
        if ($admin && password_verify($password, $admin['password'])) {
            return $admin; // Login successful, return admin details
        }
        return false; // Login failed
    }
}
