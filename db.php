<?php
$servername = "127.0.0.1";  // Use 127.0.0.1
$username   = "root";        // Default XAMPP username
$password   = "";            // Default XAMPP password is blank
$database   = "cmotorparts11"; // Your database name
$port       = 3307;          // Default MySQL port

// Create connection
$conn = new mysqli($servername, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
// echo "Database connected successfully"; // optional
?>
