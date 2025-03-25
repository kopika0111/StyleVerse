<?php
class SearchHistory {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function saveSearch($userId, $keyword) {
        $stmt = $this->pdo->prepare("INSERT INTO search_history (user_id, keyword) VALUES (?, ?)");
        return $stmt->execute([$userId, $keyword]);
    }

    public function getUserSearches($userId, $limit = 10) {
        $stmt = $this->pdo->prepare("SELECT keyword FROM search_history WHERE user_id = ? ORDER BY searched_at DESC LIMIT ?");
        $stmt->execute([$userId, $limit]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
?>
