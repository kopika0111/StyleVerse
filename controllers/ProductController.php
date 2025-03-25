<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/models/Product.php');

class ProductController {
    private $productModel;

    public function __construct($pdo) {
        $this->productModel = new Product($pdo);
    }

    public function addProduct($name, $description, $price, $categoryId, $subcategoryId, $imageUrl, $additionalImagesJson, $tags) {
        return $this->productModel->createProduct($name, $description, $price, $categoryId, $subcategoryId, $imageUrl, $additionalImagesJson, $tags);
    }

    public function updateProduct($productId, $name, $description, $price, $imageUrl, $categoryId, $subcategoryId, $additionalImagesJson, $tags){
        return $this->productModel->updateProduct($productId, $name, $description, $price, $imageUrl, $categoryId, $subcategoryId, $additionalImagesJson, $tags);
    }
    public function getProductById($productId) {
        return $this->productModel->getProductById($productId);
    }

    public function getProductWithInventory($productId) {
        return $this->productModel->getProductWithInventory($productId);
    }

    public function getAllProducts() {
        return $this->productModel->getAllProducts();
    }

    public function deleteProduct($productId) {
        return $this->productModel->deleteProduct($productId);
    }
    public function getProductCount() {
        return $this->productModel->getProductCount();
    }

    public function getProductsByCategory($categoryId) {
        return $this->productModel->getProductsByCategory($categoryId);
    }

    public function getProductsBySubCategory($subCategoryId) {
        return $this->productModel->getProductsBySubCategory($subCategoryId);
    }
}
?>
