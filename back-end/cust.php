<?php
include 'db_connection.php'; // Make sure this file connects to your database

// View all customers
function getAllCustomers($conn) {
    $sql = "SELECT * FROM Customer";
    $result = $conn->query($sql);
    $customers = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $customers[] = $row;
        }
    }
    return $customers;
}

// Search customers
$search_message = "";
$search_results = [];
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = $conn->real_escape_string($_GET['search']);
    $sql = "SELECT * FROM Customer WHERE Customer_ID LIKE '%$search_term%' OR Name LIKE '%$search_term%' OR Contact LIKE '%$search_term%'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $search_results[] = $row;
        }
    } else {
        $search_message = "No customers found.";
    }
}

// Update customer
$update_message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['Customer_ID'];
    $name = $_POST['Name'];
    $contact = $_POST['Contact'];
    
    if ($id && $name && $contact) {
        $stmt = $conn->prepare("UPDATE Customer SET Name=?, Contact=? WHERE Customer_ID=?");
        $stmt->bind_param("sss", $name, $contact, $id);
        if ($stmt->execute()) {
            $update_message = "Customer updated successfully!";
            header("Location: ./cust.php");
        } else {
            $update_message = "Error: Could not update customer.";
        }
        $stmt->close();
    } else {
        $update_message = "Please fill in all fields.";
    }
}

