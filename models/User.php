<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Create a new user
    public function createUser($name, $email, $hashedPassword, $role) {
        $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$name, $email, $hashedPassword, $role]);
    }

    public function getAllUsers() {
        $sql = "SELECT * FROM users";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Read user details by ID
    public function getUserById($userId) {
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Read user details by email
    public function getUserByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByEmailAndPassword($email , $password) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        // $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user && password_verify($password, $user['password'])) {
            return $user;
        }

    }

    public function insertUser($data) {
        // Start building the query
        $query = "INSERT INTO users (name, email, role, address, phone";

        // Array to store parameters
        $params = [
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':role' => $data['role'],
            ':address' => $data['address'],
            ':phone' => $data['phone']
        ];

        // Check if password is provided
        if (!empty($data['password'])) {
            $query .= ", password";
            $params[':password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        // Check if profile picture is provided
        if (!empty($data['profile'])) {
            $query .= ", profile_picture";
            $params[':profile'] = $data['profile'];
        }

        // Complete the query with placeholders
        $query .= ") VALUES (:name, :email, :role, :address, :phone";

        if (!empty($data['password'])) {
            $query .= ", :password";
        }
        if (!empty($data['profile'])) {
            $query .= ", :profile";
        }

        $query .= ")";

        // Prepare the query
        $stmt = $this->pdo->prepare($query);

        // Execute the statement with the correct parameters
        return $stmt->execute($params);
    }


    // Update user details
    public function updateUser1($userId, $name, $email) {
        $sql = "UPDATE users SET name = ?, email = ? WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$name, $email, $userId]);
    }

    public function updateUser($data) {
        // Start building the query
        $query = "UPDATE users SET name = :name, email = :email, role = :role, address = :address, phone = :phone";

        // Array to store parameters
        $params = [
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':role' => $data['role'],
            ':address' => $data['address'],
            ':phone' => $data['phone'],
            ':id' => $data['userId']
        ];

        // Check if password is provided
        if (!empty($data['password'])) {
            $query .= ", password = :password";
            $params[':password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        // Check if profile is provided
        if (!empty($data['profile'])) {
            $query .= ", profile_picture = :profile";
            $params[':profile'] = $data['profile'];
        }

        // Complete the query with the WHERE clause
        $query .= " WHERE user_id = :id";

        // Prepare the query
        $stmt = $this->pdo->prepare($query);

        // Execute the statement with the correct parameters
        return $stmt->execute($params);
    }

    // Delete a user
    public function deleteUser($userId) {
        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$userId]);
    }
    public function getUserCount() {
        $sql = "SELECT COUNT(*) AS user_count FROM users"; // Alias the count
        $stmt = $this->pdo->query($sql); // Execute the query
        $result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch as associative array
        return $result['user_count']; // Return the count
    }

    public function getRecentActivities() {
        $query = "
            (SELECT 'users' AS table_name, user_id AS record_id, name AS details, 'New user registered' AS activity, created_at AS timestamp
             FROM users ORDER BY created_at DESC LIMIT 5)
            UNION ALL
            (SELECT 'orders', CONCAT('#', o.order_id, ' placed by ') as order_id, name, 'Order', o.order_date
             FROM orders o
             LEFT JOIN users u
             ON o.user_id = u.user_id
             ORDER BY order_date DESC LIMIT 5)
            UNION ALL
            (SELECT 'products', product_id, name, 'New product added', created_at
             FROM products ORDER BY created_at DESC LIMIT 5)
             UNION ALL
            (SELECT 'categories', category_id, name, 'New category added', created_at
             FROM categories ORDER BY created_at DESC LIMIT 5)
            ORDER BY timestamp DESC LIMIT 10;
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}