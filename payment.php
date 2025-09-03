<?php
include 'db_connection.php';

$sql = "SELECT Payment_ID, Order_ID, Payment_Mode, Payment_Status FROM Payment";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
</head>
<body class="container mt-5">
<h2>Payment</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Payment_ID</th>
            <th>Order_ID</th>
            <th>Payment_Mode</th>
            <th>Payment_Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row["Payment_ID"]) ?></td>
                    <td><?= htmlspecialchars($row["Order_ID"]) ?></td>
                    <td><?= htmlspecialchars($row["Payment_Mode"]) ?></td>
                    <td><?= htmlspecialchars($row["Payment_Status"]) ?></td>
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
