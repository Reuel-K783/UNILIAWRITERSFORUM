<?php  
session_start(); // Start a session  

// Enable error reporting  
error_reporting(E_ALL);  
ini_set('display_errors', 1);  

// Database configuration   
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

// Check if form is submitted  
if ($_SERVER["REQUEST_METHOD"] == "POST") {  
    // Retrieve form data  
    $first_name = $conn->real_escape_string($_POST['first_name']);  
    $last_name = $conn->real_escape_string($_POST['last_name']);  
    $school_email = $conn->real_escape_string($_POST['school_email']);  
    $phone_number = $conn->real_escape_string($_POST['phone_number']); // corrected variable name  
    $dob = $conn->real_escape_string($_POST['dob']);  
    $program = $conn->real_escape_string($_POST['program']);  
    
    // Use prepared statement to avoid SQL injection  
    $stmt = $conn->prepare("INSERT INTO apply (first_name, last_name, school_email, phone_number, dob, program) VALUES (?, ?, ?, ?, ?, ?)");  
    $stmt->bind_param("ssssss", $first_name, $last_name, $school_email, $phone_number, $dob, $program);  

    // Execute the statement  
    if ($stmt->execute()) {  
        header("Location: view.php");   
        exit;  
    } else {  
        echo "Error: " . $stmt->error;  
    }  

    // Close the statement  
    $stmt->close();  
}  

// Close connection  
$conn->close();  
?>