<?php
class Category {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Create a new category
    public function createCategory($name, $image) {
        $sql = "INSERT INTO categories (name, image_url) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$name, $image]);
    }

    // Read all categories
    public function getAllCategories() {
        $sql = "SELECT * FROM categories";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Read category by ID
    public function getCategoryById($categoryId) {
        $sql = "SELECT * FROM categories WHERE category_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$categoryId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update category details
    public function updateCategory($categoryId, $name, $image = null) {
        if (!empty($image)) {
            // Update name and image
            $sql = "UPDATE categories SET name = ?, image_url = ? WHERE category_id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$name, $image, $categoryId]);
        } else {
            // Update only the name
            $sql = "UPDATE categories SET name = ? WHERE category_id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$name, $categoryId]);
        }
    }


    // Delete a category
    public function deleteCategory($categoryId) {
        $sql = "DELETE FROM products WHERE category_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$categoryId]);

        $sql = "DELETE FROM subcategories WHERE category_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$categoryId]);

        $sql = "DELETE FROM categories WHERE category_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$categoryId]);
    }
    public function getCategoryCount() {
        $sql = "SELECT COUNT(*) AS category_count FROM categories"; // Alias the count
        $stmt = $this->pdo->query($sql); // Execute the query
        $result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch as associative array
        return $result['category_count']; // Return the count
    }

    public function getCategoriesWithSubcategories() {
        $sql = "
            SELECT c.category_id, c.name as category_name, sc.subcategory_id, sc.subcategory_name
            FROM categories c
            LEFT JOIN subcategories sc ON c.category_id = sc.category_id
            ORDER BY c.category_id, sc.subcategory_name
        ";
        $stmt = $this->pdo->query($sql);

        $categories = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categoryId = $row['category_id'];
            if (!isset($categories[$categoryId])) {
                $categories[$categoryId] = [
                    'name' => $row['category_name'],
                    'subcategories' => [],
                ];
            }

            if ($row['subcategory_id']) {
                $categories[$categoryId]['subcategories'][] = [
                    'id' => $row['subcategory_id'],
                    'name' => $row['subcategory_name'],
                ];
            }
        }
        return $categories;
    }
}