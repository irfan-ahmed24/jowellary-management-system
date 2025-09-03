<?php
include 'db_connection.php';

$sql = "SELECT Order_ID, Customer_ID, Order_Date, Total_Amount FROM `Order`";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
</head>
<body class="container mt-5">
<h2>Order</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Order_ID</th>
            <th>Customer_ID</th>
            <th>Order_Date</th>
            <th>Total_Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row["Order_ID"]) ?></td>
                    <td><?= htmlspecialchars($row["Customer_ID"]) ?></td>
                    <td><?= htmlspecialchars($row["Order_Date"]) ?></td>
                    <td><?= htmlspecialchars($row["Total_Amount"]) ?></td>
                </tr>
            <?php }
        } else { ?>
            <tr><td colspan="4">No records found</td></tr>
        <?php } ?>
    </tbody>
</table>
<a href="Homepage.html" class="btn btn-primary">Back to Home</a>
</body>
</html>

<?php $conn->close(); ?>
