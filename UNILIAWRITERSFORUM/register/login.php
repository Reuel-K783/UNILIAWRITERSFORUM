<?php  
session_start();  

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

$email = mysqli_real_escape_string($conn, $_POST['email']);  
$password = mysqli_real_escape_string($conn, $_POST['password']);  

$sql = "SELECT * FROM users WHERE email = '$email'";  
$result = mysqli_query($conn, $sql);  
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);  

if ($row) {  
    if (password_verify($password, $row["password"])) {  
        $_SESSION['user_id'] = $row['id']; // Store user ID in the session  
        $_SESSION['user_name'] = $row['name']; // Store user name in the session  
        $_SESSION['role'] = $row['role']; // Store user role in the session  

        // Redirect to the appropriate dashboard based on user role  
        if ($row['role'] === 'admin') {  
            header("Location: http://localhost:8081/GitHub/UNILIAWRITERSFORUM/admin/admin.html");  
        } else {  
            header("Location: http://localhost:8081/GitHub/UNILIAWRITERSFORUM/dashboard/dashboard.html");  
        }  
        exit;  
    } else {  
        // Invalid credentials  
        echo '<script>  
                alert("Invalid credentials");  
                window.location.href = "login.html";  
              </script>';  
    }  
} else {  
    // User does not exist  
    echo '<script>  
            alert("User does not exist");  
            window.location.href = "signup.html";  
          </script>';  
}  

$conn->close();  
?>