<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/models/Order.php');

class OrderController {
    private $orderModel;

    public function __construct($pdo) {
        $this->orderModel = new Order($pdo);
    }

    public function createOrder($data) {
        return $this->orderModel->createOrder($data);
    }

    public function getOrderById($orderId) {
        return $this->orderModel->getOrderById($orderId);
    }

    public function getOrdersByUser($userId) {
        return $this->orderModel->getOrdersByUserId($userId);
    }

    public function deleteOrder($orderId) {
        return $this->orderModel->deleteOrder($orderId);
    }
    public function getOrderCount() {
        return $this->orderModel->getOrderCount();
    }
    public function getAllOrders() {
        return $this->orderModel->getAllOrders();
    }

    // Update order status & delivery date
    public function updateOrder($order_id, $status, $delivery_date) {
        return $this->orderModel->updateOrder($order_id, $status, $delivery_date);
    }

    public function cancelOrder($order_id) {
        return $this->orderModel->cancelOrder($order_id);
    }

    public function getShippingDetails($order_id) {
        return $this->orderModel->getShippingDetails($order_id);
    }

}
?>
