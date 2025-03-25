<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once ($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');// Database configuration
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/AdminController.php');  // Include User model

// Initialize variables
$error = '';
$email = '';
$password = '';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate form inputs
    if (empty($email) || empty($password)) {
        $error = 'Please fill in both fields.';
    } else {
        // Initialize User model
        $adminController = new AdminController($pdo);

        // Authenticate user
        $admin = $adminController->loginAdmin($email, $password);
        if ($admin) {
            // Set session variables
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_name'] = $admin['username'];
            $_SESSION['admin_email'] = $admin['email'];

            // Redirect to the homepage
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Invalid email or password.';
        }
    }
}
?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?> <!-- Include the header -->
<link rel="stylesheet" href="/StyleVerse/assets/css/login.css"> <!-- Update the path to your CSS -->
<div class="login-container">
    <h2>Login</h2>
    <?php if (!empty($error)): ?>
        <p class="error-message"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="login.php">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn">Login</button>
    </form>
    <p class="register-link">
        Don't have an account? <a href="register.php">Register here</a>.
    </p>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php'; ?> <!-- Include the footer -->

