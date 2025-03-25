<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/ProductController.php');

$productController = new ProductController($pdo);
if (isset($_POST['sub_category_id'])) {
    $subCategoryId = $_POST['sub_category_id'];
    $products = $productController->getProductsBySubCategory($subCategoryId);


    if ($products > 0) {
        foreach($products as $product) {
            echo "<div class='product-card'>";
            echo "<img src='/StyleVerse/assets/images/products/" .htmlspecialchars($product['image_url']) . "' alt='" . $product['product_name'] . "'>";
            echo "<h3>" . $product['product_name'] . "</h3>";
            echo "<p class='price'>LKR. " . $product['price'] . "</p>";
            echo "<a href='/StyleVerse/views/products/product_details.php?product_id= ".$product['product_id'] ."' class='btn'> View Details</a>";
            echo "</div>";
        }
    } else {
        echo "<p>No products found.</p>";
    }
}
?>
