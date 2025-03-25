<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/SubCategoryController.php');

if ($_SESSION['role'] != 'admin') {
    header('Location: /StyleVerse/views/auth/login.php');
    exit;
}
$subCategoryController = new SubCategoryController($pdo);

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $subCategoryController->deleteSubCategory($_GET['id']);
    $_SESSION['message'] = 'Subcategory deleted successfully!';
    header('Location: manage_subcategory.php');
    exit;
}

$subcategories = $subCategoryController->getAllSubCategories();
?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?>
<link rel="stylesheet" href="/StyleVerse/assets/css/manage_category.css">

<div class="container">
    <h1>Manage Subcategories</h1>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert"><?= htmlspecialchars($_SESSION['message']) ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <a href="/StyleVerse/views/admin/add_subcategory.php" class="btn">Add New Sub Category</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Subcategory Name</th>
                <th>Description</th>
                <th>Image</th>
                <th>Parent Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($subcategories as $subcategory): ?>
                <tr>
                    <td><?= htmlspecialchars($subcategory['subcategory_id']) ?></td>
                    <td><?= htmlspecialchars($subcategory['subcategory_name']) ?></td>
                    <td><?= htmlspecialchars($subcategory['description']) ?></td>
                    <td>
                        <?php if (!empty($subcategory['image_url'])): ?>
                            <img src="/StyleVerse/assets/images/subcategories/<?= htmlspecialchars($subcategory['image_url']) ?>" alt="<?= htmlspecialchars($subcategory['subcategory_name']) ?>" width="50">
                        <?php else: ?>
                            No Image
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($subcategory['category_name']) ?></td>
                    <td>
                    <a href="/StyleVerse/views/admin/add_subcategory.php?id=<?= $subcategory['subcategory_id'] ?>" class="btn edit-btn">Edit</a>
                        <a href="manage_subcategory.php?action=delete&id=<?= $subcategory['subcategory_id'] ?>" class="btn delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php'; ?>
