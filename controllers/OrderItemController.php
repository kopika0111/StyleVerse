<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/models/OrderItem.php');

class OrderItemController {
    private $orderItemModel;

    public function __construct($pdo) {
        $this->orderItemModel = new OrderItem($pdo);
    }

    public function addOrderItem($data) {
        return $this->orderItemModel->addOrderItem($data);
    }

    public function getItemsByOrder($orderId) {
        return $this->orderItemModel->getOrderItemsByOrderId($orderId);
    }
}
?>
