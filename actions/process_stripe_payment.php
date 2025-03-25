<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/StyleVerse/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/StyleVerse/models/Order.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/StyleVerse/vendor/autoload.php');

\Stripe\Stripe::setApiKey('sk_test_XXXXXXXXXXXXXXXXXXXX'); // Your secret key

try {
    $paymentMethodId = $_POST['payment_method_id'];
    $amount = $_POST['amount']; // in cents
    $userId = $_POST['user_id'];

    $intent = \Stripe\PaymentIntent::create([
        'amount' => $amount,
        'currency' => 'usd',
        'payment_method' => $paymentMethodId,
        'confirm' => true,
    ]);

    $orderModel = new Order($pdo);
    $orderId = $orderModel->createOrder([
        'user_id' => $userId,
        'total_amount' => $amount / 100,
        'final_amount' => $amount / 100,
        'payment_method' => 'card',
        'transaction_id' => $intent->id
    ]);

    echo json_encode(['success' => true, 'order_id' => $orderId]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
