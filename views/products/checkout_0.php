<?php
session_start();
$merchant_id = "YOUR_MERCHANT_ID"; // Replace with actual merchant ID from PayHere
$finalAmount = 1500.00; // Example value, dynamically replace with actual calculation

$order_id = "ORDER" . time(); // Temporary order ID
$first_name = $_SESSION['name'] ?? "John Doe";
$email = $_SESSION['email'] ?? "demo@example.com";
$phone = "0771234567"; // Or from session/post
$address = "Colombo"; // Or from session/post

$return_url = $_SERVER['DOCUMENT_ROOT'] . "/StyleVerse/views/products/order-success.php";
$cancel_url = $_SERVER['DOCUMENT_ROOT'] . "/StyleVerse/views/products/order-cancel.php";
$notify_url = $_SERVER['DOCUMENT_ROOT'] . "/StyleVerse/actions/payhere_notify.php";
?>

<form method="post" action="https://sandbox.payhere.lk/pay/checkout">
    <input type="hidden" name="merchant_id" value="<?= $merchant_id ?>">
    <input type="hidden" name="return_url" value="<?= $return_url ?>">
    <input type="hidden" name="cancel_url" value="<?= $cancel_url ?>">
    <input type="hidden" name="notify_url" value="<?= $notify_url ?>">

    <input type="hidden" name="order_id" value="<?= $order_id ?>">
    <input type="hidden" name="items" value="StyleVerse Order">
    <input type="hidden" name="currency" value="LKR">
    <input type="hidden" name="amount" value="<?= number_format($finalAmount, 2, '.', '') ?>">

    <input type="hidden" name="first_name" value="<?= $first_name ?>">
    <input type="hidden" name="last_name" value="">
    <input type="hidden" name="email" value="<?= $email ?>">
    <input type="hidden" name="phone" value="<?= $phone ?>">
    <input type="hidden" name="address" value="<?= $address ?>">
    <input type="hidden" name="city" value="Colombo">
    <input type="hidden" name="country" value="Sri Lanka">

    <button type="submit" class="btn">Pay with PayHere</button>
</form>
