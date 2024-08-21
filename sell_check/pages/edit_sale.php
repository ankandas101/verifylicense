<?php include '../includes/db_connect.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Sale</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container">
    <h1 class="my-4">Edit Sale</h1>

    <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM sales WHERE id=$id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
    }
    ?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF'].'?id='.$id;?>">
        <div class="mb-3">
            <label for="payment_date" class="form-label">Payment Date</label>
            <input type="date" class="form-control" name="payment_date" value="<?php echo $row['payment_date']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="license_duration" class="form-label">License Duration</label>
            <select class="form-select" name="license_duration" required>
                <option value="1_month" <?php if($row['license_duration'] == '1_month') echo 'selected'; ?>>1 Month</option>
                <option value="1_year" <?php if($row['license_duration'] == '1_year') echo 'selected'; ?>>1 Year</option>
                <option value="2_years" <?php if($row['license_duration'] == '2_years') echo 'selected'; ?>>2 Years</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Sale</button>
    </form>
    <a href="../index.php" class="btn btn-secondary mb-4">Home</a>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $payment_date = $_POST['payment_date'];
        $license_duration = $_POST['license_duration'];

        // Calculate the license expiry date based on the selected duration
        switch ($license_duration) {
            case '1_month':
                $license_expiry_date = date('Y-m-d', strtotime($payment_date . ' + 1 month'));
                break;
            case '1_year':
                $license_expiry_date = date('Y-m-d', strtotime($payment_date . ' + 1 year'));
                break;
            case '2_years':
                $license_expiry_date = date('Y-m-d', strtotime($payment_date . ' + 2 years'));
                break;
        }

        $sql = "UPDATE sales SET payment_date='$payment_date', license_duration='$license_duration', license_expiry_date='$license_expiry_date' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success mt-3'>Record updated successfully</div>";
        } else {
            echo "<div class='alert alert-danger mt-3'>Error updating record: " . $conn->error . "</div>";
        }
    }
    ?>
</body