// Delete customer
$delete_message = "";
if (isset($_GET['delete'])) {
    $id = $conn->real_escape_string($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM Customer WHERE Customer_ID=?");
    $stmt->bind_param("s", $id);
    if ($stmt->execute()) {
        $delete_message = "Customer deleted successfully!";
    } else {
        $delete_message = "Error: Could not delete customer.";
    }
    $stmt->close();
}

$customers = getAllCustomers($conn);
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Customer Management - Sunmoon Gold Store</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-yellow-50 to-yellow-200 flex flex-col justify-between">
  <div class="flex-1 flex flex-col items-center justify-center py-10">
    <div class="w-full max-w-4xl bg-white/90 rounded-xl shadow-lg p-8">
      <h2 class="text-3xl font-bold text-yellow-700 mb-6 text-center drop-shadow">Customer Management</h2>
      <!-- Search Form -->
      <form class="max-w-md mx-auto mb-6 bg-yellow-50 rounded-lg shadow p-6 flex flex-col gap-4" method="GET" action="">
        <input type="text" name="search" placeholder="Search by ID, Name, or Contact" class="rounded-md border border-yellow-200 px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none" />
        <button type="submit" class="w-full bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-2 rounded-md transition">Search</button>
      </form>
      <!-- Search Results -->
      <?php if($search_message): ?>
        <div class="max-w-md mx-auto mb-4 text-center text-red-600 font-semibold"><?= htmlspecialchars($search_message) ?></div>
      <?php endif; ?>
      <?php if(!empty($search_results)): ?>
        <div class="overflow-x-auto rounded-lg mb-8">
          <table class="min-w-full text-sm text-left text-yellow-900">
            <thead class="bg-yellow-200 text-yellow-800 uppercase text-xs">
              <tr>
                <th class="px-6 py-3">Customer ID</th>
                <th class="px-6 py-3">Name</th>
                <th class="px-6 py-3">Contact</th>
                <th class="px-6 py-3">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-yellow-100">
              <?php foreach($search_results as $customer): ?>
                <tr>
                  <td class="px-6 py-2"><?= htmlspecialchars($customer['Customer_ID']) ?></td>
                  <td class="px-6 py-2"><?= htmlspecialchars($customer['Name']) ?></td>
                  <td class="px-6 py-2"><?= htmlspecialchars($customer['Contact']) ?></td>
                  <td class="px-6 py-2 whitespace-nowrap">
                    <a href="?edit=<?= htmlspecialchars($customer['Customer_ID']) ?>" class="text-yellow-700 hover:underline mr-3">Edit</a>
                    <a href="?delete=<?= htmlspecialchars($customer['Customer_ID']) ?>" onclick="return confirm('Are you sure you want to delete this customer?')" class="text-red-600 hover:underline">Delete</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
      <!-- Update Form -->
      <?php if(isset($_GET['edit'])): 
          $edit_id = $conn->real_escape_string($_GET['edit']);
          $stmt = $conn->prepare("SELECT * FROM Customer WHERE Customer_ID=?");
          $stmt->bind_param("s", $edit_id);
          $stmt->execute();
          $result = $stmt->get_result();
          $edit_customer = $result->num_rows > 0 ? $result->fetch_assoc() : null;
          $stmt->close();
      ?>
        <form class="max-w-md mx-auto mb-6 bg-yellow-50 rounded-lg shadow p-6 flex flex-col gap-4" method="POST" action="">
          <input type="text" name="Customer_ID" value="<?= $edit_customer ? htmlspecialchars($edit_customer['Customer_ID']) : '' ?>" readonly class="rounded-md border border-yellow-200 px-4 py-2 bg-gray-100" />
          <input type="text" name="Name" value="<?= $edit_customer ? htmlspecialchars($edit_customer['Name']) : '' ?>" required class="rounded-md border border-yellow-200 px-4 py-2" />
          <input type="tel" name="Contact" value="<?= $edit_customer ? htmlspecialchars($edit_customer['Contact']) : '' ?>" required class="rounded-md border border-yellow-200 px-4 py-2" />
          <button type="submit" name="update" class="w-full bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-2 rounded-md transition">Update</button>
        </form>
      <?php endif; ?>
      <!-- Messages -->
      <?php if($update_message): ?>
        <div class="max-w-md mx-auto mb-4 text-center <?= strpos($update_message, 'Error') === false ? 'text-green-600' : 'text-red-600' ?> font-semibold">
          <?= htmlspecialchars($update_message) ?>
        </div>
      <?php endif; ?>
      <?php if($delete_message): ?>
        <div class="max-w-md mx-auto mb-4 text-center <?= strpos($delete_message, 'Error') === false ? 'text-green-600' : 'text-red-600' ?> font-semibold">
          <?= htmlspecialchars($delete_message) ?>
        </div>
      <?php endif; ?>
      <!-- All Customers Table -->
      <div class="overflow-x-auto rounded-lg">
        <h3 class="text-xl font-semibold text-yellow-700 mb-4">All Customers</h3>
        <table class="min-w-full text-sm text-left text-yellow-900">
          <thead class="bg-yellow-200 text-yellow-800 uppercase text-xs">
            <tr>
              <th class="px-6 py-3">Customer ID</th>
              <th class="px-6 py-3">Name</th>
              <th class="px-6 py-3">Contact</th>
              <th class="px-6 py-3">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-yellow-100">
            <?php foreach($customers as $customer): ?>
              <tr>
                <td class="px-6 py-2"><?= htmlspecialchars($customer['Customer_ID']) ?></td>
                <td class="px-6 py-2"><?= htmlspecialchars($customer['Name']) ?></td>
                <td class="px-6 py-2"><?= htmlspecialchars($customer['Contact']) ?></td>
                <td class="px-6 py-2 whitespace-nowrap">
                  <a href="?edit=<?= htmlspecialchars($customer['Customer_ID']) ?>" class="text-yellow-700 hover:underline mr-3">Edit</a>
                  <a href="?delete=<?= htmlspecialchars($customer['Customer_ID']) ?>" onclick="return confirm('Are you sure you want to delete this customer?')" class="text-red-600 hover:underline">Delete</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="flex justify-center mt-8">
        <a href="../Homepage.html" class="inline-block px-6 py-3 rounded-lg bg-yellow-400 text-white font-semibold shadow hover:bg-yellow-500 transition">Back to Home</a>
      </div>
    </div>
  </div>
 <footer class="bg-yellow-100 text-yellow-800 py-6 mt-auto shadow-inner">
    <?php include './../footer.php'; ?>
  </footer>
</body>
</html>