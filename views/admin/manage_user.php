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

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action === 'delete') {
            // Delete a user
            $userController->deleteUser($_POST['user_id']);
        } elseif ($action === 'update') {
            // Update a user's information
            $userController->updateUser($_POST['user_id'], $_POST);
        }
    }
}

// Fetch all users
$users = $userController->getAllUsers();
?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?>
<link rel="stylesheet" href="/StyleVerse/assets/css/manage_category.css">

<div class="container">
    <h1>Manage Users</h1>

    <a href="/StyleVerse/views/admin/add_user.php" class="btn">Add New User</a>

    <!-- User List -->
    <h2>All Users</h2>
    <table class="table">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Registered At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['user_id'] ?></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= $user['created_at'] ?></td>
                    <td>
                        <a href="/StyleVerse/views/admin/add_user.php?edit=<?= $user['user_id'] ?>" class="btn edit-btn">Edit</a>
                        <a href="manage_user.php?action=delete&id=<?= $user['user_id'] ?>" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php'; ?>
