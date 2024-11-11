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

// Add new content
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $conn->real_escape_string($_POST['content']);
    $published_date = $conn->real_escape_string($_POST['published_date']);
    $content_type = $conn->real_escape_string($_POST['content_type']); 

    $sql = "INSERT INTO contents (content, published_date, content_type, approved) VALUES ('$content', '$published_date', '$content_type', FALSE)";
    if ($conn->query($sql) === TRUE) {
        echo "Content added successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add exam</title>
    <link href="add_content.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="wrapper">
    <header>
        <h1>Add New Content - UNILIA WRITERS FORUM</h1>
    </header>

    <nav>
        <ul>
            <li><a href="dashboard.php">Admin Dashboard</a></li>
            <li><a href="manage_poems.php">Manage Poems</a></li>
            <li><a href="profile.html">My Profile</a></li>
            <li><a href="../dashboard/logout.php">Log Out</a></li>
        </ul>
    </nav>

    <main>
        <section id="add-content">
            <h2>Add New Content</h2>
            <form action="add_exam.php" method="post">
                <label for="content">Content:</label>
                <textarea id="content" name="content" required></textarea>

                <label for="published_date">Published Date:</label>
                <input type="date" id="published_date" name="published_date" required>

                <label for="content_type">Content Type:</label>
                <select id="content_type" name="content_type" required>
                    <option value="exam">exam</option>
                    <option value="assignment">assignment</option>
                    <option value="essay">essay</option>
                    <option value="research">research</option>
                    <option value="proposal">proposal</option>
                </select>

                <button type="submit">Add Content</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 UNILIA WRITERS FORUM. All rights reserved.</p>
    </footer>
</div>
</body>
</html>
