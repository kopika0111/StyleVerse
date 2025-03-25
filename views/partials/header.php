<?php
// Start session to manage user login and cart details
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/CategoryController.php');

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['id']);
$userName = $isLoggedIn ? $_SESSION['name'] : null;

// Count items in the cart (if applicable)
$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

$categoryController = new CategoryController($pdo);
$categories_head = $categoryController->getCategoriesWithSubcategories();

if(isset($_GET['query'])) {
    $searchTerm = $_GET['query'];
    $productController = new ProductController($pdo);
    $products = $productController->searchProducts($searchTerm);
    echo json_encode($products);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StyleVerse</title>
    <link rel="stylesheet" href="/StyleVerse/assets/css/style.css">
    <script src="/StyleVerse/assets/js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/StyleVerse/assets/css/select2.min.css">
    <script src="/StyleVerse/assets/js/select2.min.js"></script>
    <script src="/StyleVerse/assets/js/search.js"></script>
    <script src="https://kit.fontawesome.com/ca91f98503.js" crossorigin="anonymous"></script>
     <!-- <script src="/Styleverse/assests/js/fontawesome.js" crossorigin="anonymous"></script> -->
</head>
<body>
    <header class="header no-print">
        <div class="header-container">
            <!-- Logo Section -->
            <div class="logo">
                <?php
                // echo json_encode($_SESSION);
                    if(count($_SESSION) > 0 && isset($_SESSION['role'])) {
                        if($_SESSION['role'] == 'admin') { ?>
                            <a href="/StyleVerse/views/admin/dashboard.php">
                                StyleVerse
                            </a>
                        <?php } else { ?>
                            <a href="/StyleVerse/index.php">
                                StyleVerse
                            </a>
                        <?php }
                    } else { ?>
                        <a href="/StyleVerse/index.php">
                            StyleVerse
                        </a>
                <?php } ?>
            </div>

            <!-- Navigation Menu -->

            <?php if(!isset($_SESSION['role']) || (isset($_SESSION['role']) && $_SESSION['role'] != 'admin')) { ?>
            <nav>
                <ul class="nav-links">
                    <?php foreach ($categories_head as $categoryId_head => $category_head): ?>
                        <li>
                            <a href="/StyleVerse/views/products/products_categorywise.php?category=<?= $categoryId_head ?>"><?= htmlspecialchars($category_head['name']) ?></a>
                            <?php if (!empty($category_head['subcategories'])): ?>
                                <ul class="dropdown">
                                    <?php foreach ($category_head['subcategories'] as $subcategory_head): ?>
                                        <li>
                                            <a href="/StyleVerse/views/products/products_categorywise.php?category=<?= $categoryId_head ?>&subcategory=<?= $subcategory_head['id'] ?>">
                                                <?= htmlspecialchars($subcategory_head['name']) ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
            <?php } ?>

            <!-- Header Icons -->
            <div class="header-icons">
            <?php if(!isset($_SESSION['role']) || (isset($_SESSION['role']) && $_SESSION['role'] != 'admin')) { ?>

                <div class="icon" id="search-btn">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <div id="search-container">
                    <input type="text" id="search-box" placeholder="Type to search...">
                    <div id="search-results"></div>
                </div>

                <a href="/StyleVerse/views/products/cart.php" class="icon">
                    <i class="fa-solid fa-cart-shopping"></i> (<?= $cartCount ?>)
                </a>
                <a href="/StyleVerse/views/orders/view_orders.php" class="icon">
                    <i class="fa-solid fa-bag-shopping"></i>
                </a>
                <?php } ?>
                <?php if ($isLoggedIn): ?>
                    <a href="/StyleVerse/views/user/profile.php" class="icon">
                    <img src="/StyleVerse/assets/images/profiles/<?= $_SESSION['profile_picture'] ?? 'default.png' ?>" class="header-profile-pic">
                    <?= htmlspecialchars($userName) ?>
                    </a>
                    <a href="/StyleVerse/views/auth/logout.php" class="icon logout-btn" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
                <?php else: ?>
                    <a href="/StyleVerse/views/auth/login.php" class="icon"><i class="fa-solid fa-user"></i></a>
                <?php endif; ?>
            </div>
        </div>
    </header>
</body>
</html>
