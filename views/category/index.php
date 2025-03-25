<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/CategoryController.php');

// Check if the admin is logged in (if required)
// if (!isset($_SESSION['admin_id'])) {
//     header('Location: /StyleVerse/admin/login.php');
//     exit;
// }

// Initialize CategoryController
$categoryController = new CategoryController($pdo);

// Fetch all categories
$categories = $categoryController->getAllCategories();
?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?>
<link rel="stylesheet" href="/StyleVerse/assets/css/categories.css">
<div class="container">
    <h1>Categories</h1>

    <div class="categories-grid">
        <?php foreach ($categories as $category): ?>
            <div class="category-card">
                <h2><?= htmlspecialchars($category['name']) ?></h2>
                <p>Category ID: <?= $category['category_id'] ?></p>
                <?php if (!empty($category['image_url'])): ?>
                    <img src="/StyleVerse/assets/images/categories/<?= htmlspecialchars($category['image_url']) ?>" alt="<?= htmlspecialchars($category['name']) ?>">
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php'; ?>
