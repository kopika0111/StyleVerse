<?php
class SubCategory {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllSubCategories() {
        $sql = "SELECT sc.subcategory_id, sc.subcategory_name, sc.description, sc.image_url, sc.created_at, sc.updated_at, c.name AS category_name, c.category_id
                FROM subcategories sc
                JOIN categories c ON sc.category_id = c.category_id";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addSubCategory($name, $categoryId, $description, $imageUrl) {
        $sql = "INSERT INTO subcategories (subcategory_name, category_id, description, image_url, created_at) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$name, $categoryId, $description, $imageUrl]);
    }

    public function updateSubCategory($subcategoryId, $name, $categoryId, $description, $imageUrl) {
        // Start building the update query dynamically
        $sql = "UPDATE subcategories SET subcategory_name = ?, category_id = ?, description = ?, updated_at = NOW()";
        $params = [$name, $categoryId, $description];

        // Only update image_url if a new one is provided
        if (!empty($imageUrl)) {
            $sql .= ", image_url = ?";
            $params[] = $imageUrl;
        }

        // Finalizing query
        $sql .= " WHERE subcategory_id = ?";
        $params[] = $subcategoryId;

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function deleteSubCategory($subcategoryId) {
        $sql = "DELETE FROM subcategories WHERE subcategory_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$subcategoryId]);
    }

    public function getCategories() {
        $sql = "SELECT * FROM categories";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSubCategoriesByCategory($categoryId) {
        $sql = "SELECT sc.subcategory_id, sc.subcategory_name, sc.description, sc.image_url, sc.created_at, sc.updated_at, c.name AS category_name, c.category_id
                FROM subcategories sc
                JOIN categories c ON sc.category_id = c.category_id
                WHERE c.category_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSubCategoriesById($subcategoryId) {
        $sql = "SELECT sc.subcategory_id, sc.subcategory_name, sc.description, sc.image_url, sc.created_at, sc.updated_at, c.name AS category_name, c.category_id
                FROM subcategories sc
                JOIN categories c ON sc.category_id = c.category_id
                WHERE sc.subcategory_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$subcategoryId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getSubCategoryCount() {
        $sql = "SELECT COUNT(*) AS subcategory_count FROM subcategories"; // Alias the count
        $stmt = $this->pdo->query($sql); // Execute the query
        $result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch as associative array
        return $result['subcategory_count']; // Return the count
    }
}
?>
