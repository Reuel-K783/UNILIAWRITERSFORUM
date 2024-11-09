<?php  
// Database configuration 
session_start(); // Start a session   
$servername = "localhost";  
$username = "root";  
$password = "";  
$dbname = "UNF";  

// Create connection  
$conn = new mysqli($servername, $username, $password, $dbname);  

// Check connection  
if ($conn->connect_error) {  
    die("Connection failed: " . $conn->connect_error);  
}  

// Check if form is submitted  
if ($_SERVER["REQUEST_METHOD"] == "POST") {  
    // Retrieve form data  
    $name = $conn->real_escape_string($_POST['name']); // Change $username to $full_name  
    $email = $conn->real_escape_string($_POST['email']);  
    $password = $conn->real_escape_string($_POST['password']);  
    $confirm_password = $conn->real_escape_string($_POST['confirm-password']);  
    $bio = $conn->real_escape_string($_POST['bio']);  
    // Validate password match  
    if ($password !== $confirm_password) {  
        echo "Passwords do not match.";  
        exit;  
    }  

    // Hash the password  
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);  

    // Use prepared statement to avoid SQL injection  
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, bio) VALUES (?, ?, ?, ?)");  
    $stmt->bind_param("sss", $name, $email, $hashed_password); // Use the correct variable for name  

    // Execute the statement  
    if ($stmt->execute()) {  
        header("Location: login.php"); 
    } else {  
        echo "Error: " . $stmt->error;  
    }  

    // Close the statement  
    $stmt->close();  
}  

// Close connection  
$conn->close();  
?>