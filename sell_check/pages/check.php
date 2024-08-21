<?php
$servername = "localhost";
$username = "root";  // Change if different
$password = "";  // Change if you have a password
$dbname = "license_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Sales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container">
    <h1 class="my-4">Sales Details</h1>

    <?php
    $sql = "SELECT * FROM sales where invoices_no = 'pos01' ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table class='table table-bordered'><thead><tr><th>Customer Name</th><th>Product ID</th><th>invoices_no</th><th>Last Payment Date</th><th>License Duration</th><th>License Expiry Date</th><th>Remaining Days</th></tr></thead><tbody>";
        while($row = $result->fetch_assoc()) {
            // Calculate remaining days
            $current_date = new DateTime();
            $expiry_date = new DateTime($row['license_expiry_date']);
            $remaining_days = $current_date->diff($expiry_date)->format("%r%a");

            // Determine if expired or not and apply appropriate styling
            if ($remaining_days >= 0) {
                $remaining_days_display = $remaining_days . " days";
                $row_class = "text-success"; // no special styling for active licenses
            } else {
                $remaining_days_display = "Expired";
                $row_class = "text-danger"; // red color for expired licenses
            }

            echo "<tr>
                    <td>".$row["customer_name"]."</td>
                    <td>".$row["product_id"]."</td>
                    <td>".$row["invoices_no"]."</td>
                    <td>".$row["payment_date"]."</td>
                    <td>".$row["license_duration"]."</td>
                    <td>".$row["license_expiry_date"]."</td>
                    <td class='$row_class'>".$remaining_days_display."</td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<div class='alert alert-info'>No sales records found.</div>";
    }
    ?>
    <a href="../index.php" class="btn btn-primary mt-4">Back to Dashboard</a>
</body>
</html>