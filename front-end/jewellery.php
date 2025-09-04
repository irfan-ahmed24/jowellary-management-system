<?php
include './../db_connection.php';

// View all jewellery items
function getAllJewelleryItems($conn) {
    $sql = "SELECT * FROM Jewellery_Item";
    $result = $conn->query($sql);
    $jewellery_items = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $jewellery_items[] = $row;
        }
    }
    return $jewellery_items;
}
// Update jewellery item
$update_message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['Item_ID'];
    $type = $_POST['Type'];
    $name = $_POST['Item_name'];
    $weight = $_POST['Weight'];
    $price = $_POST['Price'];

    if ($id && $type && $name && $weight && $price) {
        $stmt = $conn->prepare("UPDATE Jewellery_Item SET Type=?, Item_name=?, Weight=?, Price=? WHERE Item_ID=?");
        $stmt->bind_param("sssss", $type, $name, $weight, $price, $id);
        if ($stmt->execute()) {
            $update_message = "Jewellery item updated successfully!";
            header("Location: ./jewellery.php");
            exit();
        } else {
            $update_message = "Error: Could not update jewellery item.";
        }
        $stmt->close();
    } else {
        $update_message = "Please fill in all fields.";
    }
}

$jewellery_items = getAllJewelleryItems($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Jewellery Item</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-yellow-50 to-yellow-200 flex flex-col justify-between">
  <!-- Navbar -->
  <header class="bg-white/80 shadow-lg sticky top-0 z-10">
    <?php include 'header.php'; ?>
  </header>
<main class="flex-1 flex flex-col items-center justify-center py-10">
    <div class="container mx-auto bg-white/90 rounded-xl shadow-lg p-8">
      <h2 class="text-3xl font-bold text-yellow-700 mb-6 text-center drop-shadow">All Items</h2>
       <!-- Update Jewellery Item -->
      <?php if(isset($_GET['edit'])): 
          $edit_id = $conn->real_escape_string($_GET['edit']);
          $stmt = $conn->prepare("SELECT * FROM Jewellery_Item WHERE Item_ID=?");
          $stmt->bind_param("s", $edit_id);
          $stmt->execute();
          $result = $stmt->get_result();
          $edit_item = $result->num_rows > 0 ? $result->fetch_assoc() : null;
          $stmt->close();
      ?>
        <form class="max-w-md mx-auto mb-6 bg-yellow-50 rounded-lg shadow p-6 flex flex-col gap-4" method="POST" action="">
          <label for="Item_ID">Item ID</label>
          <input type="text" name="Item_ID" value="<?= $edit_item ? htmlspecialchars($edit_item['Item_ID']) : '' ?>" readonly class="rounded-md border border-yellow-200 px-4 py-2 bg-gray-100" />

          <label for="Type">Type</label>
          <input type="text" name="Type" value="<?= $edit_item ? htmlspecialchars($edit_item['Type']) : '' ?>" required class="rounded-md border border-yellow-200 px-4 py-2" />

          <label for="Item_name">Name</label>
          <input type="text" name="Item_name" value="<?= $edit_item ? htmlspecialchars($edit_item['Item_name']) : '' ?>" required class="rounded-md border border-yellow-200 px-4 py-2" />

          <label for="Weight">Weight</label>
          <input type="text" name="Weight" value="<?= $edit_item ? htmlspecialchars($edit_item['Weight']) : '' ?>" required class="rounded-md border border-yellow-200 px-4 py-2" />

          <label for="Price">Price</label>
          <input type="text" name="Price" value="<?= $edit_item ? htmlspecialchars($edit_item['Price']) : '' ?>" required class="rounded-md border border-yellow-200 px-4 py-2" />
          <button type="submit" name="update" class="w-full bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-2 rounded-md transition">Update</button>
        </form>
      <?php endif; ?>
      <div class="overflow-x-auto rounded-lg">
        <table class="min-w-full text-sm text-left text-yellow-900">
          <thead class="bg-yellow-200 text-yellow-800 uppercase text-xs">
            <tr>
              <th class="px-6 py-3">Item ID</th>
              <th class="px-6 py-3">Type</th>
              <th class="px-6 py-3">Name</th>
              <th class="px-6 py-3">Weight</th> 
              <th class="px-6 py-3">Price</th>
              <th class="px-6 py-3">Action</th>
            </tr>
          </thead>
               <tbody class="bg-white divide-y divide-yellow-100">
            <?php foreach($jewellery_items as $item): ?>
                  <tr>
                    <td class="px-6 py-2 border"><?= htmlspecialchars($item["Item_ID"]) ?></td>
                    <td class="px-6 py-2 border"><?= htmlspecialchars($item["Type"]) ?></td>
                    <td class="px-6 py-2 border"><?= htmlspecialchars($item["Item_name"]) ?></td>
                    <td class="px-6 py-2 border"><?= htmlspecialchars($item["Weight"]) ?></td>
                    <td class="px-6 py-2 border"><?= htmlspecialchars($item["Price"]) ?></td>
                    <td class="px-6 py-2 border">
                      <a href="?edit=<?= htmlspecialchars($item['Item_ID']) ?>" class="text-yellow-700 hover:underline mr-3">Edit</a>
                    </td>
                  </tr>
              <?php endforeach; ?>
              <?php if (empty($jewellery_items)): ?>
                <tr><td colspan="5" class="px-6 py-2 text-center">No records found</td></tr>
              <?php endif; ?>
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
