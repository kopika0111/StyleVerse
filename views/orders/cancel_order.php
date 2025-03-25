<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/OrderController.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['order_id']) || empty($_POST['order_id'])) {
        die("Invalid order.");
    }

    $order_id = intval($_POST['order_id']);
    $orderController = new OrderController($pdo);
    $orderDetails = $orderController->getOrderById($order_id);

    // Check if the order can be cancelled
    if (in_array($orderDetails['order']['status'], ['Pending', 'Processing'])) {
        $success = $orderController->cancelOrder($order_id);
        if ($success) {
            $_SESSION['success'] = "Order has been cancelled successfully.";
        } else {
            $_SESSION['error'] = "Failed to cancel the order.";
        }
    } else {
        $_SESSION['error'] = "Order cannot be cancelled at this stage.";
    }

    header("Location: view_order_details.php?order_id=$order_id");
    exit();
}
?>
