<?php
class Offer {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllOffers() {
        $stmt = $this->pdo->query("SELECT * FROM offers WHERE status = 'active' ORDER BY start_date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCurrentOffers() {
        $stmt = $this->pdo->query("SELECT * FROM offers
                           WHERE status = 'active'
                           AND CURDATE() BETWEEN start_date AND end_date
                           ORDER BY start_date DESC");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getOfferById($offer_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM offers WHERE offer_id = ?");
        $stmt->execute([$offer_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addOffer($title, $description, $discount, $image_url, $start_date, $end_date, $status) {
        $stmt = $this->pdo->prepare("INSERT INTO offers (title, description, discount, image_url, start_date, end_date, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$title, $description, $discount, $image_url, $start_date, $end_date, $status]);
    }

    public function updateOffer($offer_id, $title, $description, $discount, $image_url, $start_date, $end_date, $status) {
        $stmt = $this->pdo->prepare("UPDATE offers SET title = ?, description = ?, discount = ?, image_url = ?, start_date = ?, end_date = ?, status = ? WHERE offer_id = ?");
        return $stmt->execute([$title, $description, $discount, $image_url, $start_date, $end_date, $status, $offer_id]);
    }

    public function deleteOffer($offer_id) {
        $stmt = $this->pdo->prepare("DELETE FROM offers WHERE offer_id = ?");
        return $stmt->execute([$offer_id]);
    }
}
?>
