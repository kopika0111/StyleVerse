<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/SubCategoryController.php');


$subcategoryController = new SubCategoryController($pdo);
$subcategories = $subcategoryController->getAllSubCategories(); //$subcategoryController->getSubCategoriesByCategory($category_id);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'getSubCategoriesByCategory') {
    $categoryId = isset($_POST['categoryId']) ? intval($_POST['categoryId']) : 0;

    // Instantiate the class and call the function
    $result = $subcategoryController->getSubCategoriesByCategory($categoryId);

    // Return the result as a response
    echo json_encode($result);
}
 