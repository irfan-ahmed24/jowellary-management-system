<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-20">
      <div class="flex items-center gap-3">
        <div class="bg-yellow-400 rounded-full w-12 h-12 flex items-center justify-center text-2xl font-bold text-white shadow">JMS</div>
        <span class="text-xl sm:text-2xl font-semibold text-yellow-700 tracking-wide">Jewellery Shop Management System</span>
      </div>
      <nav class="flex items-center gap-6">
        <!-- Register Dropdown -->
        <div class="relative group">
          <button type="button" class="px-4 py-2 rounded-md bg-yellow-100 text-yellow-800 font-medium hover:bg-yellow-200 transition flex items-center gap-1">Register
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
          </button>
          <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 pointer-events-none transition z-20">
            <a href="./../index.php" class="block px-4 py-2 hover:bg-gray-200">Home</a>
            <a href="./../back-end/employee_regi.php" class="block px-4 py-2 hover:bg-gray-200">Employee</a>
            <a href="./../back-end/customer_register.php" class="block px-4 py-2 hover:bg-gray-200">Customer</a>

            <a href="./../back-end/jewellery_register.php" class="block px-4 py-2 hover:bg-gray-200">Jewellery Item</a>
            <a href="./../back-end/order_register.php" class="block px-4 py-2 hover:bg-gray-200">Order</a>
            <a href="./../back-end/payment_register.php" class="block px-4 py-2 hover:bg-gray-200">Payment</a>
          </div>
        </div>
        <!-- View Dropdown -->
        <div class="relative group">
          <button type="button" class="px-4 py-2 rounded-md bg-yellow-100 text-yellow-800 font-medium hover:bg-yellow-200 transition flex items-center gap-1">View
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
          </button>
          <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 pointer-events-none  z-20">
            <a href="./../index.php" class="block px-4 py-2 hover:bg-gray-200">Home</a>
            <a href="./../front-end/employee.php" class="block px-4 py-2 hover:bg-gray-200">Employee</a>
            <a href="./../front-end/customer.php" class="block px-4 py-2 hover:bg-gray-200">Customer</a>
            <a href="./../front-end/jewellery.php" class="block px-4 py-2 hover:bg-gray-200">Item</a>
            <a href="./../front-end/order.php" class="block px-4 py-2 hover:bg-gray-200">Order</a>
            <a href="./../front-end/payment.php" class="block px-4 py-2 hover:bg-gray-200">Payment</a>
          </div>
        </div>
        <!-- Search Button -->
        <a href="search.php" class="ml-2 px-4 py-2 rounded-md bg-yellow-400 text-white font-semibold shadow hover:bg-yellow-500 transition">Search</a>
      </nav>
    </div>
     <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.group').forEach(function (group) {
                const button = group.querySelector('button');
                const dropdown = group.querySelector('div.absolute');
                if (button && dropdown) {
                    button.addEventListener('click', function (e) {
                        e.stopPropagation();
                        dropdown.classList.toggle('opacity-100');
                        dropdown.classList.toggle('pointer-events-auto');
                    });
                    document.addEventListener('click', function () {
                        dropdown.classList.remove('opacity-100');
                        dropdown.classList.remove('pointer-events-auto');
                    });
                }
            });
        });
    </script>
</body>
</html>