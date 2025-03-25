<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/models/Category.php');

class CategoryController {
    private $categoryModel;

    public function __construct($pdo) {
        $this->categoryModel = new Category($pdo);
    }

    public function addCategory($name, $image) {
        return $this->categoryModel->createCategory($name, $image);
    }

    public function updateCategory($categoryId, $name, $image) {
        return $this->categoryModel->updateCategory($categoryId, $name, $image) ;
    }

    public function getAllCategories() {
        return $this->categoryModel->getAllCategories();
    }

    public function deleteCategory($categoryId) {
        return $this->categoryModel->deleteCategory($categoryId);
    }

    public function getCategoryById($categoryId) {
        return $this->categoryModel->getCategoryById($categoryId);
    }
    public function getCategoryCount() {
        return $this->categoryModel->getCategoryCount();
    }

    public function getCategoriesWithSubcategories() {
        return $this->categoryModel->getCategoriesWithSubcategories();
    }
}
?>
