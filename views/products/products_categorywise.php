<?php

// Include database connection
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');// Database configuration
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/ProductController.php');  // Include Procuct controller
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/SubCategoryController.php');  // Include Sub Category controller
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/CategoryController.php');  // Include Category controller

// Fetch products from the database
$productController = new ProductController($pdo);
$subCategoryController = new SubCategoryController($pdo);
$categoryController = new CategoryController($pdo);
$products = $productController->getProductsByCategory($_GET['category']);
$subCategories = $subCategoryController->getSubCategoriesByCategory($_GET['category']);
$category = $categoryController->getCategoryById($_GET['category']);

$subCategoryId = $_GET['subcategory'] ?? '';

?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?> <!-- Include the header -->
<link rel="stylesheet" href="/StyleVerse/assets/css/products_categorywise.css"> <!-- Update the path to your CSS -->

<h2 class="title"><?php echo $category['name']?>'s Collection</h2>
<input type="hidden" id="hidden_subcategory" name="hidden_subcategory" value="<?= $subCategoryId ?>">
<!-- Subcategory Tiles -->
<div class="subcategory-wrapper">
    <button class="scroll-btn left" onclick="scrollSubcategories(-1)">&#10094;</button>
    <div class="subcategory-container" id="subcategoryScroll">
        <?php
        if (!empty($subCategories)) {
            foreach ($subCategories as $subCategory) {
                echo "<div class='subcategory-tile' onclick='loadProducts(" . $subCategory['subcategory_id'] . ")'>";
                echo "<img src='/StyleVerse/assets/images/subcategories/" . $subCategory['image_url'] . "' alt='" . $subCategory['subcategory_name'] . "'>";
                echo "<h3>" . $subCategory['subcategory_name'] . "</h3>";
                echo "</div>";
            }
        }
        ?>
    </div>
    <button class="scroll-btn right" onclick="scrollSubcategories(1)">&#10095;</button>
</div>


<!-- Products will be loaded here -->
<div class="product-container">
    <?php
    $actionType = '"click"';
    $userId = $_SESSION['id'] ?? 0;
    if ($products > 0) {
        foreach($products as $product) {
            echo "<div class='product-card'>";
            echo "<img src='/StyleVerse/assets/images/products/" .htmlspecialchars($product['image_url']) . "' alt='" . $product['product_name'] . "'>";
            echo "<h3>" . $product['product_name'] . "</h3>";
            echo "<p class='price'>LKR. " . $product['price'] . "</p>";
            echo "<form method='POST' action='/StyleVerse/views/products/add_to_cart.php'>";
            echo "<input type='hidden' name='product_id' value='".$product['product_id']."'>";
            echo "<input type='number' id='quantity' name='quantity' value='1' style='display:none;'>";
            echo "<a href='/StyleVerse/views/products/product_details.php?product_id= ".$product['product_id'] ."' class='btn' onclick='logUserBehavior(". $userId . " , " . $product['product_id'] .", ". $actionType ." )'> View Details</a>";
            echo "</form>";
            echo "</div>";
        }
    } else {
        echo "<p>No products found.</p>";
    }
    ?>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php'; ?> <!-- Include the footer -->

<script>

    subCategoryId = document.getElementById('hidden_subcategory').value
    subCategoryId && loadProducts(subCategoryId)

    function loadProducts(subCategoryId) {
        $.ajax({
            url: "/StyleVerse/actions/fetch_products.php",
            method: "POST",
            data: { sub_category_id: subCategoryId },
            success: function(response) {
                $(".product-container").html(response);
                if(!response) {
                    $(".product-container").html('<p>No products found.</p>');
                }
            }
        });
    }

    function scrollSubcategories(direction) {
        let container = document.getElementById("subcategoryScroll");
        let scrollAmount = 200; // Adjust scroll amount

        if (direction === 1) {
            container.scrollLeft += scrollAmount;
        } else {
            container.scrollLeft -= scrollAmount;
        }
    }

</script>
