<?php
$servername = "localhost";
$username = "root";     // default XAMPP username
$password = "";         // default XAMPP password is empty
$dbname = "qthrough";

// Create connection
$conn = new mysqli(hostname: $servername, username: $username, password: $password, database: $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    // Optional: uncomment to check connection
    echo "Connected successfully";
}
?>
