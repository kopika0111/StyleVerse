<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/models/SubCategory.php');

class SubCategoryController {
    private $subCategoryModel;

    public function __construct($pdo) {
        $this->subCategoryModel = new SubCategory($pdo);
    }

    public function getAllSubCategories() {
        return $this->subCategoryModel->getAllSubCategories();
    }

    public function addSubCategory($name, $categoryId, $description, $imageUrl) {
        return $this->subCategoryModel->addSubCategory($name, $categoryId, $description, $imageUrl);
    }

    public function updateSubCategory($subcategoryId, $name, $categoryId, $description, $imageUrl) {
        return $this->subCategoryModel->updateSubCategory($subcategoryId, $name, $categoryId, $description, $imageUrl);
    }

    public function deleteSubCategory($subcategoryId) {
        return $this->subCategoryModel->deleteSubCategory($subcategoryId);
    }

    public function getCategories() {
        return $this->subCategoryModel->getCategories();
    }

    public function getSubCategoriesByCategory($categoryId) {
        return $this->subCategoryModel->getSubCategoriesByCategory($categoryId);
    }

    public function getSubCategoriesById($subcategoryId) {
        return $this->subCategoryModel->getSubCategoriesById($subcategoryId);
    }

    public function getSubCategoryCount() {
        return $this->subCategoryModel->getSubCategoryCount();
    }
}
?>
