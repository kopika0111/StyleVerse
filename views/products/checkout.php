<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once($_SERVER['DOCUMENT_ROOT'] . '/StyleVerse/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/StyleVerse/controllers/OrderController.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/StyleVerse/controllers/OrderItemController.php');

if (!isset($_SESSION['id'])) {
    header("Location: /StyleVerse/views/auth/login.php");
    exit;
}

$userId = $_SESSION['id'];
$cart = $_SESSION['cart'] ?? [];
$add_cart = $_SESSION['add_cart'] ?? [];
$totalAmount = 0.0;

foreach ($add_cart as $item) {
    $totalAmount += $item['price'] * (float)$item['quantity'];
}

$currentDate = date("Y-m-d");
$stmt = $pdo->prepare("SELECT * FROM offers WHERE start_date <= ? AND end_date >= ? AND status = 'active' ORDER BY discount DESC LIMIT 1");
$stmt->execute([$currentDate, $currentDate]);
$activeOffer = $stmt->fetch(PDO::FETCH_ASSOC);
$offerId = $activeOffer ? $activeOffer['offer_id'] : null;
$discountPercent = $activeOffer ? $activeOffer['discount'] : 0;
$discountAmount = ($discountPercent / 100) * $totalAmount;
$finalAmount = $totalAmount - $discountAmount;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $shippingName = $_POST['shipping_name'];
    $shippingAddress = $_POST['shipping_address'];
    $shippingPhone = $_POST['shipping_phone'];
    $paymentMethod = $_POST['payment_method'];

    if (empty($shippingName) || empty($shippingAddress) || empty($shippingPhone) || empty($paymentMethod)) {
        $error = "All fields are required.";
    } else {
        if ($paymentMethod === 'card') {
            $_SESSION['pending_order'] = [
                'user_id' => $userId,
                'total_amount' => $totalAmount,
                'final_amount' => $finalAmount,
                'offer_id' => $offerId,
                'payment_method' => $paymentMethod,
                'payment_status' => 'paid',
                'shipping_name' => $shippingName,
                'shipping_address' => $shippingAddress,
                'shipping_phone' => $shippingPhone,
            ];
            header("Location: /StyleVerse/views/products/mock_payment.php");
            exit;
        } else {
            $data = [
                'user_id' => $userId,
                'total_amount' => $totalAmount,
                'final_amount' => $finalAmount,
                'offer_id' => $offerId,
                'payment_method' => $paymentMethod,
                'payment_status' => 'pending',
                'transaction_id' => 'COD-' . rand(10000, 99999)
            ];

            $orderController = new OrderController($pdo);
            $orderId = $orderController->createOrder($data);
            if ($orderId) {
                $stmt = $pdo->prepare("INSERT INTO shipping_details (order_id, user_id, shipping_name, shipping_address, shipping_phone) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$orderId, $userId, $shippingName, $shippingAddress, $shippingPhone]);

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
                header("Location: order-success.php");
                exit;
            } else {
                $error = "Failed to process the order.";
            }
        }
    }
}
?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/StyleVerse/views/partials/header.php'; ?>
<link rel="stylesheet" href="/StyleVerse/assets/css/add_product.css">

<div class="checkout-page">
    <div class="add-container">
        <h1>Checkout</h1>
        <?php if (!empty($error)): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" id="checkout-form" action="checkout.php">
            <input type="hidden" name="stripe_token" id="stripe_token">
            <div class="form-group">
                <label for="shipping_name">Full Name</label>
                <input type="text" name="shipping_name" id="shipping_name" required>
            </div>
            <div class="form-group">
                <label for="shipping_address">Shipping Address</label>
                <textarea name="shipping_address" id="shipping_address" required></textarea>
            </div>
            <div class="form-group">
                <label for="shipping_phone">Phone Number</label>
                <input type="text" name="shipping_phone" id="shipping_phone" required>
            </div>
            <div class="form-group">
                <label for="payment_method">Payment Method</label>
                <select name="payment_method" id="payment_method" required>
                    <option value="">Select Payment Method</option>
                    <option value="cod">Cash on Delivery</option>
                    <option value="card">Credit Card</option>
                </select>
            </div>
            <div id="card-section" style="display: none;">
                <div id="card-element"></div>
            </div>

            <div class="order-summary">
                <h2>Order Summary</h2>
                <ul>
                    <?php foreach ($add_cart as $item): ?>
                        <li>
                            <?= htmlspecialchars($item['name']) ?> - <?= htmlspecialchars($item['quantity']) ?> × LKR .<?= htmlspecialchars($item['price']) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <p>Subtotal: LKR <?= number_format($totalAmount, 2) ?></p>
                <?php if ($activeOffer): ?>
                    <p>Offer Applied: <?= htmlspecialchars($activeOffer['title']) ?> (<?= $discountPercent ?>% OFF)</p>
                    <p>Discount: - LKR <?= number_format($discountAmount, 2) ?></p>
                <?php endif; ?>
                <h3>Total: LKR <?= number_format($finalAmount, 2) ?></h3>
            </div>
            <button type="submit" class="btn">Place Order</button>
        </form>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe("pk_test_XXXXXXXXXXXXXXXXXXXX"); // Replace with your key
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    document.getElementById('payment_method').addEventListener('change', function () {
        document.getElementById('card-section').style.display = (this.value === 'card') ? 'block' : 'none';
    });

    const form = document.getElementById('checkout-form');
    form.addEventListener('submit', async function (e) {
        const method = document.getElementById('payment_method').value;

        if (method === 'card') {
            // e.preventDefault();

            // const {token, error} = await stripe.createToken(card);

            // if (error) {
            //     alert(error.message);
            //     return;
            // }

            // document.getElementById('stripe_token').value = token.id;
            // form.submit();
        }
    });
</script>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/StyleVerse/views/partials/footer.php'; ?>
