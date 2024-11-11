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

// Fetch all approved content
$result = $conn->query("SELECT * FROM contents WHERE approved = TRUE ORDER BY published_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Approved Content - UNILIA WRITERS FORUM</title>
    <link href="view.css" rel="stylesheet" type="text/css">
</head>
<body>
    <header>
        <h1>View Approved Content</h1>
    </header>

    <main>
        <?php if ($result->num_rows > 0): ?>
            <div class="cards">
                <?php while ($content = $result->fetch_assoc()): ?>
                    <div class="card">
                       
                        <p>Type: <?php echo htmlspecialchars($content['content_type']); ?></p>
                        <p>Date: <?php echo htmlspecialchars($content['published_date']); ?></p>
                        <button onclick="toggleContent('<?php echo $content['ID']; ?>')">View</button>
                        <div id="content-<?php echo $content['ID']; ?>" class="hidden">
                            <p><?php echo nl2br(htmlspecialchars($content['content'])); ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No approved content available.</p>
        <?php endif; ?>
    </main>
    <script>
        function toggleContent(id) {
            const contentDiv = document.getElementById('content-' + id);
            contentDiv.classList.toggle('hidden');
        }
    </script>
</body>
</html>
<?php $conn->close(); ?>
