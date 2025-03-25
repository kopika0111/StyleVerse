<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/OrderController.php');

// Ensure the user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: /StyleVerse/views/auth/login.php');
    exit;
}

// Get the order ID from URL
if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    die("Order not found.");
}

$order_id = intval($_GET['order_id']);
$orderController = new OrderController($pdo);
$orderDetails = $orderController->getOrderById($order_id);
$shipping_details = $orderController->getShippingDetails($order_id);

if (!$orderDetails) {
    die("Invalid order ID.");
}

// Check if the order can be cancelled
$canCancel = in_array($orderDetails['order']['status'], ['Pending', 'Processing']);
?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?>
<link rel="stylesheet" href="/StyleVerse/assets/css/order_details.css">

<div class="order-details-container">
    <h1>Order Details (Order ID: <?= $orderDetails['order']['order_id'] ?>)</h1>

    <h3>Customer: <?= htmlspecialchars($orderDetails['order']['customer_name']) ?></h3>
    <p>Status: <strong><?= $orderDetails['order']['status'] ?></strong></p>
    <p>Total Price: <strong>LKR. <?= number_format($orderDetails['order']['total_amount'], 2) ?></strong></p>
    <p>Discount Price: <strong>LKR. <?= number_format($orderDetails['order']['final_amount'], 2) ?></strong></p>
    <p>Delivery Date: <strong><?= $orderDetails['order']['delivery_date'] ?: "Not Assigned" ?></strong></p>
    <p>Order Date: <strong><?= $orderDetails['order']['order_date'] ?></strong></p>
    <p>Shipping Address: <strong><?= htmlspecialchars($shipping_details['shipping_address']) ?></strong></p>
    <p>Phone: <strong><?= htmlspecialchars($shipping_details['shipping_phone']) ?></strong></p>

    <h2>Order Items</h2>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Image</th>
                <th>Size</th>
                <th>Color</th>
                <th>Quantity</th>
                <th>Price (LKR)</th>
                <th>Subtotal (LKR)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderDetails['items'] as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                    <td><img src="/StyleVerse/assets/images/products/<?= htmlspecialchars($item['image_url']) ?>" class="order-image"></td>
                    <td><?= htmlspecialchars($item['size']) ?></td>
                    <td><?= htmlspecialchars($item['color']) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= number_format($item['price'], 2) ?></td>
                    <td><?= number_format($item['subtotal'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br>
    <?php if ($canCancel): ?>
        <form method="POST" action="cancel_order.php">
            <input type="hidden" name="order_id" value="<?= $order_id ?>">
            <button type="submit" class="btn cancel-btn" onclick="return confirm('Are you sure you want to cancel this order?')">Cancel Order</button>
        </form>
    <?php endif; ?>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php'; ?>
