
<?php
include './../db_connection.php';

function getPaymentList($conn) {
    $sql = "SELECT * FROM Payment";
    $result = $conn->query($sql);
    $payments = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $payments[] = $row;
        }
    }
    return $payments;
}
$payments = getPaymentList($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Payment</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-yellow-50 to-yellow-200 flex flex-col justify-between">
   <header class="bg-white/80 shadow-lg sticky top-0 z-10">
    <?php include 'header.php'; ?>
  </header>
  <main class="flex-1 flex flex-col items-center justify-center py-10">
    <div class="container mx-auto bg-white/90 rounded-xl shadow-lg p-8">
    <h2 class="text-3xl font-bold text-yellow-700 mb-6 text-center drop-shadow">Payment List</h2>
    <div class="overflow-x-auto rounded-lg">
      <table class="min-w-full text-sm text-left text-yellow-900">
        <thead class="bg-yellow-200 text-yellow-800 uppercase text-xs">
          <tr>
            <th class="px-6 py-3 border">Payment ID</th>
            <th class="px-6 py-3 border">Order ID</th>
            <th class="px-6 py-3 border">Payment Date</th>
            <th class="px-6 py-3 border">Payment Status</th>
            <th class="px-6 py-3 border">Actions</th>
            <th class="px-6 py-3 border">Receipt</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-yellow-100">
          <?php foreach ($payments as $payment): ?>
            <tr>
              <td class="px-6 py-4 border"><?= htmlspecialchars($payment['Payment_ID']) ?></td>
              <td class="px-6 py-4 border"><?= htmlspecialchars($payment['Order_ID']) ?></td>
              <td class="px-6 py-4 border"><?= htmlspecialchars($payment['payment_date']) ?></td>
              <td class="px-6 py-4 border"><?= htmlspecialchars($payment['Payment_Status']) ?></td>
              <td class="px-6 py-4 border flex gap-4">
                <a href="edit_payment.php?id=<?= $payment['Payment_ID'] ?>" class="text-yellow-600 hover:underline">Edit</a>
                <form method="POST" action="delete_payment.php" class="inline">
                  <input type="hidden" name="id" value="<?= $payment['Payment_ID'] ?>" />
                  <button type="submit" class="text-red-600 hover:underline">Delete</button>
                </form>
              </td>
              <td class="px-6 py-4 border">
                <a href="generate_receipt.php?id=<?= $payment['Payment_ID'] ?>" class="text-blue-600 hover:underline">PDF</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div class="flex justify-center mt-8">
      <a href="../index.php" class="inline-block px-6 py-3 rounded-lg bg-yellow-400 text-white font-semibold shadow hover:bg-yellow-500 transition">Back to Home</a>
    </div>
  </div>
  </main>
  <footer class="bg-yellow-100 text-yellow-800 py-6 mt-auto shadow-inner">
    <?php include './../footer.php'; ?>
  </footer>
</body>
</html>
