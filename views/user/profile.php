<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/UserController.php');

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: /StyleVerse/views/auth/login.php");
    exit();
}

// Initialize UserController
$userController = new UserController($pdo);

$user_id = $_SESSION['id'];

// Fetch user details
$user = $userController->getUserById($user_id);

// Handle profile update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Handle profile picture upload
    $profile_picture = $user['profile_picture']; // Keep existing picture if not updated
    if (!empty($_FILES["profile_picture"]["name"])) {
        $target_dir = $_SERVER['DOCUMENT_ROOT']."/StyleVerse/assets/images/profiles/";

        $extension = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
        $image_name = uniqid() . '.' .$extension;
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            $profile_picture = $image_name;
        }
    }

    // Update user details in the database
    $data = [
        'name' => $name,
        'profile' => $profile_picture,
        'email' => $email,
        'address' => $address,
        'phone' => $phone,
        'password' => $password,
        'role' => $_SESSION['role'],
        'userId' => $user_id
    ];

    $userController->updateUser($data);

    $_SESSION['name'] = $name; // Update session name
    $_SESSION['profile_picture'] = $profile_picture; // Update session profile
    header("Location: profile.php?success=1");
    exit();
}
?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?>

<link rel="stylesheet" href="/StyleVerse/assets/css/profile.css">

<div class="profile-container">
    <h1>My Profile</h1>

    <?php if (isset($_GET['success'])): ?>
        <p class="success-msg">Profile updated successfully!</p>
    <?php endif; ?>

    <form action="profile.php" method="POST" enctype="multipart/form-data">
        <div class="profile-pic">
            <img src="/StyleVerse/assets/images/profiles/<?= $user['profile_picture'] ?? 'default.png' ?>" alt="Profile Picture">
            <input type="file" name="profile_picture" accept="image/*">
        </div>

        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>"  required>

        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" placeholder="Leave blank to keep current password">

        <label>Phone:</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">

        <label>Address:</label>
        <textarea name="address"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>

        <button type="submit">Update Profile</button>
    </form>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php'; ?>
