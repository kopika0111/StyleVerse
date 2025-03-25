<?php
    // Start session if needed
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - StyleVerse</title>
    <link rel="stylesheet" href="/StyleVerse/assets/css/privacy_policy.css"> <!-- Link to CSS file -->
</head>
<body>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?>

    <div class="privacy-container">
        <h1>Privacy Policy</h1>
        <p>Welcome to StyleVerse! Your privacy is important to us. This Privacy Policy explains how we collect, use, and protect your personal data.</p>

        <h2> Information We Collect</h2>
        <p>We collect various types of personal data, including your name, email, shipping address, and payment details when you place an order or sign up for an account.</p>

        <h2> How We Use Your Information</h2>
        <ul>
            <li>To process and fulfill your orders.</li>
            <li>To improve our website experience.</li>
            <li>To send promotional emails and updates.</li>
            <li>To prevent fraud and ensure security.</li>
        </ul>

        <h2> Cookies and Tracking</h2>
        <p>We use cookies to improve your browsing experience. You can disable cookies in your browser settings.</p>

        <h2> Data Protection</h2>
        <p>We take security seriously and use encryption and secure servers to protect your data.</p>

        <h2> Contact Us</h2>
        <p>If you have any questions about this Privacy Policy, contact us at <a href="mailto:support@styleverse.com">support@styleverse.com</a>.</p>
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php'; ?>
</body>
</html>
