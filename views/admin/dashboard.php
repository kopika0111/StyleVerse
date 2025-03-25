<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/ProductController.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/CategoryController.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/SubCategoryController.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/UserController.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/OrderController.php');

// Check if the admin is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: /StyleVerse/views/auth/login.php');
    exit;
}

// Fetch key metrics from controllers
$productController = new ProductController($pdo);
$totalProducts = $productController->getProductCount();

$categoryController = new CategoryController($pdo);
$totalCategories = $categoryController->getCategoryCount();

$subcategoryController = new SubCategoryController($pdo);
$totalSubCategories = $subcategoryController->getSubCategoryCount();

$userController = new UserController($pdo);
$totalUsers = $userController->getUserCount();

$orderController = new OrderController($pdo);
$totalOrders = $orderController->getOrderCount();

$recentActivities = $userController->getRecentActivities();
?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?>
<link rel="stylesheet" href="/StyleVerse/assets/css/dashboard.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="admin-container">
<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/sidebar.php'; ?>
    <!-- Main Content -->
    <main class="dashboard-content">
        <nav class="top-navbar">
            <h1>Admin Dashboard</h1>
            <a href="/StyleVerse/views/auth/logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>

        <div class="dashboard-metrics">
            <div class="metric-card">
                <h2><i class="fas fa-box"></i> Total Products</h2>
                <p><?php echo $totalProducts; ?></p>
            </div>
            <div class="metric-card">
                <h2><i class="fas fa-list"></i> Total Categories</h2>
                <p><?php echo $totalCategories; ?></p>
            </div>
            <div class="metric-card">
                <h2><i class="fas fa-tags"></i> Total Subcategories</h2>
                <p><?php echo $totalSubCategories; ?></p>
            </div>
            <div class="metric-card">
                <h2><i class="fas fa-user"></i> Total Users</h2>
                <p><?php echo $totalUsers; ?></p>
            </div>
            <div class="metric-card">
                <h2><i class="fas fa-shopping-cart"></i> Total Orders</h2>
                <p><?php echo $totalOrders; ?></p>
            </div>
        </div>

        <div class="recent-activity">
            <h2>Recent Activities</h2>
            <ul>
                <?php foreach ($recentActivities as $activity): ?>
                    <li><?php echo $activity['activity']; ?>: <?php echo $activity['table_name'] == 'orders' ? $activity['record_id'] : ''; ?> <?php echo $activity['details']; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </main>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php'; ?>
