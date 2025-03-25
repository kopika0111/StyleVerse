<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include configuration file (Database Connection)
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/OrderController.php');

// Check if the admin is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: /StyleVerse/views/auth/login.php');
    exit;
}

// Fetch all orders
$orderController = new OrderController($pdo);
$result = $orderController->getAllOrders();

// Handle order update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $delivery_date = $_POST['delivery_date'];

    $orderController->updateOrder($order_id, $status, $delivery_date);
    $_SESSION['success'] = "Order updated successfully!";
    header("Location: manage_orders.php");
    exit;
}

?>
<link rel="stylesheet" href="/StyleVerse/assets/css/manage_category.css"> <!-- Link CSS -->

<?php include($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'); ?>

<div class="container">
    <h1>Manage Orders</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Delivery Date</th>
                <th>Order Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $order) { ?>
                <tr>
                    <td><?php echo $order['order_id']; ?></td>
                    <td><?php echo $order['customer_name']; ?></td>
                    <td>LKR. <?php echo number_format($order['final_amount'], 2); ?></td>
                    <td>
                        <span class="status <?php echo strtolower($order['status']); ?>">
                            <?php echo $order['status']; ?>
                        </span>
                    </td>
                    <td><?= $order['delivery_date'] ? htmlspecialchars($order['delivery_date']) : 'Not Assigned'; ?></td>
                    <td><?php echo $order['order_date']; ?></td>
                    <!-- <td>
                        <a href="view_order.php?id=<?php echo $order['order_id']; ?>" class="btn view">View</a>
                        <a href="update_order.php?id=<?php echo $order['order_id']; ?>" class="btn edit">Update</a>
                        <a href="delete_order.php?id=<?php echo $order['order_id']; ?>" class="btn delete" onclick="return confirm('Are you sure?')">Delete</a>
                    </td> -->
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="order_id" value="<?= $order['order_id']; ?>">
                            <select name="status" required>
                                <option value="Pending" <?= ($order['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="Processing" <?= ($order['status'] == 'Processing') ? 'selected' : ''; ?>>Processing</option>
                                <option value="Shipped" <?= ($order['status'] == 'Shipped') ? 'selected' : ''; ?>>Shipped</option>
                                <option value="Delivered" <?= ($order['status'] == 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
                                <option value="Cancelled" <?= ($order['status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                            <input type="date" name="delivery_date" value="<?= $order['delivery_date']; ?>" required>
                            <button type="submit" class="btn edit-btn">Update</button>
                            <a href="/StyleVerse/views/orders/view_order_details.php?order_id=<?= $order['order_id'] ?>" class="btn edit-btn">View</a>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<br>
<?php include($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php'); ?>

