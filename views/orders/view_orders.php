<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/OrderController.php');

// Ensure user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: /StyleVerse/views/auth/login.php');
    exit;
}

$user_id = $_SESSION['id'];
$orderController = new OrderController($pdo);
$orders = $orderController->getOrdersByUser($user_id);
?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?>
<link rel="stylesheet" href="/StyleVerse/assets/css/manage_category.css">

<div class="container">
    <h1>My Orders</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Delivery Date</th>
                <th>Order Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= $order['order_id']; ?></td>
                    <td>LKR. <?= number_format($order['final_amount'], 2); ?></td>
                    <td><?= htmlspecialchars($order['status']); ?></td>
                    <td><?= $order['delivery_date'] ? htmlspecialchars($order['delivery_date']) : 'Not Assigned'; ?></td>
                    <td><?= $order['order_date']; ?></td>
                    <td>
                        <a href="/StyleVerse/views/orders/view_order_details.php?order_id=<?= $order['order_id'] ?>" class="btn edit-btn">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php'; ?>
