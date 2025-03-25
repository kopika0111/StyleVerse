<?php
// Start the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the database configuration
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');// Database configuration
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/ProductController.php');  // Include User model
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/RatingController.php');  // Include User model


// Check if product_id is provided in the URL
if (!isset($_GET['product_id']) || empty($_GET['product_id'])) {
    die("Product not found.");
}

// Get the product_id from the URL
$product_id = intval($_GET['product_id']);
$productController = new ProductController($pdo);
$ratingController = new RatingController($pdo);
$productInventories = $productController->getProductWithInventory($product_id);

// If no inventory found, mark the product as out of stock
$isOutOfStock = empty($productInventories[0]['size']);

// Group inventory details by size/color
$inventoryData = [];
$defaultPrice = $productInventories[0]['price'];

foreach ($productInventories as $inventory) {
    $size = $inventory['size'];
    $color = $inventory['color'];

    if (!isset($inventoryData[$size])) {
        $inventoryData[$size] = [];
    }

    $inventoryData[$size][$color] = [
        'inventory_id' => $inventory['inventory_id'],
        'quantity' => $inventory['quantity'],
        'price' => $inventory['inventory_price'] ?? $defaultPrice
    ];
}
// Decode the JSON-formatted additional images
$additionalImages = json_decode($productInventories[0]['additionalImages'], true) ?? [];

// Fetch existing reviews for the product

$reviews = $ratingController->getRatingsByProduct($product_id);

// Calculate average rating
$averageRating = 0;
if (count($reviews) > 0) {
    $totalRating = array_sum(array_column($reviews, 'rating'));
    $averageRating = $totalRating / count($reviews);
}

