<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "UNF";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, 3307);

// Check connection

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo ""; 
?>