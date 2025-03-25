<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/UserController.php');

// Check if the admin is logged in
if ($_SESSION['role'] != 'admin') {
    header('Location: /StyleVerse/views/auth/login.php');
    exit;
}
// Initialize UserController
$userController = new UserController($pdo);

// Initialize variables
$user_id = $name = $email = $phone = $address = $role = $image_name = "";
$update = false;

// Check if editing an existing user
if (isset($_GET['edit'])) {
    $user_id = $_GET['edit'];

    $user = $userController->getUserById($user_id);

    if ($user) {
        $name = $user['name'];
        $email = $user['email'];
        $phone = $user['phone'];
        $address = $user['address'];
        $role = $user['role'];
        $profile_picture = $user['profile_picture'];
        $update = true;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $profile = isset($_FILES['profile']) ? $_FILES['profile']['name'] : null;
    $profile = isset($_FILES['profile']) ? $_FILES['profile']['name'] : null;

    // Handle profile upload
    if ($profile) {
        $target_dir = $_SERVER['DOCUMENT_ROOT']."/StyleVerse/assets/images/profiles/";

        $extension = pathinfo($_FILES['profile']['name'], PATHINFO_EXTENSION);
        $image_name = uniqid() . '.' .$extension;
        $target_file = $target_dir . $image_name;
        move_uploaded_file($_FILES["profile"]["tmp_name"], $target_file);
    }

    $data = [
            'name' => $name,
            'profile' => $image_name,
            'email' => $email,
            'address' => $address,
            'phone' => $phone,
            'password' => $password,
            'role' => $role
        ];
    if (!empty($_POST['user_id'])) {
        // UPDATE user;
        $data['userId'] = $_POST['user_id'];

        $userController->updateUser($data);
    } else {
        // INSERT new user
        $userController->insertUser($data);
    }

    if($_SESSION['id'] == $_POST['user_id']) {
        $_SESSION['name'] = $name; // Update session name
        $_SESSION['profile_picture'] = $profile_picture; // Update session profile
        $_SESSION['role'] = $role;
    }
    header("Location: manage_user.php"); // Refresh page
}
?>

<link rel="stylesheet" href="/StyleVerse/assets/css/add_product.css">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Form</title>
</head>
<body>
<div class="add-container">
    <h2><?= $update ? 'Update' : 'Add' ?> User</h2>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="profile-pic">
            <img src="/StyleVerse/assets/images/profiles/<?= $profile_picture ?? 'default.png' ?>" alt="Profile Picture">
        </div>
        <input type="hidden" name="user_id" value="<?= $user_id ?>">

        <label>Name:</label>
        <input type="text" name="name" value="<?= $name ?>" required><br>

        <div class="form-group">
                <label for="role">Role:</label>
                <select name="role" id="role" required>
                    <option value="">Select Role</option>
                        <option value="admin" <?= $role == 'admin' ? 'selected' : '' ?>> Admin </option>
                        <option value="user" <?= $role == 'user' ? 'selected' : '' ?>> User </option>
                </select>
            </div>

        <label>Email:</label>
        <input type="email" name="email" value="<?= $email ?>" required><br>

        <label>Phone:</label>
        <input type="text" name="phone" value="<?= $phone ?>"><br>

        <label>Address:</label>
        <textarea name="address"><?= $address ?></textarea><br>

        <label>Password:</label>
        <input type="password" name="password" <?= $update ? '' : 'required' ?>><br>

        <label>Profile Picture:</label>
        <input type="file" name="profile"><br>

        <button type="submit"><?= $update ? 'Update' : 'Add' ?> User</button>
    </form>
</div>


</body>
</html>
