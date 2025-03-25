<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/OfferController.php');

$offerController = new OfferController($pdo);
$offers = $offerController->getAllOffers();

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $offerController->deleteOffer($_GET['id']);
    $_SESSION['message'] = 'Category deleted successfully!';
    header('Location: manage_offers.php');
    exit;
}
?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?>
    <link rel="stylesheet" href="/StyleVerse/assets/css/manage_category.css">

<div class="container">
<h1>Manage Offers</h1>

<a href="/StyleVerse/views/admin/add_offer.php" class="btn">Add New Offer</a>
    <h2>Existing Offers</h2>
    <table class="table">
        <tr>
            <th>Title</th>
            <th>Discount</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($offers as $offer): ?>
            <tr>
                <td><?= $offer['title'] ?></td>
                <td><?= $offer['discount'] ?>%</td>
                <td><?= $offer['start_date'] ?></td>
                <td><?= $offer['end_date'] ?></td>
                <td>
                    <a href="/StyleVerse/views/admin/add_offer.php?action=edit&id=<?= $offer['offer_id'] ?>" class="btn edit-btn">Edit</a>
                    <a href="manage_offers.php?action=delete&id=<?= $offer['offer_id'] ?>" onclick="return confirm('Are you sure?')" class="btn delete-btn">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

    <?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php'; ?>
