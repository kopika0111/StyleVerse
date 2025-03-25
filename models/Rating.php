<?php
class Rating {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Add or update a rating
    public function addOrUpdateRating($userId, $productId, $rating, $review) {
        // Check if the user has already rated the product
        $sql = "SELECT rating_id FROM ratings WHERE user_id = ? AND product_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId, $productId]);
        $existingRating = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingRating) {
            // Update existing rating
            $sql = "UPDATE ratings SET rating = ?, review = ? WHERE user_id = ? AND product_id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$rating, $review, $userId, $productId]);
        } else {
            // Insert new rating
            $sql = "INSERT INTO ratings (user_id, product_id, rating, review) VALUES (?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$userId, $productId, $rating, $review]);
        }
    }

    // Get all ratings for a specific product
    public function getRatingsByProductId($productId) {
        $sql = "SELECT r.*, u.name AS username
                FROM ratings r
                JOIN users u ON r.user_id = u.user_id
                WHERE r.product_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all ratings by a specific user
    public function getRatingsByUserId($userId) {
        $sql = "SELECT r.*, p.name AS product_name
                FROM ratings r
                JOIN products p ON r.product_id = p.product_id
                WHERE r.user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Delete a rating
    public function deleteRating($ratingId) {
        $sql = "DELETE FROM ratings WHERE rating_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$ratingId]);
    }
}
