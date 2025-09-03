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
  <style>
    :root {--accent:#b8860b;--muted:#444;--bg:#faf9f7;--card:#ffffff}
    * {box-sizing:border-box}
    body {
      font-family:Inter, system-ui, Arial, sans-serif;
      margin:0;
      color:#222;
      background:url('https://images.unsplash.com/photo-1522312346375-d1a52e2b99b3') no-repeat center center fixed;
      background-size:cover;
    }
    .overlay {
      background:rgba(255,255,255,0.9);
      min-height:100vh;
      display:flex;
      flex-direction:column;
      padding: 40px 20px;
    }
    h2 {
      color: var(--accent);
      text-align: center;
      margin-bottom: 24px;
    }
    .search-form, .update-form {
      max-width: 400px;
      margin: 0 auto 20px;
      background: var(--card);
      padding: 24px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgb(184 134 11 / 0.3);
    }
    input[type=text], input[type=tel] {
      width: 100%;
      padding: 10px 12px;
      margin-bottom: 16px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
    }
    button {
      width: 100%;
      background: var(--accent);
      border: none;
      padding: 12px;
      border-radius: 8px;
      font-size: 1.1rem;
      color: white;
      font-weight: 700;
      cursor: pointer;
      transition: background 0.3s;
    }
    button:hover {
      background: #a17405;
    }
    .message {
      max-width: 400px;
      margin: 12px auto;
      text-align: center;
      font-weight: 600;
      color: green;
    }
    .error {
      color: red;
    }
    .table-container {
      max-width: 800px;
      margin: 20px auto;
      background: var(--card);
      padding: 24px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgb(184 134 11 / 0.3);
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    th {
      background: var(--accent);
      color: white;
    }
    .action-links a {
      margin-right: 10px;
      color: var(--accent);
      text-decoration: none;
    }
    .action-links a:hover {
      text-decoration: underline;
    }
    .back-link {
      display: block;
      max-width: 400px;
      margin: 20px auto 0;
      text-align: center;
      color: var(--accent);
      text-decoration: none;
      font-weight: 600;
    }
    .back-link:hover {
      text-decoration: underline;
    }
    footer {background:rgba(0,0,0,0.8);color:#eee;padding:18px 0;text-align:center;font-size:13px;}
  </style>
</head>
<body>
  <div class="overlay">
    <h2>Customer Management</h2>
    
    <!-- Search Form -->
    <form class="search-form" method="GET" action="">
      <input type="text" name="search" placeholder="Search by ID, Name, or Contact" />
      <button type="submit">Search</button>
    </form>
    
    <!-- Search Results -->
    <?php if($search_message): ?>
      <div class="message error"><?= htmlspecialchars($search_message) ?></div>
    <?php endif; ?>
    <?php if(!empty($search_results)): ?>
      <div class="table-container">
        <table>
          <tr>
            <th>Customer ID</th>
            <th>Name</th>
            <th>Contact</th>
            <th>Actions</th>
          </tr>
          <?php foreach($search_results as $customer): ?>
            <tr>
              <td><?= htmlspecialchars($customer['Customer_ID']) ?></td>
              <td><?= htmlspecialchars($customer['Name']) ?></td>
              <td><?= htmlspecialchars($customer['Contact']) ?></td>
              <td class="action-links">
                <a href="?edit=<?= htmlspecialchars($customer['Customer_ID']) ?>">Edit</a>
                <a href="?delete=<?= htmlspecialchars($customer['Customer_ID']) ?>" onclick="return confirm('Are you sure you want to delete this customer?')">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
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
      <form class="update-form" method="POST" action="">
        <input type="text" name="Customer_ID" value="<?= $edit_customer ? htmlspecialchars($edit_customer['Customer_ID']) : '' ?>" readonly />
        <input type="text" name="Name" value="<?= $edit_customer ? htmlspecialchars($edit_customer['Name']) : '' ?>" required />
        <input type="tel" name="Contact" value="<?= $edit_customer ? htmlspecialchars($edit_customer['Contact']) : '' ?>" required />
        <button type="submit" name="update">Update</button>
      </form>
    <?php endif; ?>
    
    <!-- Messages -->
    <?php if($update_message): ?>
      <div class="message <?= strpos($update_message, 'Error') === false ? '' : 'error' ?>">
        <?= htmlspecialchars($update_message) ?>
      </div>
    <?php endif; ?>
    <?php if($delete_message): ?>
      <div class="message <?= strpos($delete_message, 'Error') === false ? '' : 'error' ?>">
        <?= htmlspecialchars($delete_message) ?>
      </div>
    <?php endif; ?>
    
    <!-- All Customers Table -->
    <div class="table-container">
      <h3>All Customers</h3>
      <table>
        <tr>
          <th>Customer ID</th>
          <th>Name</th>
          <th>Contact</th>
          <th>Actions</th>
        </tr>
        <?php foreach($customers as $customer): ?>
          <tr>
            <td><?= htmlspecialchars($customer['Customer_ID']) ?></td>
            <td><?= htmlspecialchars($customer['Name']) ?></td>
            <td><?= htmlspecialchars($customer['Contact']) ?></td>
            <td class="action-links">
              <a href="?edit=<?= htmlspecialchars($customer['Customer_ID']) ?>">Edit</a>
              <a href="?delete=<?= htmlspecialchars($customer['Customer_ID']) ?>" onclick="return confirm('Are you sure you want to delete this customer?')">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
    
    
    <a class="back-link" href="./Homepage.html">← Back to Home</a>
    
  </div>
    <footer>
      <div>© Sunmoon Gold Store — All rights reserved.</div>
      <div>Designed by Sadia Jannat Moon — ID: 23303060</div>
    </footer>
</body>
</html>