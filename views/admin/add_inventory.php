<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/InventoryController.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/ProductController.php');

$inventoryController = new InventoryController($pdo);
$productController = new ProductController($pdo);

$product = $size = $color = $quantity = $price = $inventoryId = '';

$inventoryItems = $productController->getAllProducts();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {       
    $inventoryController->handleFormSubmission();
    header('Location: manage_inventory.php');
    exit();
}
// Fetch category details if updating
if (isset($_GET['id'])) {
    $inventoryId = intval($_GET['id']);
    $invdentory = $inventoryController->getInventoryItemById($inventoryId);
    
    if ($inventoryId) {
        $product = $invdentory['product_id'];
        $size = $invdentory['size'];
        $color = $invdentory['color'];
        $quantity = $invdentory['quantity']; 
        $price = $invdentory['price'];      
        $inventoryId = $invdentory['inventory_id'];
    } else {
        $_SESSION['error'] = "Inventory item not found.";
        header('Location: manage_inventory.php');
        exit();
    }
}

?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?>
<link rel="stylesheet" href="/StyleVerse/assets/css/add_product.css">

<div class="add-container">
    
    <!-- Add/Edit Inventory Form -->
    <form action="add_inventory.php" method="POST"  enctype="multipart/form-data">
        <input type="hidden" name="inventory_id" id="inventory_id" value="<?= htmlspecialchars($inventoryId) ?>">
        <label>Product</label>
        <select name="product_id" required>
            <option value="">Select Product</option>
            <!-- Fetch product list dynamically -->
            <?php foreach ($inventoryItems as $item): ?>
                <option value="<?= $item['product_id'] ?>" <?= $item['product_id'] == $product ? 'selected' : '' ?>><?= htmlspecialchars($item['product_name']) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Size</label>
        <input type="text" name="size" value="<?= htmlspecialchars($size) ?>" required>

        <label>Color</label>
        <input type="text" name="color" value="<?= htmlspecialchars($color) ?>" required>

        <label>Quantity</label>
        <input type="number" name="quantity" value="<?= htmlspecialchars($quantity) ?>" required>

        <label>Price</label>
        <input type="text" name="price" value="<?= htmlspecialchars($price) ?>" required>

        <button type="submit"><?= $inventoryId ? 'Update' : 'Add' ?> Inventory</button>    
    </form>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php'; ?>
