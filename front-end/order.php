<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Order</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-yellow-50 to-yellow-200 flex flex-col justify-between">
  <!-- Navbar -->
  <header class="bg-white/80 shadow-lg sticky top-0 z-10">
    <?php include 'header.php'; ?>
  </header>
  <main class="flex-1 flex flex-col items-center justify-center py-10">
    <div class="container mx-auto bg-white/90 rounded-xl shadow-lg p-8">
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
          <!-- Empty for now -->
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
