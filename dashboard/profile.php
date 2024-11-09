<?php  
session_start();  

// Check if the user is logged in, redirect to login page if not  
if (!isset($_SESSION['username'])) {  
    header("Location: login.php");  
    exit();  
}  

// Include database connection (modify accordingly)  
include 'db_connection.php';  

// Handle form submission for profile update  
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])) {  
    $username = $_POST['username'];  
    $email = $_POST['email'];  
    $bio = $_POST['bio'];  
    $password = $_POST['password'];  

    // Update user profile in the database  
    $userId = $_SESSION['user_id']; // Assume user_id is stored in session  
    $query = "UPDATE users SET username=?, email=?, bio=? WHERE id=?";  

    // Prepare statement  
    $stmt = $conn->prepare($query);  
    $stmt->bind_param("sssi", $username, $email, $bio, $userId);  
    $stmt->execute();  

    // Update password if given  
    if (!empty($password)) {  
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);  
        $query = "UPDATE users SET password=? WHERE id=?";  
        $stmt = $conn->prepare($query);  
        $stmt->bind_param("si", $hashedPassword, $userId);  
        $stmt->execute();  
    }  

    // Update session variables  
    $_SESSION['username'] = $username;  
    $_SESSION['email'] = $email;  
    $_SESSION['bio'] = $bio;  

    // Redirect to profile page to see changes  
    header("Location: profile.php");  
    exit();  
}  

// Handle account deletion  
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_account'])) {  
    $userId = $_SESSION['user_id']; // Use user_id from session  
    $query = "DELETE FROM users WHERE id=?";  
    $stmt = $conn->prepare($query);  
    $stmt->bind_param("i", $userId);  
    $stmt->execute();  

    // Destroy session and redirect to homepage  
    session_destroy();  
    header("Location: index.php");  
    exit();  
}  

// Fetch current user info for displaying  
$userId = $_SESSION['user_id'];  
$query = "SELECT username, email, bio FROM users WHERE id=?";  
$stmt = $conn->prepare($query);  
$stmt->bind_param("i", $userId);  
$stmt->execute();  
$result = $stmt->get_result();  
$user = $result->fetch_assoc();  
?>  
