<?php
include 'db_connection.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $certificate_id = $_POST['Certificate_ID'];
    $item_id = $_POST['Item_ID'];
    $issue_date = $_POST['Issue_Date'];
    

    if ($certificate_id && $item_id && $issue_date && $expiry_date) {
        $stmt = $conn->prepare("INSERT INTO Authenticity_Certificate (Certificate_ID, Item_ID, Issue_Date) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $certificate_id, $item_id, $issue_date);
        if ($stmt->execute()) {
            $message = "Certificate registered successfully!";
        } else {
            $message = "Error: Could not register certificate.";
        }
        $stmt->close();
    } else {
        $message = "Please fill in all fields.";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register Authenticity Certificate - Sunmoon Gold Store</title>
  <style>
    /* Same CSS as before */
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
    form {
      max-width: 400px;
      margin: 0 auto;
      background: var(--card);
      padding: 24px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgb(184 134 11 / 0.3);
    }
    input[type=text], input[type=date] {
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
      margin: 12px auto 0;
      text-align: center;
      font-weight: 600;
      color: green;
    }
    .error {
      color: red;
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
  </style>
</head>
<body>
  <div class="overlay">
    <h2>Register Authenticity Certificate</h2>
    <?php if($message): ?>
      <div class="message <?= strpos($message, 'Error') === false ? '' : 'error' ?>">
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>
    <form method="POST" action="">
      <input type="text" name="Certificate_ID" placeholder="Certificate ID" required />
      <input type="text" name="Item_ID" placeholder="Item ID" required />
      <input type="date" name="Issue_Date" placeholder="Issue Date" required />
      <input type="date" name="Expiry_Date" placeholder="Expiry Date" required />
      <button type="submit">Submit</button>
    </form>
    <a class="back-link" href="Homepage.html">← Back to Home</a>
  </div>
</body>
</html>
