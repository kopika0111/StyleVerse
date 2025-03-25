<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/SubCategoryController.php');

// Check if the admin is logged in (optional)
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: /StyleVerse/views/auth/login.php'); // Redirect to admin login page
    exit();
}

$subCategoryController = new SubCategoryController($pdo);
$categories = $subCategoryController->getCategories();

// Initialize variables
$subcategoryId = $name = $description = $imageUrl = $categoryId = '';
$errors = [];
$updateMode = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subcategoryId = $_POST['subcategory_id'] ?? null;
    $name = $_POST['name'];
    $categoryId = $_POST['category_id'];
    $description = $_POST['description'];

    // Handle image upload
    $imageUrl = null;
    if (!empty($_FILES['image_file']['name'])) {
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/StyleVerse/assets/images/subcategories/';
        $extension = pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION);
        $imageName = uniqid() . '.' .$extension;
        $targetFile = $targetDir . $imageName;
        move_uploaded_file($_FILES['image_file']['tmp_name'], $targetFile);
    }

    if ($subcategoryId) {
        $updateMode = true;
        $subCategoryController->updateSubCategory($subcategoryId, $name, $categoryId, $description, $imageName);
        $_SESSION['message'] = 'Subcategory updated successfully!';
    } else {
        $subCategoryController->addSubCategory($name, $categoryId, $description, $imageName);
        $_SESSION['message'] = 'Subcategory added successfully!';
    }

    header('Location: manage_subcategory.php');
    exit;
}

// Fetch sub category details if updating
if (isset($_GET['id'])) {
    $subcategoryId = intval($_GET['id']);
    $subcategory = $subCategoryController->getSubCategoriesById($subcategoryId);

    if ($subcategory) {
        $name = $subcategory['subcategory_name'];
        $description = $subcategory['description'];
        $imageUrl = $subcategory['image_url'];
        $categoryId = $subcategory['category_id'];
        $updateMode = true;
    } else {
        $_SESSION['error'] = "Sub Category not found.";
        header('Location: manage_subcategory.php');
        exit();
    }
}
?>


<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?>
<link rel="stylesheet" href="/StyleVerse/assets/css/add_product.css">

<div class="add-container">
    <h1><?= $updateMode ? 'Update Sub Category' : 'Add Sub Category' ?></h1>
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert"><?= htmlspecialchars($_SESSION['message']) ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <form action="" method="POST" class="subcategory-form" enctype="multipart/form-data">
            <input type="hidden" name="subcategory_id" id="subcategory_id" value="<?= htmlspecialchars($subcategoryId) ?>">
            <div class="form-group">
                <label for="name">Subcategory Name:</label>
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($name) ?>" required>
            </div>
            <div class="form-group">
                <label for="category_id">Parent Category:</label>
                <select name="category_id" id="category_id" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['category_id']) ?>" <?= $categoryId == $category['category_id'] ? 'selected' : '' ?>><?= htmlspecialchars($category['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description" rows="3" required><?= htmlspecialchars($description) ?></textarea>
            </div>
            <div class="form-group">
                <label for="image_file">Image:</label>
                <input type="file" name="image_file" id="image_file" <?= $updateMode ? '' : 'required' ?>>
            </div>

            <?php if ($updateMode && $imageUrl): ?>
                <div class="current-image">
                    <p>Current Image:</p>
                    <img src="/StyleVerse/assets/images/subcategories/<?= htmlspecialchars($imageUrl) ?>" alt="Sub Category Image">
                </div>
            <?php endif; ?>

            <button type="submit"><?= $updateMode ? 'Update' : 'Add' ?> Sub Category</button>
        </form>
    </div>

    <?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php'; ?>