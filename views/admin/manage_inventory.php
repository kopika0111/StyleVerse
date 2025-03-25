<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/InventoryController.php');

$inventoryController = new InventoryController($pdo);
$inventoryItems = $inventoryController->getAllInventory();

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $inventoryController->deleteInventory($_GET['id']);
}
?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?>
<link rel="stylesheet" href="/StyleVerse/assets/css/manage_category.css">

<div class="container">
    <h1>Manage Inventory</h1>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert"><?= htmlspecialchars($_SESSION['message']) ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <a href="/StyleVerse/views/admin/add_inventory.php" class="btn">Add New Product</a>

    <!-- Inventory Table -->
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>Size</th>
                <th>Color</th>
                <th>Quantity</th>
                <th>Price (LKR)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inventoryItems as $item): ?>
                <tr>
                    <td><?= $item['inventory_id'] ?></td>
                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                    <td><?= htmlspecialchars($item['size']) ?></td>
                    <td><?= htmlspecialchars($item['color']) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>LKR <?= number_format($item['price'], 2) ?></td>
                    <td>
                        <a href="add_inventory.php?id=<?= $item['inventory_id'] ?>" class="btn edit-btn">Edit</a>
                        <a href="?action=delete&id=<?= $item['inventory_id'] ?>" class="btn delete-btn"  onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php'; ?>
