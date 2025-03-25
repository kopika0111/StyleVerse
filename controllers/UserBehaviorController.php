<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/models/UserBehavior.php');

class UserBehaviorController {
    private $behaviorModel;

    public function __construct($pdo) {
        $this->behaviorModel = new UserBehavior($pdo);
    }

    public function recordBehavior() {
        // Read input data from the request
        $inputData = json_decode(file_get_contents('php://input'), true);
        $user_id = $inputData['user_id'];
        $product_id = $inputData['product_id'];
        $action_type = $inputData['action_type'];
        return $this->behaviorModel->recordBehavior($user_id, $product_id, $action_type);
    }

    public function getBehaviorByUser($userId) {
        return $this->behaviorModel->getBehaviorByUserId($userId);
    }

    public function getBehaviorByProduct($productId) {
        return $this->behaviorModel->getBehaviorByProductId($productId);
    }
}

require_once ($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');// Database configuration
// Initialize the controller and call the recordBehavior method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new UserBehaviorController($pdo); // Pass PDO connection
    $result = $controller->recordBehavior();

    // Return the response as JSON
    echo json_encode(['status' => 'success', 'data' => $result]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
