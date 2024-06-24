<?php
// Database credentials
$servername = "localhost";   // Replace with your database server hostname
$username = "root";      // Replace with your database username
$password = "";      // Replace with your database password
$dbname = "statistics";   // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// You can use this $conn object in other PHP files by including connect.php
?>
