
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/ReportController.php');

// Check if the admin is logged in
if ($_SESSION['role'] != 'admin') {
    header('Location: /StyleVerse/views/auth/login.php');
    exit;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your CSS for styling -->
</head>
<body>
    <header>
        <h1 style="text-align: center;">Sales Report</h1>
    </header>

    <section>
        <table style="width: 80%; margin: 20px auto; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Total Sales</th>
                    <th>Total Revenue</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if $salesData is not empty
                if (!empty($salesData)) {
                    foreach ($salesData as $data) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($data['product_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($data['total_sales']) . "</td>";
                        echo "<td>" . htmlspecialchars($data['total_revenue']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No sales data available.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <footer style="text-align: center; margin-top: 20px;">
        <p>&copy; 2025 StyleVerse. All rights reserved.</p>
    </footer>
</body>
</html>
