<?php
class Product {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Create a new product
    public function createProduct($name, $description, $price, $categoryId, $subcategoryId, $imageUrl, $additionalImagesJson, $tags) {
        $sql = "INSERT INTO products (name, description, price, category_id, subcategory_id, image_url, additionalImages, tags) VALUES (?, ?, ?, ?, ?, ?, ?,?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$name, $description, $price, $categoryId, $subcategoryId, $imageUrl, $additionalImagesJson, implode(',', $tags)]);
    }

    // Read all products
    public function getAllProducts() {
        $sql = "SELECT
                    s.subcategory_name,
                    c.name as category_name,
                    p.name as product_name,
                    p.product_id,
                    p.image_url,
                    p.additionalImages,
                    p.description,
                    p.price,
                    p.tags
                FROM products p
                LEFT JOIN subcategories s ON s.subcategory_id = p.subcategory_id
                LEFT JOIN categories c ON c.category_id = p.category_id";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Read product details by ID
    public function getProductById($productId) {
        $sql = "SELECT
                    s.subcategory_name,
                    c.name as category_name,
                    p.name as product_name,
                    c.category_id,
                    s.subcategory_id,
                    p.product_id,
                    p.image_url,
                    p.additionalImages,
                    p.description,
                    p.price,
                    p.tags
                FROM products  p
                LEFT JOIN subcategories s
                    ON s.subcategory_id = p.subcategory_id
                LEFT JOIN categories c
                    ON c.category_id = p.category_id
                WHERE product_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$productId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update product details
    public function updateProduct($productId, $name, $description, $price, $imageUrl, $categoryId, $subcategoryId, $additionalImagesJson, $tags) {
         // Start building the update query dynamically
        $sql = "UPDATE products SET name = ?, description = ?, price = ?, category_id = ?, subcategory_id = ?, tags = ?";
        $params = [$name, $description, $price, $categoryId, $subcategoryId, implode(',', $tags)];

        // Only update image_url if a new one is provided
        if (!empty($imageUrl)) {
            $sql .= ", image_url = ?";
            $params[] = $imageUrl;
        }

        // Only update additionalImages if a new one is provided
        if (!empty($additionalImagesJson)) {
            $sql .= ", additionalImages = ?";
            $params[] = $additionalImagesJson;
        }

        // Finalizing query
        $sql .= " WHERE product_id = ?";
        $params[] = $productId;

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    // Delete a product
    public function deleteProduct($productId) {
        
        

        $sql = "DELETE FROM inventory WHERE product_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$productId]);

        $sql = "DELETE FROM products WHERE product_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$productId]);
    }
    public function getProductWithInventory($product_id) {
        $sql = "
            SELECT
                p.name as product_name,
                p.*,
                i.inventory_id, i.size, i.color, i.quantity, i.price AS inventory_price,
                c.name as category_name,
                sc.subcategory_name
            FROM products p
            LEFT JOIN inventory i ON p.product_id = i.product_id
            LEFT JOIN categories c
                ON p.category_id = c.category_id
            LEFT JOIN subcategories sc
                ON p.subcategory_id = sc.subcategory_id
            WHERE p.product_id = :product_id AND (i.quantity > 0 OR i.quantity IS NULL)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':product_id' => $product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductCount() {
        $sql = "SELECT COUNT(*) AS product_count FROM products"; // Alias the count
        $stmt = $this->pdo->query($sql); // Execute the query
        $result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch as associative array
        return $result['product_count']; // Return the count
    }

    public function getProductsByCategory($categoryId) {
        $sql = "SELECT
                    s.subcategory_name,
                    c.name as category_name,
                    p.name as product_name,
                    p.product_id,
                    p.image_url,
                    p.additionalImages,
                    p.description,
                    p.price,
                    p.tags
                FROM products p
                LEFT JOIN subcategories s ON s.subcategory_id = p.subcategory_id
                LEFT JOIN categories c ON c.category_id = p.category_id
                WHERE c.category_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductsBySubCategory($subCategoryId) {
        $sql = "SELECT
                    s.subcategory_name,
                    c.name as category_name,
                    p.name as product_name,
                    p.product_id,
                    p.image_url,
                    p.additionalImages,
                    p.description,
                    p.price,
                    p.tags
                FROM products p
                LEFT JOIN subcategories s ON s.subcategory_id = p.subcategory_id
                LEFT JOIN categories c ON c.category_id = p.category_id
                WHERE s.subcategory_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$subCategoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
