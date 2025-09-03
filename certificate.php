<?php
include 'db_connection.php';

$sql = "SELECT Certificate_ID, Item_ID, Certified_By, Issue_Date FROM Authenticity_Certificate";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Authenticity Certificate</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
</head>
<body class="container mt-5">
<h2>Authenticity Certificate</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Certificate_ID</th>
            <th>Item_ID</th>
            <th>Certified_By</th>
            <th>Issue_Date</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row["Certificate_ID"]) ?></td>
                    <td><?= htmlspecialchars($row["Item_ID"]) ?></td>
                    <td><?= htmlspecialchars($row["Certified_By"]) ?></td>
                    <td><?= htmlspecialchars($row["Issue_Date"]) ?></td>
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
