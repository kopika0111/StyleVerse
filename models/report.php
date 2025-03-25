<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "styleverse"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get sales data (adjust according to your table structure)
$sql = "SELECT product_name, SUM(quantity) AS total_sales, SUM(total_price) AS total_revenue 
        FROM sales 
        GROUP BY product_name 
        ORDER BY total_sales DESC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <style>
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Sales Report</h1>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Total Sales</th>
                <th>Total Revenue</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["product_name"] . "</td>";
                    echo "<td>" . $row["total_sales"] . "</td>";
                    echo "<td>" . $row["total_revenue"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No data available</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <footer style="text-align: center; margin-top: 20px;">
        <p>&copy; 2025 StyleVerse. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
