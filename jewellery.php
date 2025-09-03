<?php
include 'db_connection.php';

$sql = "SELECT Item_ID, Type, Weight, Price FROM Jewellery_Item";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Jewellery Item</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <style>
    :root {--accent:#b8860b;--muted:#444;--bg:#faf9f7;--card:#ffffff}
    * {box-sizing:border-box}
    body {
      font-family:Inter, system-ui, Arial, sans-serif;
      margin:0;
      color: hsla(242, 74%, 61%, 1.00);
      background:url('https://images.unsplash.com/photo-1522312346375-d1a52e2b99b3') no-repeat center center fixed;
      background-size:cover;
      
    }

    /* Overlay to keep middle clean */
    .overlay {
      background:rgba(255,255,255,0.9);
      min-height:100vh;
      display:flex;
      flex-direction:column;
    }

    header {
      background:rgba(0,0,0,0.7);
      color:#fff;
      padding:12px 0;
      position:sticky;
      top:0;
      z-index:100;
    }
    .container {max-width:1100px;margin:0 auto;padding:0 24px}

    /* Nav */
    .nav {display:flex;align-items:center;justify-content:space-between}
    .brand {display:flex;align-items:center;gap:12px;color:#fff;font-weight:700}
    .logo {width:42px;height:42px;border-radius:50%;background:linear-gradient(45deg,#ffd87a,#ffb84d);display:flex;align-items:center;justify-content:center;font-weight:700;color:#3a2a00}
    nav {
      display:flex;
      align-items:center;
      gap:16px;
      position: relative;
    }
    nav a, nav button {
      color:#fff;
      font-weight:600;
      text-decoration:none;
      background:none;
      border:none;
      cursor:pointer;
      padding:8px 12px;
      font-family: inherit;
      font-size: 1rem;
      transition: color 0.3s;
    }
    nav a:hover, nav button:hover {
      color: var(--accent);
    }

    /* Dropdown */
    .dropdown {
      position: relative;
    }
    .dropdown-content {
      display: none;
      position: absolute;
      background: var(--card);
      color: #222;
      min-width: 160px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
      padding: 8px 0;
      border-radius: 4px;
      top: 36px;
      z-index: 200;
    }
    .dropdown-content a {
      color: #222;
      padding: 8px 16px;
      text-decoration: none;
      display: block;
      font-weight: 500;
    }
    .dropdown-content a:hover {
      background: var(--accent);
      color: #fff;
    }
    .dropdown:hover .dropdown-content {
      display: block;
    }

    /* Search Button */
    .search-btn {
      background: var(--accent);
      border-radius: 8px;
      padding: 8px 14px;
      font-weight: 700;
    }
    .search-btn:hover {
      background: #a17405;
    }

    main {flex:1;display:flex;align-items:center;justify-content:center;text-align:center;padding:60px 20px}
    main h1 {font-size:36px;margin-bottom:12px}
    main p {color:var(--muted);font-size:18px;max-width:700px;margin:0 auto 24px auto}

    footer {background:rgba(0,0,0,0.8);color:#eee;padding:18px 0;text-align:center;font-size:13px}
  </style>
</head>
<body class="container mt-5">
<!-- <h2>Jewellery Item</h2> -->
 <h2 class="text-center">Jewellery Item</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Item_ID</th>
            <th>Type</th>
            <th>Weight</th>
            <th>Price</th>
            <th>action</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row["Item_ID"]) ?></td>
                    <td><?= htmlspecialchars($row["Type"]) ?></td>
                    <td><?= htmlspecialchars($row["Weight"]) ?></td>
                    <td><?= htmlspecialchars($row["Price"]) ?></td>
                    <td>
                        <a href="">edit</a>
                        <a href="">delete</a>
                    </td>
                </tr>
            <?php }
        } else { ?>
            <tr><td colspan="4">No records found</td></tr>
        <?php } ?>
    </tbody>
</table>
<div class="d-flex justify-content-end mt-3">
  <a href="Homepage.html" class="btn btn-primary">Back to Home</a>
</div>
</body>
</html>

<?php $conn->close(); ?>
