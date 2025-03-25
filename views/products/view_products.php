<?php
// Start the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');// Database configuration
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/ProductController.php');  // Include Product controller
// Fetch products from the database
$productController = new ProductController($pdo);
$products = $productController->getAllProducts();
?>
    <?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?> <!-- Include the header -->
    <link rel="stylesheet" href="/StyleVerse/assets/css/view_products.css"> <!-- Update the path to your CSS -->
    <main>
        <div class="container">
            <h1>Our Products</h1>
            <div class="product-grid">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <img src="/StyleVerse/assets/images/products/<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
                            <h2><?= htmlspecialchars($product['product_name']) ?></h2>
                            <p class="description"><?= htmlspecialchars($product['description']) ?></p>
                            <p class="price">LKR. <?= number_format($product['price'], 2) ?></p>
                            <a href="product_details.php?product_id=<?= $product['product_id'] ?>" class="btn" onclick="logUserBehavior(<?= $_SESSION['id'] ?? 0 ?>, <?= $product['product_id'] ?>, 'click')">View Details</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No products available at the moment. Please check back later!</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php'; ?> <!-- Include the footer -->

