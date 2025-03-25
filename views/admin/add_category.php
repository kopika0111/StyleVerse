<?php
// Start the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include necessary files
require_once($_SERVER['DOCUMENT_ROOT'] . '/StyleVerse/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/StyleVerse/controllers/CategoryController.php');

// Check if the admin is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: /StyleVerse/views/auth/login.php'); // Redirect to admin login page
    exit();
}

$name = $imageUrl = $categoryId = '';
$errors = [];
// Initialize CategoryController
$categoryController = new CategoryController($pdo);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryId = $_POST['category_id'] ?? null;
    $name = $_POST['name'];
    $description = $_POST['description'] ?? null;

    // Handle image upload
    $imageName = null;
    if (!empty($_FILES['image_file']['name'])) {
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/StyleVerse/assets/images/categories/';
        $extension = pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION);
        $imageName = uniqid() . '.' .$extension;
        $targetFile = $targetDir . $imageName;

        // Move the uploaded file to the target directory
        if (!move_uploaded_file($_FILES['image_file']['tmp_name'], $targetFile)) {
            $_SESSION['error'] = 'Failed to upload the image.';
            header('Location: add_category.php');
            exit;
        }
    }

    if ($categoryId) {
        // Update category
        $categoryController->updateCategory($categoryId, $name, $imageName);
        $_SESSION['message'] = 'Category updated successfully!';
    } else {
        // Add new category
        $categoryController->addCategory($name, $imageName);
        $_SESSION['message'] = 'Category added successfully!';
    }

    header('Location: manage_category.php');
    exit;
}

// Fetch category details if updating
if (isset($_GET['id'])) {
    $categoryId = intval($_GET['id']);
    $category = $categoryController->getCategoryById($categoryId);

    if ($category) {
        $name = $category['name'];
        $imageUrl = $category['image_url'];
        $categoryId = $category['category_id'];
    } else {
        $_SESSION['error'] = "Category not found.";
        header('Location: manage_category.php');
        exit();
    }
}
?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/StyleVerse/views/partials/header.php'; ?>
<link rel="stylesheet" href="/StyleVerse/assets/css/add_product.css">

<div class="add-container">
    <h1><?= $categoryId ? 'Update Category' : 'Add Category' ?></h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Add Category Form -->
    <form action="" method="POST" enctype="multipart/form-data" class="category-form">
        <input type="hidden" name="category_id" id="category_id" value="<?= htmlspecialchars($categoryId) ?>">
        <div class="form-group">
            <label for="name">Category Name:</label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($name) ?>" required>
        </div>
        <div class="form-group">
            <label for="image_file">Category Image:</label>
            <input type="file" name="image_file" id="image_file" accept="image/*" <?= $categoryId ? '' : 'required' ?>>
        </div>

        <?php if ($categoryId && $imageUrl): ?>
                <div class="current-image">
                    <p>Current Image:</p>
                    <img src="/StyleVerse/assets/images/categories/<?= htmlspecialchars($imageUrl) ?>" alt="Sub Category Image">
                </div>
            <?php endif; ?>
        <button type="submit"><?= $categoryId ? 'Update' : 'Add' ?> Category</button>
    </form>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/StyleVerse/views/partials/footer.php'; ?>
