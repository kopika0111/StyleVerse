<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/models/Report.php');


class ReportController {
    // Function to display the sales report
    public function showSalesReport() {
        // Fetch the sales data from the model
        $salesData = ReportModel::getSalesData();

        // Pass the sales data to the view to be rendered
        ReportView::renderSalesReport($salesData);
    }

    // Add other report methods (e.g., product report, inventory report) as needed
    public function showProductReport() {
        // Fetch the product data from the model
        $productData = ReportModel::getProductData();

        // Pass the product data to the view
        ReportView::renderProductReport($productData);
    }
}
?>
