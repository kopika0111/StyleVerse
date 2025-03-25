<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database configuration
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $cart = [];
} else {
    $cart = $_SESSION['cart'];
}

$inventories = !isset($_SESSION['inventory']) || empty($_SESSION['inventory']) ?  [] : $_SESSION['inventory'];

// Fetch product details for items in the cart
$productsInCart = [];
if (!empty($cart)) {
    try {
        // Prepare a query to fetch products based on IDs in the cart
        $placeholders = implode(',', array_fill(0, count($inventories), '?'));
        $stmt = $pdo->prepare("SELECT
            p.product_id,
            p.name,
            p.image_url,
            COALESCE(i.price, p.price) AS price,  -- Use inventory price if available, otherwise product price
            i.inventory_id,
            i.size,
            i.color,
            i.quantity
        FROM products p
        LEFT JOIN inventory i ON p.product_id = i.product_id
        WHERE i.inventory_id IN ($placeholders)");
        $stmt->execute(array_values($inventories));
        $productsInCart = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
// Calculate the total cost of items in the cart
$totalAmount = 0;
foreach ($productsInCart as $key => $value) {
    $productsInCart[$key]['quantity'] = $cart[$value['product_id']];
    $productsInCart[$key]['subtotal'] = (float)$value['price'] * $productsInCart[$key]['quantity'];
    $totalAmount += $productsInCart[$key]['subtotal'];

    $_SESSION['add_cart'][$value['product_id']]['price']  = $productsInCart[$key]['price'];
    $_SESSION['add_cart'][$value['product_id']]['subtotal']  = $productsInCart[$key]['subtotal'];
    $_SESSION['add_cart'][$value['product_id']]['quantity']  = $productsInCart[$key]['quantity'];
    $_SESSION['add_cart'][$value['product_id']]['name']  = $value['name'];
}
?>


<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?> <!--Include the header -->
<link rel="stylesheet" href="/StyleVerse/assets/css/cart.css">
    <main>
        <div class="cart-container">
            <h1>Your Shopping Cart</h1>

            <?php if (empty($productsInCart)): ?>
                <p>Your cart is empty. <a href="view_products.php">Continue shopping</a>.</p>
            <?php else: ?>
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productsInCart as $product): ?>
                            <tr>
                                <td>
                                    <img src="/StyleVerse/assets/images/products/<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="cart-image">
                                    <?= htmlspecialchars($product['name']) ?>
                                </td>
                                <td>LKR. <?= number_format($product['price'], 2) ?></td>
                                <td>
                                    <form method="POST" action="update_cart.php">
                                        <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                        <input type="number" name="quantity" value="<?= $product['quantity'] ?>" min="1" required>
                                        <button type="submit">Update</button>
                                    </form>
                                </td>
                                <td>LKR. <?= number_format($product['subtotal'], 2) ?></td>
                                <td>
                                    <form method="POST" action="remove_from_cart.php">
                                        <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                        <button type="submit">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="cart-summary">
                    <h3>Total: LKR. <?= number_format($totalAmount, 2) ?></h3>
                    <a href="checkout.php" class="btn">Proceed to Checkout</a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php'; ?> <!-- Include the footer -->
