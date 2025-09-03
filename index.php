
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Jewellery Shop Management System - Home</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-yellow-50 to-yellow-200 min-h-screen flex flex-col">
  <!-- Navbar -->
  <header class="bg-white/80 shadow-lg sticky top-0 z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-20">
      <div class="flex items-center gap-3">
        <div class="bg-yellow-400 rounded-full w-12 h-12 flex items-center justify-center text-2xl font-bold text-white shadow">JMS</div>
        <span class="text-xl sm:text-2xl font-semibold text-yellow-700 tracking-wide">Jewellery Shop Management System</span>
      </div>
      <nav class="flex items-center gap-6">
        <!-- Register Dropdown -->
        <div class="relative group">
          <button class="px-4 py-2 rounded-md bg-yellow-100 text-yellow-800 font-medium hover:bg-yellow-200 transition flex items-center gap-1">Register <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg></button>
          <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 group-hover:opacity-100 pointer-events-none group-hover:pointer-events-auto transition z-20">
            <a href="customer_register.php" class="block px-4 py-2 hover:bg-yellow-50">Customer</a>
            <a href="jewellery_register.php" class="block px-4 py-2 hover:bg-yellow-50">Jewellery Item</a>
            <a href="order_register.php" class="block px-4 py-2 hover:bg-yellow-50">Order</a>
            <a href="payment_register.php" class="block px-4 py-2 hover:bg-yellow-50">Payment</a>
            <a href="certificate_register.php" class="block px-4 py-2 hover:bg-yellow-50">Authenticity Certificate</a>
          </div>
        </div>
        <!-- View Dropdown -->
        <div class="relative group">
          <button class="px-4 py-2 rounded-md bg-yellow-100 text-yellow-800 font-medium hover:bg-yellow-200 transition flex items-center gap-1">View <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg></button>
          <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 group-hover:opacity-100 pointer-events-none group-hover:pointer-events-auto transition z-20">
            <a href="cust.php" class="block px-4 py-2 hover:bg-yellow-50">Customer</a>
            <a href="jewellery.php" class="block px-4 py-2 hover:bg-yellow-50">Jewellery Item</a>
            <a href="order.html" class="block px-4 py-2 hover:bg-yellow-50">Order</a>
            <a href="payment.html" class="block px-4 py-2 hover:bg-yellow-50">Payment</a>
            <a href="certificate.html" class="block px-4 py-2 hover:bg-yellow-50">Authenticity Certificate</a>
          </div>
        </div>
        <!-- Search Button -->
        <a href="search.php" class="ml-2 px-4 py-2 rounded-md bg-yellow-400 text-white font-semibold shadow hover:bg-yellow-500 transition">Search</a>
      </nav>
    </div>
  </header>

  <!-- Hero Section -->
  <main class="flex-1 flex flex-col items-center justify-center text-center py-16 px-4">
    <div class="max-w-2xl mx-auto">
      <h1 class="text-4xl sm:text-5xl font-extrabold text-yellow-700 mb-4 drop-shadow">Welcome to <span class="text-yellow-500">Jewellery Shop Management System</span></h1>
      <p class="text-lg sm:text-xl text-yellow-900 mb-8">Manage Customers, Jewellery Items, Orders, Payments, and Authenticity Certificates in one clean and elegant system.</p>
      <div class="flex flex-wrap justify-center gap-4 mt-6">
        <a href="customer_register.php" class="px-6 py-3 rounded-lg bg-yellow-400 text-white font-bold shadow hover:bg-yellow-500 transition">Register Customer</a>
        <a href="jewellery_register.php" class="px-6 py-3 rounded-lg bg-yellow-300 text-yellow-900 font-bold shadow hover:bg-yellow-400 transition">Register Jewellery</a>
        <a href="order_register.php" class="px-6 py-3 rounded-lg bg-yellow-200 text-yellow-900 font-bold shadow hover:bg-yellow-300 transition">Register Order</a>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-yellow-100 text-yellow-800 py-6 mt-auto shadow-inner">
    <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row justify-between items-center gap-2">
      <div>© Jewellery Shop Management System — All rights reserved.</div>
      <div>Designed by Sadia Jannat Moon — ID: 23303060</div>
    </div>
  </footer>
</body>
</html>
