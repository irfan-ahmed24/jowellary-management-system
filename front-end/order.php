<?php include './../db_connection.php';
// View all orders
function getAllOrders($conn) {
    $sql = "SELECT * FROM `order`";
    $result = $conn->query($sql);
    $orders = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
    }
    return $orders;
}

// Update order
$update_message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $customer_id = $_POST['Customer_ID'];
    $order_id = $_POST['Order_ID'];
    $item_id = $_POST['Item_id'];
    $quantity = $_POST['Quantity'];
    $order_date = $_POST['Order_Date'];
    $total_amount = $_POST['Total_Amount'];

    if ($order_id && $customer_id && $item_id && $quantity && $order_date && $total_amount) {
        $stmt = $conn->prepare("UPDATE `order` SET Item_id=?, Customer_ID=?, Quantity=?, Order_Date=?, Total_Amount=? WHERE Order_ID=?");
        $stmt->bind_param("ssssss", $item_id, $customer_id, $quantity, $order_date, $total_amount, $order_id);
        if ($stmt->execute()) {
            $update_message = "Order updated successfully!";
            header("Location: ./order.php");
            exit();
        } else {
            $update_message = "Error: Could not update order.";
        }
        $stmt->close();
    } else {
        $update_message = "Please fill in all fields.";
    }
}
// Delete order
$delete_message = "";
if (isset($_GET['delete'])) {
    $id = $conn->real_escape_string($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM `order` WHERE Order_ID=?");
    $stmt->bind_param("s", $id);
    if ($stmt->execute()) {
        $delete_message = "Order deleted successfully!";
        header("Location: ./order.php");
        exit();
    } else {
        $delete_message = "Error: Could not delete order.";
    }
    $stmt->close();
}

$orders = getAllOrders($conn);
 ?>
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
       <?php if($update_message): ?>
      <div class="mb-4 text-center <?= strpos($update_message, 'Error') === false ? 'text-green-600' : 'text-red-600' ?> font-semibold">
        <?= htmlspecialchars($update_message) ?>
      </div>
    <?php endif; ?>
      <!-- Update order -->
      <?php if(isset($_GET['edit'])): 
          $edit_id = $conn->real_escape_string($_GET['edit']);
          $stmt = $conn->prepare("SELECT * FROM `order` WHERE Order_ID=?");
          $stmt->bind_param("s", $edit_id);
          $stmt->execute();
          $result = $stmt->get_result();
          $edit_order = $result->num_rows > 0 ? $result->fetch_assoc() : null;
          $stmt->close();
      ?>
        <form class="max-w-md mx-auto mb-6 bg-yellow-50 rounded-lg shadow p-6 flex flex-col gap-4" method="POST" action="">
          
          <label for="Order_ID">Order Id</label>
          <input type="text" name="Order_ID" value="<?= $edit_order ? htmlspecialchars($edit_order['Order_ID']) : '' ?>" readonly class="rounded-md border border-yellow-200 px-4 py-2 bg-gray-300"/>
          
          <label for="Customer_ID">Customer ID</label>
          <input type="text" name="Customer_ID" value="<?= $edit_order ? htmlspecialchars($edit_order['Customer_ID']) : '' ?>" required class="rounded-md border border-yellow-200 px-4 py-2" />
          <label for="Item_id">Item ID</label>
          <input type="text" name="Item_id" value="<?= $edit_order ? htmlspecialchars($edit_order['Item_id']) : '' ?>" required class="rounded-md border border-yellow-200 px-4 py-2" />
          <label for="Quantity">Quantity</label>
          <input type="tel" name="Quantity" value="<?= $edit_order ? htmlspecialchars($edit_order['Quantity']) : '' ?>" required class="rounded-md border border-yellow-200 px-4 py-2" />
          
          <label for="Order_Date">Order Date</label>
          <input type="date" name="Order_Date" value="<?= $edit_order ? htmlspecialchars($edit_order['Order_Date']) : '' ?>" required class="rounded-md border border-yellow-200 px-4 py-2" />
          
          <label for="Total_Amount">Total Amount</label>
          <input type="tel" name="Total_Amount" value="<?= $edit_order ? htmlspecialchars($edit_order['Total_Amount']) : '' ?>" required class="rounded-md border border-yellow-200 px-4 py-2" />
          <button type="submit" name="update" class="w-full bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-2 rounded-md transition">Update</button>
        </form>
      <?php endif; ?>
    <div class="overflow-x-auto rounded-lg">
      <table class="min-w-full text-sm text-left text-yellow-900">
        <thead class="bg-yellow-200 text-yellow-800 uppercase text-xs">
          <tr>
            <th class="px-6 py-3">Order ID</th>
            <th class="px-6 py-3">Customer ID</th>
            <th class="px-6 py-3">Item ID</th>
            <th class="px-6 py-3">Quantity</th>
            <th class="px-6 py-3">Order Date</th>
            <th class="px-6 py-3">Total Amount</th>
            <th class="px-6 py-3">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-yellow-100">
           <?php foreach($orders as $order): ?>
              <tr>
              <td class="px-6 border py-2"><?= htmlspecialchars($order['Order_ID']) ?></td>
              <td class="px-6 border py-2"><?= htmlspecialchars($order['Customer_ID']) ?></td>
              <td class="px-6 border py-2"><?= htmlspecialchars($order['Item_id']) ?></td>
              <td class="px-6 border py-2"><?= htmlspecialchars($order['Quantity']) ?></td>
              <td class="px-6 border py-2"><?= htmlspecialchars($order['Order_Date']) ?></td>
              <td class="px-6 border py-2"><?= htmlspecialchars($order['Total_Amount']) ?></td>
              <td class="px-6 py-2 border">
                <a href="?edit=<?= htmlspecialchars($order['Order_ID']) ?>" class="text-yellow-700 hover:underline mr-3">Edit</a>
                <a href="?delete=<?= htmlspecialchars($order['Order_ID']) ?>" onclick="return confirm('Are you sure you want to delete this order?')" class="text-red-600 hover:underline">Delete</a>
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
