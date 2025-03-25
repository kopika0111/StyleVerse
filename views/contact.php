<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$successMessage = $errorMessage = "";
// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['user_name'] : null;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    if ($name && $email && $message) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'kopikaselvarasa81@gmail.com';
            $mail->Password = 'eqyg akwr kdhi emdh'; // App password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('kopikaselvarasa81@gmail.com', 'StyleVerse Contact Form');
            $mail->isHTML(true);
            $mail->clearAddresses();
            $mail->addAddress('kopikaselvarasa81@gmail.com');
            $mail->Subject = 'New Contact Form Message';
            $mail->Body = "
                <strong>Name:</strong> {$name}<br>
                <strong>Email:</strong> {$email}<br>
                <strong>Message:</strong><br>" . nl2br($message);

            $mail->send();
            $successMessage = "Your message has been sent successfully!";
        } catch (Exception $e) {
            $errorMessage = "Mail Error: {$mail->ErrorInfo}";
        }
    }
}
?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?> <!-- Include the header -->
<link rel="stylesheet" href="/StyleVerse/assets/css/contact.css">
<div class="contact-container">
    <div class="container">
        <h1>Contact Us</h1>
        <p>If you have any questions, feedback, or concerns, please don't hesitate to reach out to us. We're here to help!</p>

        <?php if (isset($successMessage)): ?>
            <p class="success-message"><?= $successMessage ?></p>
        <?php endif; ?>

        <?php if (isset($errorMessage)): ?>
            <p class="error-message"><?= $errorMessage ?></p>
        <?php endif; ?>

        <form method="POST" action="contact.php" class="contact-form">
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Your Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Your Message</label>
                <textarea id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn">Send Message</button>
        </form>

        <div class="contact-info">
            <h2>Our Contact Details</h2>
            <p>Email: <a href="mailto:support@Styleverse.com">support@Styleverse.com</a></p>
            <p>Phone: +123 456 7890</p>
            <p>Address: 123 Fashion Street, Style City, SC 45678</p>
        </div>
    </div>
</div>
?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php';?>  <!-- Include the footer -->
