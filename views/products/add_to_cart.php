<?php
// Start the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request method.");
}

// Check if the required fields are provided
if (!isset($_POST['product_id']) || !isset($_POST['quantity']) || !isset($_POST['size']) || !isset($_POST['color'])) {
    die("Required fields are missing.");
}

// Get the product_id and quantity from the form
$product_id = intval($_POST['product_id']);
$quantity = intval($_POST['quantity']);
$inventory_id = intval($_POST['inventory_id']);
// Validate quantity
if ($quantity <= 0) {
    die("Invalid quantity.");
}

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
if (!isset($_SESSION['inventory'])) {
    $_SESSION['inventory'] = [];
}

// Check if the product is already in the cart
if (isset($_SESSION['cart'][$product_id])) {
    // Update the quantity if the product already exists in the cart
    $_SESSION['cart'][$product_id] += $quantity;
} else {
    // Add the product to the cart
    $_SESSION['cart'][$product_id] = $quantity;
}


$_SESSION['inventory'][$product_id] = $inventory_id;

// Redirect to the cart page or display a success message
header("Location: cart.php");
exit();
?>
