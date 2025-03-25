<?php
// Database configuration
$dbHost = 'localhost'; // Hostname of your database server
$dbName = 'styleverse'; // Name of your database
$dbUser = 'root';      // Database username (default for XAMPP/WAMP)
$dbPass = '';          // Database password (leave empty for XAMPP/WAMP)

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode
} catch (PDOException $e) {
    // Handle connection errors
    die("Database connection failed: " . $e->getMessage());
}
?>