<?php
include './../db_connection.php'; // Make sure this file connects to your database
$show_table = false;
// View all employees
function getAllEmployees($conn) {
    $sql = "SELECT * FROM Employee";
    $result = $conn->query($sql);
    $employees = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $employees[] = $row;
        }
    }
    return $employees;
}

// Search employees
$search_message = "";
$search_results = [];
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = $conn->real_escape_string($_GET['search']);
    $sql = "SELECT * FROM Employee WHERE Employee_ID LIKE '%$search_term%' OR employee_name LIKE '%$search_term%' OR number LIKE '%$search_term%'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $search_results[] = $row;
        }
    } else {
        $search_message = "No customers found.";
    }
}

// Update employees
$update_message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['Employee_ID'];
    $name = $_POST['employee_name'];
    $contact = $_POST['number'];
    
    if ($id && $name && $contact) {
        $stmt = $conn->prepare("UPDATE Employee SET employee_name=?, number=? WHERE Employee_ID=?");
        $stmt->bind_param("sss", $name, $contact, $id);
        if ($stmt->execute()) {
            $update_message = "Employee updated successfully!";
            header("Location: ./employee.php");
            exit();
        } else {
            $update_message = "Error: Could not update employee.";
        }
        $stmt->close();
    } else {
        $update_message = "Please fill in all fields.";
    }
}

// Delete employees
$delete_message = "";
if (isset($_GET['delete'])) {
    $id = $conn->real_escape_string($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM Employee WHERE Employee_ID=?");
    $stmt->bind_param("s", $id);
    if ($stmt->execute()) {
        $delete_message = "Employee deleted successfully!";
        header("Location: ./employee.php");
        exit();
    } else {
        $delete_message = "Error: Could not delete employee.";
    }
    $stmt->close();
}

$employees = getAllEmployees($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Employees</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-yellow-50 to-yellow-200 flex flex-col justify-between">
  <!-- Navbar -->
  <header class="bg-white/80 shadow-lg sticky top-0 z-10">
    <?php include 'header.php'; ?>
  </header>
<main class="flex-1 flex flex-col items-center justify-center py-10">
  <div class="container mx-auto bg-white/90 rounded-xl shadow-lg p-8">
    <h2 class="text-3xl font-bold text-yellow-700 mb-6 text-center drop-shadow">Employee List</h2>
     <!-- Search Form -->
      <div class="flex justify-start mb-2 w-1/3">
        <form class="flex items-center rounded-lg py-2 gap-2 w-full" method="GET" action="">
          <input 
            type="text" 
            name="search" 
            placeholder="Search by ID, Name, or Contact"
            required
            class="rounded-md border w-full border-yellow-200 px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none"
            value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"
          />
          <button 
            type="submit" 
            class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-4 py-2 rounded-md transition"
            title="Search"
          >
            Search
          </button>
        </form>
        
      </div>
      <p class="w-full h-[1px] bg-black mb-4"></p>
       <!-- Search Results -->
      <?php if($search_message): ?>
        <div class="max-w-md mx-auto mb-4 text-center text-red-600 font-semibold"><?= htmlspecialchars($search_message) ?></div>
      <?php endif; ?>
      <?php if(isset($_GET['search'])): 
        $show_table = true;
        ?>
        <?php endif; ?>
      <?php if(!empty($search_results)): 
        ?>
        <div class="overflow-x-auto rounded-lg mb-8">
          <table class="min-w-full text-sm text-left text-yellow-900">
            <thead class="bg-yellow-200 text-yellow-800 uppercase text-xs">
              <tr>
                <th class="px-6 py-3 border">Employee ID</th>
                <th class="px-6 py-3 border">Employee Name</th>
                <th class="px-6 py-3 border">Contact</th>
                <th class="px-6 py-3 border">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-yellow-100">
              <?php foreach($search_results as $employee): ?>
                <tr>
                  <td class="px-6 py-2 border"><?= htmlspecialchars($employee['employee_id']) ?></td>
                  <td class="px-6 py-2 border"><?= htmlspecialchars($employee['employee_name']) ?></td>
                  <td class="px-6 py-2 border"><?= htmlspecialchars($employee['number']) ?></td>
                  <td class="px-6 py-2 border">
                    <a href="?edit=<?= htmlspecialchars($employee['employee_id']) ?>" class="text-yellow-700 hover:underline mr-3">Edit</a>
                    <a href="?delete=<?= htmlspecialchars($employee['employee_id']) ?>" onclick="return confirm('Are you sure you want to delete this employee?')" class="text-red-600 hover:underline">Delete</a>
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
    <div class="overflow-x-auto rounded-lg <?php echo !$show_table ? 'block' : 'hidden'; ?>">
      <table class="min-w-full text-sm text-left text-yellow-900">
        <thead class="bg-yellow-200 text-yellow-800 uppercase text-xs">
          <tr>
            <th class="px-6 py-3 border">SI</th>
            <th class="px-6 py-3 border">Employee ID</th>
            <th class="px-6 py-3 border">Name</th>
            <th class="px-6 py-3 border">Contact</th>
            <th class="px-6 py-3 border">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-yellow-100">
             <?php foreach($employees as $index => $employee): ?>
              <tr>
              <td class="px-6 border py-2"><?= $index + 1 ?></td>
              <td class="px-6 border py-2"><?= htmlspecialchars($employee['employee_id']) ?></td>
              <td class="px-6 border py-2"><?= htmlspecialchars($employee['employee_name']) ?></td>
              <td class="px-6 border py-2"><?= htmlspecialchars($employee['number']) ?></td>
              <td class="px-6 py-2 border">
                <a href="?edit=<?= htmlspecialchars($employee['employee_id']) ?>" class="text-yellow-700 hover:underline mr-3">Edit</a>
                <a href="?delete=<?= htmlspecialchars($employee['employee_id']) ?>" onclick="return confirm('Are you sure you want to delete this employee?')" class="text-red-600 hover:underline">Delete</a>
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
