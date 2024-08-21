<?php include '../includes/db_connect.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Sale</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container">
    <h1 class="my-4">Add New Sale</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <div class="mb-3">
            <label for="customer_id" class="form-label">Customer ID</label>
            <input type="text" class="form-control" name="customer_id" required>
        </div>
        <div class="mb-3">
            <label for="customer_name" class="form-label">Customer Name</label>
            <input type="text" class="form-control" name="customer_name" required>
        </div>
        <div class="mb-3">
            <label for="customer_phone" class="form-label">Customer Phone</label>
            <input type="text" class="form-control" name="customer_phone" required>
        </div>
        <div class="mb-3">
            <label for="customer_email" class="form-label">Customer Email</label>
            <input type="text" class="form-control" name="customer_email" required>
        </div>
        <div class="mb-3">
            <label for="product_id" class="form-label">Product ID</label>
            <input type="text" class="form-control" name="product_id" required>
        </div>
        <div class="mb-3">
            <label for="invoices_no" class="form-label">Invoices No</label>
            <input type="text" class="form-control" name="invoices_no" required>
        </div>
        <div class="mb-3">
            <label for="payment_date" class="form-label">Payment Date</label>
            <input type="date" class="form-control" name="payment_date" required>
        </div>
        <div class="mb-3">
            <label for="license_duration" class="form-label">License Duration</label>
            <select class="form-select" name="license_duration" required>
                <option value="1_month">1 Month</option>
                <option value="6_month">6 Month</option>
                <option value="1_year">1 Year</option>
                <option value="2_years">2 Years</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add Sale</button>
    </form>
    <a href="../index.php" class="btn btn-secondary mb-4">Home</a>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $customer_id = $_POST['customer_id'];
        $customer_name = $_POST['customer_name'];
        $customer_phone = $_POST['customer_phone'];
        $customer_email = $_POST['customer_email'];
        $product_id = $_POST['product_id'];
        $invoices_no = $_POST['invoices_no'];
        $payment_date = $_POST['payment_date'];
        $license_duration = $_POST['license_duration'];

        // Calculate the license expiry date based on the selected duration
        switch ($license_duration) {
            case '1_month':
                $license_expiry_date = date('Y-m-d', strtotime($payment_date . ' + 1 month'));
                break;
            case '6_month':
                $license_expiry_date = date('Y-m-d', strtotime($payment_date . ' + 6 month'));
                break;
            case '1_year':
                $license_expiry_date = date('Y-m-d', strtotime($payment_date . ' + 1 year'));
                break;
            case '2_years':
                $license_expiry_date = date('Y-m-d', strtotime($payment_date . ' + 2 years'));
                break;
        }

        $sql = "INSERT INTO sales (customer_id, customer_name,customer_phone,customer_email, product_id, invoices_no, payment_date, license_duration, license_expiry_date) 
                VALUES ('$customer_id', '$customer_name','$customer_phone','$customer_email', '$product_id', '$invoices_no', '$payment_date', '$license_duration', '$license_expiry_date')";

        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success mt-3'>New record created successfully</div>";
        } else {
            echo "<div class='alert alert-danger mt-3'>Error: " . $sql . "<br>" . $conn->error . "</div>";
        }
    }
    ?>
</body>
</html>
