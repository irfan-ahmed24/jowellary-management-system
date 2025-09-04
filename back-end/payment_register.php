<?php
include './../db_connection.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['Order_ID'];
    $payment_date = $_POST['Payment_Date'];
    $payment_status = $_POST['payment_status'];

    if ($order_id && $payment_date) {
        $stmt = $conn->prepare("INSERT INTO Payment (Order_ID, Payment_Date, Payment_Status) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $order_id, $payment_date, $payment_status);
        if ($stmt->execute()) {
            $message = "Payment registered successfully!";
            header("location: ./../front-end/payment.php");
            exit();
        } else {
            $message = "Error: Could not register payment.";
        }
        $stmt->close();
    } else {
        $message = "Please fill in all fields.";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register Payment - Sunmoon Gold Store</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-yellow-50 to-yellow-200 flex flex-col justify-between">
   <header class="bg-white/80 shadow-lg sticky top-0 z-10">
    <?php include 'header.php'; ?>
  </header>
  <main class="flex-1 flex flex-col items-center justify-center py-10">
    <div class="container mx-auto w-1/3 bg-white/90 rounded-xl shadow-lg p-8">
    <h2 class="text-3xl font-bold text-yellow-700 mb-6 text-center drop-shadow">Register Payment</h2>
    <?php if($message): ?>
      <div class="mb-4 text-center <?= strpos($message, 'Error') === false ? 'text-green-600' : 'text-red-600' ?> font-semibold">
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>
    <form method="POST" action="" class="flex flex-col gap-4">
     
      <input type="text" name="Order_ID" placeholder="Order ID" required class="rounded-md border border-yellow-200 px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none" />
      <select name="payment_status" id="payment_status" class="rounded-md border border-yellow-200 px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none">
        <option value="completed" selected>Yes</option>
        <option value="pending">No</option>
      </select>
      <input type="date" name="Payment_Date" placeholder="Payment Date" required class="rounded-md border border-yellow-200 px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none" />
      <button type="submit" class="w-full bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-2 rounded-md transition">Submit</button>
    </form>
    <div class="flex justify-center mt-8">
        <a href="../index.php" class="inline-block px-6 py-3 rounded-lg bg-yellow-400 text-white font-semibold shadow hover:bg-yellow-500 transition">Back to Home</a>
    </div>
  </div>
  </main>
  <footer class="bg-yellow-100 text-yellow-800 py-6 mt-auto shadow-inner">
    <?php include './../footer.php'; ?>
  </footer>
</body>
