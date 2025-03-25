<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once ($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');// Database configuration
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/UserController.php');  // Include User model

// Initialize variables
$error = '';
$success = '';
$name = '';
$email = '';
$password = '';
$confirmPassword = '';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);
    $role ='user';
    // Validate form inputs
    if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
        $error = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match.';
    } else {
        // Initialize User controller
        $userController = new UserController($pdo);

        // Check if the email is already registered
        if ($userController->getUserByEmail($email)) {
            $error = 'This email is already registered.';
        } else {
            // Create a new user
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $isCreated = $userController->registerUser($name, $email, $hashedPassword,$role);

            if ($isCreated) {
                $success = 'Registration successful. You can now <a href="login.php">log in</a>.';
                // Clear the form fields
                $name = $email = $password = $confirmPassword = '';
            } else {
                $error = 'An error occurred. Please try again.';
            }
        }
    }
}
?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?> <!-- Include the header -->
<link rel="stylesheet" href="/StyleVerse/assets/css/register.css"> <!-- Update path to your CSS -->
<div class="register-container">
    <h2>Register</h2>
    <?php if (!empty($error)): ?>
        <p class="error-message"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
        <p class="success-message"><?= $success ?></p>
    <?php endif; ?>
    <form method="POST" action="register.php">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn">Register</button>
    </form>
    <p class="login-link">
        Already have an account? <a href="login.php">Log in here</a>.
    </p>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php'; ?> <!-- Include the footer -->
