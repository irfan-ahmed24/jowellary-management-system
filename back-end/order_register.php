<?php
include './../db_connection.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['Customer_ID'] ?? '';
    $employee_id = $_POST['employee_id'] ?? '';
    $item_id = $_POST['Item_ID'] ?? '';
    $quantity = $_POST['Quantity'] ?? '';
    $total_amount = $_POST['Total_Amount'] ?? '';
    $date = $_POST['Date'] ?? '';
    if( $customer_id && $employee_id && $item_id && $quantity && $total_amount && $date) {
        $stmt = mysqli_query($conn, "INSERT INTO `order` ( Customer_ID, employee_id, Item_id, Quantity, Total_Amount, Order_Date) VALUES ('$customer_id', '$employee_id', '$item_id', '$quantity', '$total_amount', '$date')");
        if ($stmt) {
            $message = "Order registered successfully!";
            header("Location: ./../front-end/order.php");
        } else {
            $message = "item or customer does not exist.";
        }
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
  <title>Register Order - Sunmoon Gold Store</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-yellow-50 to-yellow-200 flex flex-col justify-between">
   <header class="bg-white/80 shadow-lg sticky top-0 z-10">
    <?php include 'header.php'; ?>
  </header>
  <main class="flex-1 flex flex-col items-center justify-center py-10">
    <div class="container mx-auto w-1/3 bg-white/90 rounded-xl shadow-lg p-8">
    <h2 class="text-3xl font-bold text-yellow-700 mb-6 text-center drop-shadow">Register Order</h2>
    <?php if($message): ?>
      <div class="mb-4 text-center <?= strpos($message, 'Error') === false ? 'text-green-600' : 'text-red-600' ?> font-semibold">
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>
    <form method="POST" action="" class="flex flex-col gap-4">
      <input type="text" name="Customer_ID" placeholder="Customer ID" required class="rounded-md border border-yellow-200 px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none" />
      <input type="text" name="employee_id" placeholder="employee ID" required class="rounded-md border border-yellow-200 px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none" />
      <input type="text" name="Item_ID" placeholder="Item ID" required class="rounded-md border border-yellow-200 px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none" />
      <input type="number" name="Quantity" placeholder="Quantity" min="1" required class="rounded-md border border-yellow-200 px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none" />
      <input type="number" name="Total_Amount" placeholder="Total Amount" min="0" step="0.01" required class="rounded-md border border-yellow-200 px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none" />
      <input type="date" name="Date" placeholder="Date" required class="rounded-md border border-yellow-200 px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none" />
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
</html>
