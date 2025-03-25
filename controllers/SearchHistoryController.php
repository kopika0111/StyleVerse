<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/models/SearchHistory.php');

class SearchHistoryController {
    private $model;

    public function __construct($pdo) {
        $this->model = new SearchHistory($pdo);
    }

    public function store($userId, $keyword) {
        return $this->model->saveSearch($userId, $keyword);
    }

    public function recentSearches($userId, $limit = 10) {
        return $this->model->getUserSearches($userId, $limit);
    }
}
?>
