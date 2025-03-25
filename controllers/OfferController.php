<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/models/Offer.php');

class OfferController {
    private $offerModel;

    public function __construct($pdo) {
        $this->offerModel = new Offer($pdo);
    }

    public function getAllOffers() {
        return $this->offerModel->getAllOffers();
    }

    public function getCurrentOffers() {
        return $this->offerModel->getCurrentOffers();
    }
    public function getOffer($offer_id) {
        return $this->offerModel->getOfferById($offer_id);
    }

    public function createOffer($title, $description, $discount, $image_url, $start_date, $end_date, $status) {
        return $this->offerModel->addOffer($title, $description, $discount, $image_url, $start_date, $end_date, $status);
    }

    public function updateOffer($offer_id, $title, $description, $discount, $image_url, $start_date, $end_date, $status) {
        return $this->offerModel->updateOffer($offer_id, $title, $description, $discount, $image_url, $start_date, $end_date, $status);
    }

    public function deleteOffer($offer_id) {
        return $this->offerModel->deleteOffer($offer_id);
    }
}
?>
