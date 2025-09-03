<?php
include 'db_connection.php';

$sql = "SELECT Item_ID, Type, Weight, Price FROM Jewellery_Item";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Jewellery Item</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-yellow-50 to-yellow-200 flex flex-col justify-between">
  <main class="flex-1 flex flex-col items-center justify-center py-10">
    <div class="w-full max-w-4xl bg-white/90 rounded-xl shadow-lg p-8">
      <h2 class="text-3xl font-bold text-yellow-700 mb-6 text-center drop-shadow">Jewellery Items</h2>
      <div class="overflow-x-auto rounded-lg">
        <table class="min-w-full text-sm text-left text-yellow-900">
          <thead class="bg-yellow-200 text-yellow-800 uppercase text-xs">
            <tr>
              <th class="px-6 py-3">Item ID</th>
              <th class="px-6 py-3">Type</th>
              <th class="px-6 py-3">Weight</th>
              <th class="px-6 py-3">Price</th>
              <th class="px-6 py-3">Action</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-yellow-100">
            <?php if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) { ?>
                  <tr>
                    <td class="px-6 py-2"><?= htmlspecialchars($row["Item_ID"]) ?></td>
                    <td class="px-6 py-2"><?= htmlspecialchars($row["Type"]) ?></td>
                    <td class="px-6 py-2"><?= htmlspecialchars($row["Weight"]) ?></td>
                    <td class="px-6 py-2"><?= htmlspecialchars($row["Price"]) ?></td>
                    <td class="px-6 py-2 whitespace-nowrap">
                      <a href="" class="text-yellow-700 hover:underline mr-3">Edit</a>
                      <a href="" class="text-red-600 hover:underline">Delete</a>
                    </td>
                  </tr>
                <?php }
              } else { ?>
                <tr><td colspan="5" class="px-6 py-2 text-center">No records found</td></tr>
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
