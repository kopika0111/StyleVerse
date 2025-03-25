<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once ($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');// Database configuration
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/ProductController.php');  // Include User model
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/CategoryController.php');  // Include User model
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/OfferController.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/RecommendationController.php');

$offerController = new OfferController($pdo);
$offers = $offerController->getCurrentOffers();

// Fetch featured products and categories
$productController = new ProductController($pdo);
$featuredProducts = $productController->getAllProducts();

$categoryController = new CategoryController($pdo);
$mainCategories = $categoryController->getAllCategories();
// Check if the user is logged in
$isLoggedIn = isset($_SESSION['id']);

/* array_push($offers, [
    'image_url' => 'StyleVerse_Banner_image.jpg',
    'title' => 'StyleVerse'
]); */
?>


<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?> <!-- Include the header -->
<link rel="stylesheet" href="/StyleVerse/assets/css/homepage.css">

<?php if(empty($offers)) { ?>
     <div class="hero-section">
        <div class="container">
            <h1>Welcome to StyleVerse</h1>
            <p>Your one-stop shop for amazing products and deals!</p>
            <a href="/StyleVerse/views/products/view_products.php" class="btn">Shop Now</a>
        </div>
    </div>
<?php } else { ?>
    <div class="offers-banner">
        <div class="slider">
            <?php foreach ($offers as $offer): ?>
                <div class="offer-slide">
                    <img src="/StyleVerse/assets/images/offers/<?= $offer['image_url'] ?>" alt="<?= $offer['title'] ?>">
                    <a href="/StyleVerse/views/products/view_products.php" class="btn">Shop Now</a>
                    <!-- <div class="offer-info">
                        <h3><?= $offer['title'] ?></h3>
                        <p><?= $offer['description'] ?></p>
                        <p class="discount">Discount: <?= $offer['discount'] ?>%</p>
                    </div> -->
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Navigation Arrows -->
        <button class="prev" onclick="prevSlide()">&#10094;</button>
        <button class="next" onclick="nextSlide()">&#10095;</button>
    </div>
<?php } ?>

    <?php
    $recommendationController = new RecommendationController($pdo);
    if(isset($_SESSION['id'])) {
        $userId = $_SESSION['id'];
        $topRecommendations = $recommendationController->getRecommendationsByUser($userId, 5);
    ?>

        <div class="recommendation-wrapper">
            <h2 class="recommendation-title">Recommended for You</h2>
            
            <div class="recommendation-grid">
                <?php foreach ($topRecommendations as $item): ?>
                    <div class="recommendation-card">
                        <img src="/StyleVerse/assets/images/products/<?= htmlspecialchars($item['image_url'] ?? 'default.jpg') ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                        <h4><?= htmlspecialchars($item['name']) ?></h4>
                        <p class="price">LKR <?= number_format($item['price'], 2) ?></p>
                        <div class="reason">Reason: <?= htmlspecialchars($item['reason'] ?? 'Personalized') ?></div>
                        <a href="/StyleVerse/views/products/product_details.php?product_id=<?= $item['product_id'] ?>" class="view-btn" onclick="logUserBehavior(<?= $_SESSION['id'] ?? 0 ?>,<?= $item['product_id'] ?>, 'click')">View Details</a>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="show-more-container">
                <a href="/StyleVerse/views/user/recommendations.php" class="show-more-btn">Show More</a>
            </div>
        </div>


    <?php } ?>
    <div class="categories-section">
        <div class="container">
            <h2>Shop by Category</h2>
            <div class="categories">
                <?php foreach ($mainCategories as $category): ?>
                    <div class="category-card">
                        <a href="/StyleVerse/views/products/products_categorywise.php?category=<?= $category['category_id'] ?>">
                            <img src="/StyleVerse/assets/images/categories/<?= htmlspecialchars($category['image_url']) ?>" alt="<?= htmlspecialchars($category['name']) ?>">
                            <h3><?= htmlspecialchars($category['name']) ?></h3>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="products-section">
        <div class="container">
            <h2>Featured Products</h2>
            <div class="products">
                <?php foreach ($featuredProducts as $product): ?>
                    <div class="product-card">
                        <a href="/StyleVerse/views/products/product_details.php?product_id=<?= $product['product_id'] ?>">
                            <img src="/StyleVerse/assets/images/products/<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
                            <h3><?= htmlspecialchars($product['product_name']) ?></h3>
                        </a>
                        <p class="price">LKR. <?= htmlspecialchars($product['price']) ?></p>
                        <!-- <form method="POST" action="/StyleVerse/views/products/add_to_cart.php">
                            <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                            <input type="number" id="quantity" name="quantity" value="1" style="display:none;">
                            <button type="submit" class="btn">Add to Cart</button>
                        </form> -->
                        <a href="/StyleVerse/views/products/product_details.php?product_id=<?= $product['product_id'] ?>" class="btn" onclick="logUserBehavior(<?= $_SESSION['id'] ?? 0 ?>,<?= $product['product_id'] ?>, 'click')"> View Details</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php'; ?> <!-- Include the footer -->

<script>

    let currentIndex = 0;

function showSlide(index) {
    const slides = document.querySelectorAll(".offer-slide");
    const totalSlides = slides.length;

    if (index >= totalSlides) {
        currentIndex = 0;
    } else if (index < 0) {
        currentIndex = totalSlides - 1;
    } else {
        currentIndex = index;
    }

    const slider = document.querySelector(".slider");
    slider.style.transform = `translateX(-${currentIndex * 100}%)`;
}

function nextSlide() {
    showSlide(currentIndex + 1);
}

function prevSlide() {
    showSlide(currentIndex - 1);
}

// Auto Slide every 3 seconds
setInterval(() => {
    nextSlide();
}, 3000);
</script>