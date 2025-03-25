<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/SearchHistoryController.php');

session_start();
if (isset($_GET['query']) && isset($_SESSION['id'])) {
    $searchTerm = trim($_GET['query']);
    $userId = $_SESSION['id'];

    $history = new SearchHistoryController($pdo);
    $history->store($userId, $searchTerm); 

}

?>