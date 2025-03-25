<?php
class Recommendation {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Add a new recommendation
    public function addRecommendation($userId, $productId, $score) {
        $sql = "INSERT INTO recommendations (user_id, product_id, score) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$userId, $productId, $score]);
    }

    // Get recommendations for a specific user
    public function getRecommendationsByUser($userId, $limit = 10) {
        $limit = (int)$limit; // safely cast to int
        $sql = "
            SELECT r.product_id, p.name, p.price, r.score, r.reason, p.image_url
            FROM recommendations r
            JOIN products p ON r.product_id = p.product_id
            WHERE r.user_id = ?
            ORDER BY r.score DESC
            LIMIT $limit
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getRecommendationsGroupedByReason($userId) {
        $sql = "
            SELECT r.product_id, p.name, p.price, r.score, r.reason, image_url
            FROM recommendations r
            JOIN products p ON r.product_id = p.product_id
            WHERE r.user_id = ?
            ORDER BY r.score DESC
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $grouped = [];
        foreach ($data as $row) {
            $reasons = explode(', ', $row['reason'] ?? 'Other');
            foreach ($reasons as $reason) {
                $grouped[$reason][] = $row;
            }
        }
        return $grouped;
    }
    
    // Delete old recommendations for a user
    public function deleteRecommendationsByUser($userId) {
        $sql = "DELETE FROM recommendations WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$userId]);
    }

    // Get all recommendations (optional for admin views)
    public function getAllRecommendations() {
        $sql = "
            SELECT r.*, u.name AS user_name, p.name AS product_name, p.image_url
            FROM recommendations r
            JOIN users u ON r.user_id = u.user_id
            JOIN products p ON r.product_id = p.product_id
            ORDER BY r.created_at DESC
        ";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
