<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/ProductController.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/CategoryController.php');

// Check if the admin is logged in
if ($_SESSION['role'] != 'admin') {
    header('Location: /StyleVerse/views/auth/login.php');
    exit;
}

// Initialize controllers
$productController = new ProductController($pdo);
$categoryController = new CategoryController($pdo);


// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action === 'add') {
            // Add a new product
            $productController->addProduct($_POST, $_FILES['image']);
        } elseif ($action === 'edit') {
            // Edit an existing product
            $productController->updateProduct($_POST['product_id'], $_POST, $_FILES['image']);
        } elseif ($action === 'delete') {
            // Delete a product
            $productController->deleteProduct($_POST['product_id']);
        }
    }
}

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $productController->deleteProduct($_GET['id']);
    $_SESSION['message'] = 'Product deleted successfully!';
    header('Location: manage_products.php');
    exit;
}

// Fetch all products and categories
$products = $productController->getAllProducts();
$categories = $categoryController->getAllCategories();

?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?>
<link rel="stylesheet" href="/StyleVerse/assets/css/manage_category.css">
<div class="container">
    <h1>Manage Products</h1>
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert"><?= htmlspecialchars($_SESSION['message']) ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <a href="/StyleVerse/views/products/add_product.php" class="btn">Add New Product</a>
    <!-- Product List -->
    <h2>All Products</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Name</th>
                <!-- <th>Description</th> -->
                <th>Price</th>
                <th>Sub Category</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product['product_id'] ?></td>
                    <td><?= htmlspecialchars($product['product_name']) ?></td>
                    <!-- <td><?= htmlspecialchars($product['description']) ?></td> -->
                    <td>LKR. <?= $product['price'] ?></td>
                    <td><?= htmlspecialchars($product['subcategory_name']) ?></td>
                    <td>
                        <?php if ($product['image_url']): ?>
                            <img src="/StyleVerse/assets/images/products/<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>" width="50">
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="/StyleVerse/views/products/add_product.php?id=<?= $product['product_id'] ?>" class="btn edit-btn">Edit</a>
                        <a href="manage_products.php?action=delete&id=<?= $product['product_id'] ?>" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php'; ?>
