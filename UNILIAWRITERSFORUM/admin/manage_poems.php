<?php
session_start();

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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_poem'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $content = $conn->real_escape_string($_POST['content']);
    $published_date = $conn->real_escape_string($_POST['published_date']);
    $is_poem_of_the_day = isset($_POST['is_poem_of_the_day']) ? 1 : 0;

    if ($is_poem_of_the_day) {
        // Reset any previous poem of the day
        $conn->query("UPDATE poems SET is_poem_of_the_day = FALSE WHERE is_poem_of_the_day = TRUE");
    }

    $sql = "INSERT INTO poems (title, author, content, published_date, is_poem_of_the_day) VALUES ('$title', '$author', '$content', '$published_date', $is_poem_of_the_day)";
    if ($conn->query($sql) === TRUE) {
        echo "Poem added successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Delete a poem
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_poem'])) {
    $poem_id = $conn->real_escape_string($_POST['poem_id']);
    $sql = "DELETE FROM poems WHERE ID = $poem_id";
    if ($conn->query($sql) === TRUE) {
        echo "Poem deleted successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch all poems
$result = $conn->query("SELECT * FROM poems ORDER BY published_date DESC");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Poems</title>
    <link href="add_content.css" rel="stylesheet" type="text/css">
</head>
<body>
    <header>
        <h1>Manage Poems - UNILIA WRITERS FORUM</h1>
    </header>

    <nav>
        <ul>
            <li><a href="dashboard.php">Admin Dashboard</a></li>
            <li><a href="profile.html">My Profile</a></li>
            <li><a href="../dashboard/logout.php">Log Out</a></li>
        </ul>
    </nav>

    <main>
        <section id="add-poem">
            <h2>Add New Poem</h2>
            <form action="manage_poems.php" method="post">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>

                <label for="author">Author:</label>
                <input type="text" id="author" name="author" required>

                <label for="content">Content:</label>
                <textarea id="content" name="content" required></textarea>

                <label for="published_date">Published Date:</label>
                <input type="date" id="published_date" name="published_date" required>

                <label for="is_poem_of_the_day">Set as Poem of the Day:</label>
                <input type="checkbox" id="is_poem_of_the_day" name="is_poem_of_the_day">

                <button type="submit" name="add_poem">Add Poem</button>
            </form>
        </section>

        <section id="delete-poem">
            <h2>Delete Poem</h2>
            <form action="manage_poems.php" method="post">
                <label for="poem_id">Select Poem to Delete:</label>
                <select id="poem_id" name="poem_id" required>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <option value="<?php echo $row['ID']; ?>"><?php echo $row['title']; ?> by <?php echo $row['author']; ?></option>
                    <?php endwhile; ?>
                </select>
                <button type="submit" name="delete_poem">Delete Poem</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 UNILIA WRITERS FORUM. All rights reserved.</p>
    </footer>
</body>
</html>
