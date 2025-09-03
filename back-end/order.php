<?php
include 'db_connection.php';

$sql = "SELECT Order_ID, Customer_ID, Order_Date, Total_Amount FROM `Order`";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Order</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-yellow-50 to-yellow-200 flex flex-col justify-between">
    <main class="flex-1 flex flex-col items-center justify-center py-10">
        <div class="w-full max-w-4xl bg-white/90 rounded-xl shadow-lg p-8">
            <h2 class="text-3xl font-bold text-yellow-700 mb-6 text-center drop-shadow">Order List</h2>
            <div class="overflow-x-auto rounded-lg">
                <table class="min-w-full text-sm text-left text-yellow-900">
                    <thead class="bg-yellow-200 text-yellow-800 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">Order ID</th>
                            <th class="px-6 py-3">Customer ID</th>
                            <th class="px-6 py-3">Order Date</th>
                            <th class="px-6 py-3">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-yellow-100">
                        <?php if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td class="px-6 py-2"><?= htmlspecialchars($row["Order_ID"]) ?></td>
                                        <td class="px-6 py-2"><?= htmlspecialchars($row["Customer_ID"]) ?></td>
                                        <td class="px-6 py-2"><?= htmlspecialchars($row["Order_Date"]) ?></td>
                                        <td class="px-6 py-2"><?= htmlspecialchars($row["Total_Amount"]) ?></td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr><td colspan="4" class="px-6 py-2 text-center">No records found</td></tr>
                            <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="flex justify-center mt-8">
                <a href="../Homepage.html" class="inline-block px-6 py-3 rounded-lg bg-yellow-400 text-white font-semibold shadow hover:bg-yellow-500 transition">Back to Home</a>
            </div>
        </div>
    </main>
</body>
</html>

<?php $conn->close(); ?>
