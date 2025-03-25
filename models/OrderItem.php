<?php
class OrderItem {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Add an item to an order
    public function addOrderItem($data) {
        $sql = "INSERT INTO order_items (order_id, product_id, quantity, price, inventory_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$data['order_id'], $data['product_id'], $data['quantity'], $data['price'], $data['inventory_id']]);
    }

    // Get all items for a specific order
    public function getOrderItems($orderId) {
        $sql = "SELECT oi.*, p.name AS product_name
                FROM order_items oi
                JOIN products p ON oi.product_id = p.product_id
                WHERE oi.order_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Delete all items for an order
    public function deleteOrderItems($orderId) {
        $sql = "DELETE FROM order_items WHERE order_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$orderId]);
    }
}
