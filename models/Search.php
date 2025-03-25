<?php
class Search {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Add an item to an order
    public function searchProducts($searchTerm) {
        $keywords = explode(' ', trim($searchTerm)); // Split by spaces
        $conditions = [];
        $params = [];

        foreach ($keywords as $keyword) {
            $conditions[] = "(p.name LIKE ?  OR p.tags LIKE ? OR c.name LIKE ? OR s.subcategory_name LIKE ?)";
            $wildcardSearch = "%$keyword%";
            array_push($params, $wildcardSearch, $wildcardSearch, $wildcardSearch, $wildcardSearch);
        }

        $sql = "SELECT p.*, c.name AS category_name, s.subcategory_name
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.category_id
                LEFT JOIN subcategories s ON p.subcategory_id = s.subcategory_id
                WHERE " . implode(" AND ", $conditions); // AND ensures all keywords match
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}