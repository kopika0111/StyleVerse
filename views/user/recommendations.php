<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once ($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');// Database configuration
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/RecommendationController.php');

$userId = $_SESSION['id'];
$recommendationController = new RecommendationController($pdo);
$groupedRecs = $recommendationController->getRecommendationsGroupedByReason($userId);
?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?> <!-- Include the header -->
<link rel="stylesheet" href="/StyleVerse/assets/css/recommendation.css">

<div class="recommendation-wrapper">
    <h2 class="recommendation-title" style="text-align: center;">Your Personalized Recommendations</h2>

    <?php foreach ($groupedRecs as $reason => $items): ?>
        <div class="recommendation-section">
            <h3><?= htmlspecialchars($reason) ?></h3>
            <div class="recommendation-grid">
                <?php foreach ($items as $item): ?>
                    <div class="recommendation-card">
                        <img src="/StyleVerse/assets/images/products/<?= htmlspecialchars($item['image_url'] ?? 'default.jpg') ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                        <h4><?= htmlspecialchars($item['name']) ?></h4>
                        <p class="price">LKR <?= number_format($item['price'], 2) ?></p>
                        <div class="reason">Reason: <?= htmlspecialchars($item['reason'] ?? 'Recommended') ?></div>
                        <a href="/StyleVerse/views/products/product_details.php?product_id=<?= $item['product_id'] ?>" class="view-btn" onclick="logUserBehavior(<?= $_SESSION['id'] ?? 0 ?>,<?= $item['product_id'] ?>, 'click')">View Details</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>


<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php'; ?> <!-- Include the footer -->
