<?php
// Start the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include necessary files
require_once($_SERVER['DOCUMENT_ROOT'] . '/StyleVerse/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/StyleVerse/controllers/OfferController.php');

// Check if the admin is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: /StyleVerse/views/auth/login.php'); // Redirect to admin login page
    exit();
}

$title = $image_url = $description = $discount = $start_date = $end_date = $status = $offerId = '';
$errors = [];
// Initialize CategoryController
$offerController = new OfferController($pdo);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $discount = $_POST['discount'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status = $_POST['status'];

    $image_url = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT']."/StyleVerse/assets/images/offers/".$image_url);


    if (!empty($_POST['offer_id'])) {
        $offerController->updateOffer($_POST['offer_id'], $title, $description, $discount, $image_url, $start_date, $end_date, $status);
    } else {
        $offerController->createOffer($title, $description, $discount, $image_url, $start_date, $end_date, $status);
    }
    header('Location: manage_offers.php');
    exit();
}
// Fetch category details if updating
if (isset($_GET['id'])) {
    $offerId = intval($_GET['id']);
    $offer = $offerController->getOffer($offerId);

    if ($offerId) {
        $title = $offer['title'];
        $description = $offer['description'];
        $discount = $offer['discount'];
        $start_date = $offer['start_date'];
        $end_date = $offer['end_date'];
        $status = $offer['status'];
        $image_url = $offer['image_url'];
        $offerId = $offer['offer_id'];
    } else {
        $_SESSION['error'] = "Offer not found.";
        header('Location: manage_offers.php');
        exit();
    }
}
?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?>
    <link rel="stylesheet" href="/StyleVerse/assets/css/add_product.css">
    <h1>Manage Offers</h1>

<div class="add-container">
    <form action="add_offer.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="offer_id" id="offer_id" value="<?= htmlspecialchars($offerId) ?>">
        <label>Title:</label>
        <input type="text" name="title" id="title" value="<?= htmlspecialchars($title) ?>" required>
        <label>Description:</label>
        <textarea name="description" id="description"><?= htmlspecialchars($description)?></textarea>
        <label>Discount:</label>
        <input type="number" step="0.01" name="discount" id="discount" value="<?= htmlspecialchars($discount) ?>" required>
        <label>Image:</label>
        <input type="file" name="image" id="image">
        <label>Start Date:</label>
        <input type="date" name="start_date" id="start_date" value="<?= htmlspecialchars($start_date) ?>" required>
        <label>End Date:</label>
        <input type="date" name="end_date" id="end_date" value="<?= htmlspecialchars($end_date) ?>" required>
        <label>Status:</label>
        <select name="status" id="status">
            <option value="active" <?= 'active' == $status ? 'selected' : '' ?>>Active</option>
            <option value="inactive" <?= 'inactive' == $status ? 'selected' : '' ?>>Inactive</option>
        </select>
        <button type="submit"><?= $offerId ? 'Update' : 'Add' ?> Offer</button>
    </form>
</div>

    <?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php'; ?>