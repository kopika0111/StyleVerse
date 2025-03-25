<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');// Database configuration
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/RecommendationController.php');
$recommendationController = new RecommendationController($pdo);
$allRecs = $recommendationController->getAllRecommendations();
?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?> <!-- Include the header -->
<link rel="stylesheet" href="/StyleVerse/assets/css/recommendation.css">

<div class="recommendation-wrapper" style="margin: 60px;">
    <h2 class="recommendation-title" style="text-align: center;">All User Recommendations</h2>

    <div class="recommendation-grid">
        <?php foreach ($allRecs as $rec): ?>
            <div class="recommendation-card">
                <img src="/StyleVerse/assets/images/products/<?= htmlspecialchars($rec['image_url']) ?>" alt="<?= htmlspecialchars($rec['product_name']) ?>">
                <h4><?= htmlspecialchars($rec['product_name']) ?></h4>
                <p class="price">LKR <?= number_format($rec['score'], 2) ?></p>
                <div class="reason">
                    Reason: <?= htmlspecialchars($rec['reason']) ?>
                </div>
                <small>User: <?= htmlspecialchars($rec['user_name']) ?></small><br>
                <small>Created: <?= htmlspecialchars($rec['created_at']) ?></small>
                <a href="/StyleVerse/views/products/product_details.php?product_id=<?= $rec['product_id'] ?>" class="view-btn">View Product</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php'; ?> <!-- Include the footer -->
