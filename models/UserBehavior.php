<?php
class UserBehavior {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Record user behavior
    public function recordBehavior($userId, $productId, $actionType) {
        $sql = "INSERT INTO user_behavior (user_id, product_id, action_type) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$userId, $productId, $actionType]);
    }

    // Get behavior by user ID
    public function getBehaviorByUserId($userId) {
        $sql = "SELECT ub.*, p.name AS product_name
                FROM user_behavior ub
                JOIN products p ON ub.product_id = p.product_id
                WHERE ub.user_id = ?
                ORDER BY ub.timestamp DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get behavior by product ID
    public function getBehaviorByProductId($productId) {
        $sql = "SELECT ub.*, u.name AS user_name
                FROM user_behavior ub
                JOIN users u ON ub.user_id = u.user_id
                WHERE ub.product_id = ?
                ORDER BY ub.timestamp DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all user behavior data
    public function getAllBehavior() {
        $sql = "SELECT ub.*, u.name AS user_name, p.name AS product_name
                FROM user_behavior ub
                JOIN users u ON ub.user_id = u.user_id
                JOIN products p ON ub.product_id = p.product_id
                ORDER BY ub.timestamp DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Delete behavior record
    public function deleteBehavior($behaviorId) {
        $sql = "DELETE FROM user_behavior WHERE behavior_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$behaviorId]);
    }
}