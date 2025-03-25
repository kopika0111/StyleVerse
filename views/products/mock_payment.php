<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/StyleVerse/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/StyleVerse/controllers/OrderController.php';
require_once($_SERVER['DOCUMENT_ROOT'] . '/StyleVerse/controllers/OrderItemController.php');

if (!isset($_SESSION['pending_order'])) {
    die("No pending order found.");
}


$add_cart = $_SESSION['add_cart'] ?? [];
$data = $_SESSION['pending_order'];
$data['status'] = 'paid';
$data['transaction_id'] = 'MOCK' . rand(10000, 99999);

$orderController = new OrderController($pdo);
$orderId = $orderController->createOrder($data);

if ($orderId) {
    $stmt = $pdo->prepare("INSERT INTO shipping_details (order_id, user_id, shipping_name, shipping_address, shipping_phone) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$orderId, $_SESSION['pending_order']['user_id'], $_SESSION['pending_order']['shipping_name'], $_SESSION['pending_order']['shipping_address'], $_SESSION['pending_order']['shipping_phone']]);

    $orderItemController = new OrderItemController($pdo);
    foreach($add_cart as $key => $orderItem) {
        $orderItem['order_id'] = $orderId;
        $orderItem['product_id'] = $key;
        $orderItem['inventory_id'] = $_SESSION['inventory'][$key];
        $orderItemController->addOrderItem($orderItem);
        $stmt = $pdo->prepare("UPDATE inventory SET quantity = quantity - ? WHERE inventory_id = ?");
        $stmt->execute([$orderItem['quantity'], $_SESSION['inventory'][$key]]);
    }

    unset($_SESSION['cart'], $_SESSION['add_cart'], $_SESSION['inventory']);
    $_SESSION['order_id'] = $orderId;
    header("Location: order_success_with_pdf.php");
    exit;
} else {
    $error = "Failed to process the order.";
}
// Clear session
unset($_SESSION['pending_order']);
$_SESSION['order_id'] = $orderId;

header("Location: /StyleVerse/views/products/order_success_with_pdf.php");
exit;
?>
