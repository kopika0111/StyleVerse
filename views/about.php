<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['user_name'] : null;
?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?> <!-- Include the header -->
<link rel="stylesheet" href="/StyleVerse/assets/css/about.css">
<div class="about-container">
    <div class="container">
        <h1>About Us</h1>
        <p>Welcome to <strong>StyleVerse</strong>, your personalized clothing e-commerce platform. At StyleVerse, we aim to redefine online shopping by offering tailored recommendations that match your style and preferences. Our platform uses advanced machine learning algorithms to provide a seamless and personalized shopping experience.</p>

        <h2>Our Mission</h2>
        <p>To make online shopping efficient, enjoyable, and personalized for everyone. We believe that every shopper deserves a unique experience, and we are committed to delivering just that.</p>

        <h2>Why Choose StyleVerse?</h2>
        <ul>
            <li>Wide variety of clothing for kids, men, and women</li>
            <li>Personalized product recommendations</li>
            <li>Exclusive deals and offers</li>
            <li>Seamless shopping experience</li>
            <li>Secure and reliable checkout</li>
        </ul>

        <h2>Contact Us</h2>
        <p>We love hearing from our customers! If you have any questions, feedback, or suggestions, feel free to reach out to us:</p>
        <p>Email: <a href="mailto:support@Styleverse.com">support@Styleverse.com</a></p>
        <p>Phone: +123 456 7890</p>
        <p>Address: 123 Fashion Street, Style City, SC 45678</p>
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php'; ?> <!-- Include the footer -->
