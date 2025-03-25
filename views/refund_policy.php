<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund Policy - StyleVerse</title>
    <link rel="stylesheet" href="/StyleVerse/assets/css/refund_policy.css"> <!-- Link to CSS file -->
</head>
<body>

    <<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?>

    <div class="refund-container">
        <h1>Refund Policy</h1>
        <p>At StyleVerse, customer satisfaction is our priority. If you are not completely satisfied with your purchase, please review our refund policy below.</p>

        <h2> Eligibility for Refund</h2>
        <ul>
            <li>Items must be returned within <strong>30 days</strong> of purchase.</li>
            <li>Products must be unused, unworn, and in their original packaging.</li>
            <li>Refunds will not be processed for items that show signs of wear or damage.</li>
        </ul>

        <h2> Non-Refundable Items</h2>
        <p>Certain items are non-refundable, including:</p>
        <ul>
            <li>Gift cards</li>
            <li>Final sale or clearance items</li>
            <li>Personalized or custom-made products</li>
        </ul>

        <h2> Refund Process</h2>
        <p>Once we receive your returned item, we will inspect it and notify you of the approval or rejection of your refund. If approved, your refund will be processed within <strong>5-7 business days</strong> back to your original payment method.</p>

        <h2> Return Shipping</h2>
        <p>Customers are responsible for return shipping costs unless the item was defective or incorrect. We recommend using a trackable shipping service.</p>

        <h2> Contact Us</h2>
        <p>For any refund-related queries, reach out to us at <a href="mailto:support@styleverse.com">support@styleverse.com</a>.</p>

    </div>

</body>
<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php';?>
</html>
