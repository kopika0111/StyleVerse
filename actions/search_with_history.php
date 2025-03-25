<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/StyleVerse/controllers/SearchController.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/SearchHistoryController.php');

header('Content-Type: application/json');

if (isset($_GET['query'])) {
    $searchTerm = trim($_GET['query']);
    
    // Save to search history if user is logged in
    if (isset($_SESSION['id']) && !empty($searchTerm)) {
        $userId = $_SESSION['id'];
        $historyController = new SearchHistoryController($pdo);
        $historyController->store($userId, $searchTerm);
    }

    echo json_encode($products);
    exit;
}
?>
