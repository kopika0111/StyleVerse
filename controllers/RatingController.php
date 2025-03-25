<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/models/Rating.php');

class RatingController {
    private $ratingModel;

    public function __construct($pdo) {
        $this->ratingModel = new Rating($pdo);
    }

    public function addRating($userId, $productId, $rating, $review) {
        return $this->ratingModel->addOrUpdateRating($userId, $productId, $rating, $review);
    }

    public function getRatingsByProduct($productId) {
        return $this->ratingModel->getRatingsByProductId($productId);
    }

    public function getRatingsByUser($userId) {
        return $this->ratingModel->getRatingsByUserId($userId);
    }
}
?>
