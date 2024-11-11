<?php
session_start();
include 'conn.php';

// Retrieve user data
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'update') {
        // Update user data
        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $bio = $conn->real_escape_string($_POST['bio']);

        $sql = "UPDATE users SET name = '$name', email = '$email', bio = '$bio' WHERE ID = '$user_id'";
        if ($conn->query($sql) === TRUE) {
            echo "Profile updated successfully.";
        } else {
            echo "Error updating profile: " . $conn->error;
        }
    } elseif ($action === 'delete') {
        // Delete user account
        $sql = "DELETE FROM users WHERE ID = '$user_id'";
        if ($conn->query($sql) === TRUE) {
            session_destroy();
            header("Location: signup.html");
            exit;
        } else {
            echo "Error deleting account: " . $conn->error;
        }
    }
}

// Fetch user data
$sql = "SELECT * FROM users WHERE ID = '$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>User Profile</h1>
    <form action="profile.php" method="post">
        <input type="hidden" name="action" value="update">
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        
        <label for="bio">Bio:</label>
        <textarea id="bio" name="bio" required><?php echo htmlspecialchars($user['bio']); ?></textarea>
        
        <button type="submit">Update Profile</button>
    </form>
    
    <form action="profile.php" method="post" onsubmit="return confirm('Are you sure you want to delete your account?');">
        <input type="hidden" name="action" value="delete">
        <button type="submit" style="background-color: red; color: white;">Delete Account</button>
    </form>
</body>
</html>
