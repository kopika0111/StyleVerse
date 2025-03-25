<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/CategoryController.php');

// Check if the admin is logged in
if ($_SESSION['role'] != 'admin') {
    header('Location: /StyleVerse/views/auth/login.php');
    exit;
}

// Initialize CategoryController
$categoryController = new CategoryController($pdo);

// Handle form submissions for adding or updating a category
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $categoryId = $_POST['category_id'] ?? null;

    // Handle image upload
    $imagePath = null;
    if (!empty($_FILES['image_file']['name'])) {
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/StyleVerse/assets/images/categories/';
        $extension = pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION);
        $imagePath = uniqid() . '.' .$extension;
        $targetFile = $targetDir . $imagePath;

        if (move_uploaded_file($_FILES['image_file']['tmp_name'], $targetFile)) {
            $imagePath = $imagePath;
        } else {
            $imagePath = null; // Set to null if upload fails
        }
    }

    if ($categoryId) {
        // Update category
        $categoryController->updateCategory($categoryId, $name, $imagePath);
        $_SESSION['message'] = 'Category updated successfully!';
    } else {
        // Add new category
        $categoryController->addCategory($name, $imagePath);
        $_SESSION['message'] = 'Category added successfully!';
    }

    header('Location: manage_category.php');
    exit;
}

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $categoryController->deleteCategory($_GET['id']);
    $_SESSION['message'] = 'Category deleted successfully!';
    header('Location: manage_category.php');
    exit;
}

// Fetch all categories
$categories = $categoryController->getAllCategories();
?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?>
<link rel="stylesheet" href="/StyleVerse/assets/css/manage_category.css">

<div class="container">
    <h1>Manage Categories</h1>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert"><?= htmlspecialchars($_SESSION['message']) ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <a href="/StyleVerse/views/admin/add_category.php" class="btn">Add New Product</a>

    <!-- Category Table -->
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= htmlspecialchars($category['category_id']) ?></td>
                    <td><?= htmlspecialchars($category['name']) ?></td>
                    <td>
                        <?php if (!empty($category['image_url'])): ?>
                            <img src="/StyleVerse/assets/images/categories/<?= htmlspecialchars($category['image_url']) ?>" alt="<?= htmlspecialchars($category['name']) ?>" width="50">
                        <?php else: ?>
                            No Image
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="/StyleVerse/views/admin/add_category.php?id=<?= $category['category_id'] ?>" class="btn edit-btn">Edit</a>
                        <a href="manage_category.php?action=delete&id=<?= $category['category_id'] ?>" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php'; ?>
