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

// Check if a request is received  
if ($_SERVER["REQUEST_METHOD"] == "POST") {  
    // Validate and sanitize input  
    $content_id = isset($_POST['id']) ? intval($_POST['id']) : 0;  
    $action = isset($_POST['action']) ? $_POST['action'] : '';  

    if ($content_id && ($action == 'approve' || $action == 'decline')) {  
        // Prepare SQL query based on action  
        if ($action == 'approve') {  
            $sql = "UPDATE contents SET approved = TRUE WHERE ID = ?";  
        } else { // decline  
            $sql = "UPDATE contents SET approved = FALSE WHERE ID = ?";  
        }  

        // Prepare and bind  
        if ($stmt = $conn->prepare($sql)) {  
            $stmt->bind_param("i", $content_id);  
            $stmt->execute();  
            $stmt->close();  
            echo "Content has been " . ($action == 'approve' ? "approved" : "declined");  
        } else {  
            echo "Error preparing statement: " . $conn->error;  
        }  
    } else {  
        echo "Invalid request.";  
    }  
} else {  
    echo "No request received.";  
}  

$conn->close();  
?>