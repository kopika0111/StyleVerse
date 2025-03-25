<?php
class Order {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Create a new order
    public function createOrder($data) {
         // Default values
        $paymentMethod = $data['payment_method'] ?? 'cod';
        $paymentStatus = 'pending';
        $transactionId = $data['transaction_id'];

        // If card is selected, assume gateway logic was handled before calling this
        if ($paymentMethod === 'card') {
            // Example: assume $data includes payment status after successful payment
            $paymentStatus = 'paid';
        }
        $params = [
            $data['user_id'],
            $data['total_amount'],
            $data['final_amount'],
            $paymentMethod,
            $paymentStatus,
            $transactionId
        ];
        if (!isset($data['offer_id']) && empty($data['offer_id'])) {
            $sql = "INSERT INTO orders (user_id, total_amount, final_amount, payment_method, status, transaction_id) VALUES (?, ?, ?, ?, ?, ?)";
        } else {
            $sql = "INSERT INTO orders (user_id, total_amount, final_amount, offer_id, payment_method, status, transaction_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
            array_push($params, $data['offer_id']);
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $this->pdo->lastInsertId(); // Return the new order ID
    }


    // Read all orders
    public function getAllOrders() {
        $sql = "
            SELECT
                o.*,
                u.name as customer_name
            FROM orders o
            LEFT JOIN users u
                ON o.user_id = u.user_id
            ORDER BY order_date DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Read orders by user ID
    public function getOrdersByUserId($userId) {
        $sql = "SELECT * FROM orders WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get order details by order ID
    public function getOrderById($order_id) {
        // Fetch order info
        $stmt = $this->pdo->prepare("
            SELECT o.*, u.name AS customer_name
            FROM orders o
            JOIN users u ON o.user_id = u.user_id
            WHERE o.order_id = ?
        ");
        $stmt->execute([$order_id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order) {
            return false; // Order not found
        }

        // Fetch order items
        $stmt = $this->pdo->prepare("
            SELECT oi.*, p.name AS product_name, p.image_url, i.size, i.color
            FROM order_items oi
            JOIN inventory i ON oi.inventory_id = i.inventory_id
            JOIN products p ON i.product_id = p.product_id
            WHERE oi.order_id = ?
        ");
        $stmt->execute([$order_id]);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($items as &$item) {
            $item['subtotal'] = $item['price'] * $item['quantity'];
        }

        return ['order' => $order, 'items' => $items];
    }

    // Delete an order
    public function deleteOrder($orderId) {
        $sql = "DELETE FROM orders WHERE order_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$orderId]);
    }
    public function getOrderCount() {
        $sql = "SELECT COUNT(*) AS order_count FROM orders"; // Alias the count
        $stmt = $this->pdo->query($sql); // Execute the query
        $result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch as associative array
        return $result['order_count']; // Return the count
    }

    // Update order status & delivery date
    public function updateOrder($order_id, $status, $delivery_date) {
        $stmt = $this->pdo->prepare("UPDATE orders SET status = ?, delivery_date = ? WHERE order_id = ?");
        return $stmt->execute([$status, $delivery_date, $order_id]);
    }

    public function cancelOrder($order_id) {
        $stmt = $this->pdo->prepare("UPDATE orders SET status = 'Cancelled' WHERE order_id = ?");
        return $stmt->execute([$order_id]);
    }

    public function getShippingDetails($order_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM shipping_details WHERE order_id = ?");
        $stmt->execute([$order_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}