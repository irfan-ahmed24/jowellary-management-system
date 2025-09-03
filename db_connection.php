<?php
$servername = "localhost";  // Change if needed
$username = "root";         // Change with your DB username
$password = "";             // Change with your DB password
$dbname = "db_jwms";       // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
