<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/StyleVerse/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/StyleVerse/models/Search.php');

// session_start();
// if (!isset($_SESSION['id'])) {
//     exit("Unauthorized");
// }

$search = new Search($pdo);
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['query'])) {
    $keywords = $_GET['query'];

    if ($products = $search->searchProducts($keywords)) {
        return $products;
    } else {
        echo json_encode(["status" => "error"]);
    }
}
?>