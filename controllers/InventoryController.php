<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/models/Inventory.php');

class InventoryController {
    private $inventory;

    public function __construct($pdo) {
        $this->inventory = new Inventory($pdo);
    }

    // Handle form submission (Add / Update)
    public function handleFormSubmission() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inventory_id = $_POST['inventory_id'] ?? null;
            $product_id = $_POST['product_id'];
            $size = $_POST['size'];
            $color = $_POST['color'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];

            if ($inventory_id) {
                $this->inventory->updateInventory($inventory_id, $size, $color, $quantity, $price);
                $_SESSION['message'] = "Inventory updated successfully!";
            } else {
                $this->inventory->addInventory($product_id, $size, $color, $quantity, $price);
                $_SESSION['message'] = "Inventory added successfully!";
            }
            header('Location: manage_inventory.php');
            exit;
        }
    }

    // Delete Inventory
    public function deleteInventory($inventory_id) {
        $this->inventory->deleteInventory($inventory_id);
        $_SESSION['message'] = "Inventory deleted successfully!";
        header('Location: manage_inventory.php');
        exit;
    }

    // Get all inventory
    public function getAllInventory() {
        return $this->inventory->getAllInventory();
    }

    public function getInventoryItemById($inventory_id) {
        return $this->inventory->getInventoryById($inventory_id);
    }
}
?>
