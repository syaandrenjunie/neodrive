<?php
$servername = "localhost"; // your database host
$username = "root"; // your database username
$password = "Yellow_3to3"; // your database password
$dbname = "neodrive"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