// Get form data
if(isset($_SESSION['id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {

    $user_id = $_SESSION['id'];
    $rating = intval($_POST['rating']);
    $review = htmlspecialchars($_POST['review']);

    $ratingController->addRating($user_id, $product_id, $rating, $review);
    // Redirect back to the product page with a success message
    header("Location: /StyleVerse/views/products/product_details.php?product_id=$product_id&status=review_submitted");
    exit();
}
?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?> <!-- Include the header -->
<link rel="stylesheet" href="/StyleVerse/assets/css/product_details.css"> <!-- Update the path to your CSS -->
    <main>
        <div class="container">
            <div class="product-details">
                <div class="product-image">
                    <!-- Main product image -->
                    <img id="main-image" src="/StyleVerse/assets/images/products/<?= htmlspecialchars($productInventories[0]['image_url']) ?>" alt="<?= htmlspecialchars($productInventories[0]['product_name']) ?>">
                    <!-- Additional images -->
                    <div class="additional-images">
                        <?php if (!empty($additionalImages)): ?>
                            <?php foreach ($additionalImages as $image): ?>
                                <img class="thumbnail" src="/StyleVerse/assets/images/products/<?= htmlspecialchars($image) ?>" alt="Additional Image">
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="product-info">
                    <h1><?= htmlspecialchars($productInventories[0]['product_name']) ?></h1>
                    <p class="description"><?= htmlspecialchars($productInventories[0]['description']) ?></p>

                     <!-- Dynamic Price -->
                    <p class="price">Price: LKR. <span id="price"><?= number_format($defaultPrice, 2) ?></span></p>

                    <?php if ($isOutOfStock): ?>
                        <p class="out-of-stock">🚫 Out of Stock</p>
                    <?php else: ?>
                        <form method="POST" action="add_to_cart.php">
                            <!-- Size Selection -->
                            <label for="size">Size:</label>
                            <select id="size" name="size" required>
                                <option value="">Select Size</option>
                                <?php foreach ($inventoryData as $size => $colors): ?>
                                    <option value="<?= htmlspecialchars($size) ?>"><?= htmlspecialchars($size) ?></option>
                                <?php endforeach; ?>
                            </select>

                            <!-- Color Selection -->
                            <label for="color">Color:</label>
                            <select id="color" name="color" disabled required>
                                <option value="">Select Color</option>
                            </select>

                            <!-- Quantity -->
                            <label for="quantity">Quantity:</label>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" disabled required>
                            <input type="hidden" id="inventory_id" name="inventory_id" value="">
                            <input type="hidden" name="product_id" value="<?= $productInventories[0]['product_id'] ?>">

                            <!-- Add to Cart Button -->
                            <button type="submit" class="btn" id="add-to-cart-btn" disabled>Add to Cart</button>
                        </form>
                    <?php endif; ?>

                     <!-- Display Average Rating -->
                    <p class="average-rating">Average Rating: <?= number_format($averageRating, 1) ?>/10</p>


                    <!-- Display Reviews -->
                    <div class="reviews">
                        <h2>Reviews</h2>
                        <?php if (count($reviews) > 0): ?>
                            <?php foreach ($reviews as $review): ?>
                                <div class="review">
                                <p>
                                    <strong><?= htmlspecialchars($review['username']) ?>:</strong>
                                    <p><?= $review['review'] ?></p>
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <span class="star <?= $i <= $review['rating'] ? 'filled' : '' ?>">&#9733;</span>
                                    <?php endfor; ?>
                                </p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No reviews yet.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Add Rating and Review -->
                    <?php if (isset($_SESSION['id'])): ?>
                        <div class="rating-form" style="width: 60%;">
                            <h3>Leave a Review</h3>
                            <form action="" method="POST">
                                <div class="star-rating-input">
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <span class="star" data-value="<?= $i ?>">&#9733;</span>
                                    <?php endfor; ?>
                                </div>
                                <input type="hidden" name="rating" id="rating" value="0">
                                <label for="review">Review:</label>
                                <textarea id="review" name="review" required></textarea>

                                <input type="hidden" name="product_id" value="<?= $product_id ?>">
                                <button type="submit" class="btn">Submit Review</button>
                            </form>
                        </div>
                    <?php else: ?>
                        <p>You need to <a href="/StyleVerse/views/auth/login.php">login</a> to leave a review.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php'; ?> <!-- Include the footer -->

<script>
document.addEventListener("DOMContentLoaded", function() {
    logUserBehavior(<?= $_SESSION['id'] ?? 0 ?>, <?= $product_id ?>, 'view');
    let inventoryData = <?= json_encode($inventoryData) ?>;
    let sizeSelect = document.getElementById("size");
    let colorSelect = document.getElementById("color");
    let quantityInput = document.getElementById("quantity");
    let priceSpan = document.getElementById("price");
    let addToCartBtn = document.getElementById("add-to-cart-btn");

    const mainImage = document.getElementById("main-image");
    const thumbnails = document.querySelectorAll(".thumbnail");

    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener("click", function() {
            mainImage.src = this.src; // Change main image source to clicked image
        });
    });

    const stars = document.querySelectorAll(".star-rating-input .star");
    const hiddenInput = document.getElementById("rating");

    stars.forEach(star => {
        star.addEventListener("mouseover", function () {
            const value = parseInt(this.getAttribute("data-value"));
            highlightStars(value);
        });

        star.addEventListener("mouseout", function () {
            highlightStars(parseInt(hiddenInput.value));
        });

        star.addEventListener("click", function () {
            const value = parseInt(this.getAttribute("data-value"));
            hiddenInput.value = value;
            highlightStars(value);
        });
    });

    function highlightStars(value) {
        stars.forEach(star => {
            star.classList.toggle("filled", parseInt(star.getAttribute("data-value")) <= value);
        });
    }
    
    // Update colors based on selected size
    sizeSelect.addEventListener("change", function() {
        let selectedSize = this.value;
        colorSelect.innerHTML = '<option value="">Select Color</option>';

        if (selectedSize) {
            Object.keys(inventoryData[selectedSize]).forEach(color => {
                let option = document.createElement("option");
                option.value = color;
                option.innerText = color;
                colorSelect.appendChild(option);
            });
            colorSelect.disabled = false;
        } else {
            colorSelect.disabled = true;
            quantityInput.disabled = true;
            addToCartBtn.disabled = true;
        }
    });

    // Update price & quantity based on selected color
    colorSelect.addEventListener("change", function() {
        let selectedSize = sizeSelect.value;
        let selectedColor = this.value;

        if (selectedColor) {
            let inventory = inventoryData[selectedSize][selectedColor];
            priceSpan.innerText = parseFloat(inventory.price).toFixed(2);
            quantityInput.max = inventory.quantity;
            quantityInput.disabled = false;
            addToCartBtn.disabled = inventory.quantity == 0;
            document.getElementById('inventory_id').value = inventory.inventory_id;

            if (inventory.quantity == 0) {
                alert("🚫 This product is out of stock!");
                addToCartBtn.disabled = true;
                quantityInput.disabled = true;
            }
        } else {
            quantityInput.disabled = true;
            addToCartBtn.disabled = true;
        }
    });

    /* // Handle "Add to Cart"
    addToCartBtn.addEventListener("click", function() {
        let selectedSize = sizeSelect.value;
        let selectedColor = colorSelect.value;
        let quantity = quantityInput.value;
        let inventoryId = inventoryData[selectedSize][selectedColor].inventory_id;

        if (selectedSize && selectedColor && quantity > 0) {
            fetch("add_to_cart.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ inventory_id: inventoryId, quantity: quantity })
            })
            .then(response => response.json())
            .then(data => alert(data.message))
            .catch(error => console.error("Error:", error));
        }
    }); */
});
</script>