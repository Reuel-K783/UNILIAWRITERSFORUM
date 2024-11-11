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

// Debug: Print session variable
/*
if (!isset($_SESSION['admin_user'])) {
    echo "Admin user not logged in.";
    header("Location: ../register/login.html");
    exit;
} else {
    echo "Admin user is logged in.";
}
*/
// Add new content
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $content = $conn->real_escape_string($_POST['content']);
    $published_date = $conn->real_escape_string($_POST['published_date']);
    $content_type = $conn->real_escape_string($_POST['content_type']); // For differentiating between poems, stories, etc.

    $sql = "INSERT INTO contents (title, author, content, published_date, content_type) VALUES ('$title', '$author', '$content', '$published_date', '$content_type')";
    if ($conn->query($sql) === TRUE) {
        echo "Content added successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch all existing content types
$content_types = ["Poem", "Story", "Article"]; // You can fetch this from a database or define it as an array
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Content</title>
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
            <form action="add_content.php" method="post">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>

                <label for="author">Author:</label>
                <input type="text" id="author" name="author" required>

                <label for="content">Content:</label>
                <textarea id="content" name="content" required></textarea>

                <label for="published_date">Published Date:</label>
                <input type="date" id="published_date" name="published_date" required>

                <label for="content_type">Content Type:</label>
                <select id="content_type" name="content_type" required>
                    <?php foreach ($content_types as $type) : ?>
                        <option value="<?php echo $type; ?>"><?php echo $type; ?></option>
                    <?php endforeach; ?>
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
