<?php
class Inventory {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Add inventory item
    public function addInventory($product_id, $size, $color, $quantity, $price) {
        $sql = "INSERT INTO inventory (product_id, size, color, quantity, price) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$product_id, $size, $color, $quantity, $price]);
    }

    // Update inventory item
    public function updateInventory($inventory_id, $size, $color, $quantity, $price) {
        $sql = "UPDATE inventory SET size = ?, color = ?, quantity = ?, price = ? WHERE inventory_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$size, $color, $quantity, $price, $inventory_id]);
    }

    // Delete inventory item
    public function deleteInventory($inventory_id) {
        $sql = "DELETE FROM inventory WHERE inventory_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$inventory_id]);
    }

    // Get all inventory items
    public function getAllInventory() {
        $sql = "SELECT i.*, p.name AS product_name FROM inventory i JOIN products p ON i.product_id = p.product_id";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get inventory by  ID
    public function getInventoryById($inventory_id) {
        $sql = "SELECT * FROM inventory WHERE inventory_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$inventory_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
