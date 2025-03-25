<?php
$merchant_id      = $_POST['merchant_id'];
$order_id         = $_POST['order_id'];
$payhere_amount   = $_POST['payhere_amount'];
$payhere_currency = $_POST['payhere_currency'];
$status_code      = $_POST['status_code'];
$md5sig           = $_POST['md5sig'];

$merchant_secret = 'YOUR_MERCHANT_SECRET'; // Replace with your actual PayHere secret

$local_md5sig = strtoupper(
    md5($merchant_id . $order_id . $payhere_amount . $payhere_currency . $status_code . strtoupper(md5($merchant_secret)))
);

if ($local_md5sig === $md5sig && $status_code == 2) {
    // Payment success
    file_put_contents("payhere_success_log.txt", "Order $order_id was paid successfully.\n", FILE_APPEND);
} else {
    file_put_contents("payhere_failed_log.txt", "Payment failed or invalid signature for $order_id.\n", FILE_APPEND);
}
?>
