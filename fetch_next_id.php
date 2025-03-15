<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reg_form_portfolio";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the next available ID
$sql = "SELECT MAX(ID) + 1 AS next_id FROM reg";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$next_id = $row['next_id'] ?? 1; // If no users exist, start from 1

echo $next_id;

$conn->close();
?>
