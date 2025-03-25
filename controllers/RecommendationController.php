<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/models/Recommendation.php');

class RecommendationController {
    private $recommendationModel;

    public function __construct($pdo) {
        $this->recommendationModel = new Recommendation($pdo);
    }

    public function addRecommendation($userId, $productId, $score) {
        return $this->recommendationModel->addRecommendation($userId, $productId, $score);
    }

    public function getRecommendationsByUser($userId, $limit = 10) {
        return $this->recommendationModel->getRecommendationsByUser($userId, $limit);
    }

    public function getRecommendationsGroupedByReason($userId) {
        return $this->recommendationModel->getRecommendationsGroupedByReason($userId);
    }

    public function clearRecommendations($userId) {
        return $this->recommendationModel->deleteRecommendationsByUser($userId);
    }

    public function getAllRecommendations() {
        return $this->recommendationModel->getAllRecommendations();
    }
}
?>
