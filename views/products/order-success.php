<?php
// Start the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require_once($_SERVER['DOCUMENT_ROOT'] . '/StyleVerse/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/StyleVerse/controllers/OrderController.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/StyleVerse/vendor/autoload.php'); // For PHPMailer and Dompdf

use Dompdf\Dompdf;
use Dompdf\Options;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if order ID is set in the session
if (!isset($_SESSION['order_id'])) {
    header("Location: /StyleVerse/index.php"); // Redirect to homepage if no order ID
    exit();
}

$order_id = $_SESSION['order_id']; // Retrieve order ID from session

// Fetch order details
$orderController = new OrderController($pdo);
$order_info = $orderController->getOrderById($order_id);
$order = $order_info['order'];
$discount = $order['total_amount'] - $order['final_amount'];

// Fetch ordered items
$order_items = $order_info['items'];

// Fetch shipping details
$shipping_details = $orderController->getShippingDetails($order_id);

$email = $_SESSION['email'] ?? 'dilushan0314@gmail.com';
// Clear order session data (optional)
unset($_SESSION['order_id']);
?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?>

<link rel="stylesheet" href="/StyleVerse/assets/css/order_success.css">
<main class="container">
    <div class="order-success">
        <h1>🎉 Thank You for Your Order!</h1>
        <p>Your order <strong>#<?= htmlspecialchars($order['order_id']) ?></strong> has been successfully placed.</p>
        <p><strong>Sub Total:</strong> LKR. <?= number_format($order['total_amount'], 2) ?></p>
        <p><strong>Discount Price:</strong> - LKR. <?= number_format($discount, 2) ?></p>
        <p><strong>Total Price:</strong> LKR. <?= number_format($order['final_amount'], 2) ?></p>
        <p><strong>Shipping Address:</strong> <?= htmlspecialchars($shipping_details['shipping_address']) ?></p>

        <h2>Order Summary</h2>
        <div class="order-items">
            <?php foreach ($order_items as $item): ?>
                <div class="order-item">
                    <img src="/StyleVerse/assets/images/products/<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>">
                    <div>
                        <h3><?= htmlspecialchars($item['product_name']) ?></h3>
                        <p>Size: <?= $item['size'] ?></p>
                        <p>Color: <?= $item['color'] ?></p>
                        <p>Quantity: <?= $item['quantity'] ?></p>
                        <p>Price: LKR. <?= number_format($item['price'], 2) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <a href="/StyleVerse/index.php" class="btn">Continue Shopping</a>
    </div>
</main>

<?php
// Only capture this summary section for PDF
ob_start();
?>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        h2 { margin-bottom: 10px; }
        ul { padding-left: 20px; }
        li { margin-bottom: 5px; }
    </style>
</head>
<body>
    <h2>Order Receipt Summary</h2>
    <p><strong>Order ID:</strong> <?= $order['order_id'] ?></p>
    <p><strong>Sub Total:</strong> LKR. <?= number_format($order['total_amount'], 2) ?></p>
    <p><strong>Discount Price:</strong> - LKR. <?= number_format($discount, 2) ?></p>
    <p><strong>Total Price:</strong> LKR. <?= number_format($order['final_amount'], 2) ?></p>
    <p><strong>Shipping Address:</strong> <?= htmlspecialchars($shipping_details['shipping_address']) ?></p>

    <h3>Items:</h3>
    <ul>
        <?php foreach ($order_items as $item): ?>
            <div class="order-item">
                <img src="/StyleVerse/assets/images/products/<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>">
                <div>
                    <h3><?= htmlspecialchars($item['product_name']) ?></h3>
                    <p>Size: <?= $item['size'] ?></p>
                    <p>Color: <?= $item['color'] ?></p>
                    <p>Quantity: <?= $item['quantity'] ?></p>
                    <p>Price: LKR. <?= number_format($item['price'], 2) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </ul>
</body>
</html>
<?php
$pdf_html = ob_get_clean();

// Generate PDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($pdf_html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$pdfOutput = $dompdf->output();
$pdfPath = $_SERVER['DOCUMENT_ROOT'] . "/StyleVerse/assets/order_pdfs/order_receipt_{$order_id}.pdf";
file_put_contents($pdfPath, $pdfOutput);

// Send email
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP host
    $mail->SMTPAuth = true;
    $mail->Username = 'kopikaselvarasa81@gmail.com';
    $mail->Password = 'eqyg akwr kdhi emdh';
    $mail->SMTPSecure =  PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('kopikaselvarasa81@gmail.com', 'StyleVerse');
    $mail->clearAddresses();
    $mail->addAddress($email);
    $mail->addAttachment($pdfPath);
    $mail->isHTML(true);
    $mail->Subject = 'Your StyleVerse Order Receipt';
    $mail->Body    = 'Thank you for your purchase. Please find your receipt attached.';

    $mail->send();
} catch (Exception $e) {
    error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
}
?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php'; ?>
