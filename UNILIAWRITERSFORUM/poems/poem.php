<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="poem.css" rel="stylesheet" type="text/css">
    <title>UNILIA WRITERS FORUM Dashboard</title>
</head>
<body>
    <header>
        <h1>Welcome to the UNILIA WRITERS FORUM Dashboard!</h1>
    </header>

    <nav>
        <ul>
            <li><a href="profile.html">My Profile</a></li>
            <li><a href="resources.html">Writing Resources</a></li>
            <li><a href="community.html">Community Forum</a></li>
            <li><a href="books.html">Books</a></li>
            <li><a href="../dashboard/logout.php">Log Out</a></li>
        </ul>
    </nav>

    <main class="container">
        <section id="profile" class="hidden">
            <!-- Profile content goes here -->
        </section>

        <section id="resources" class="hidden">
            <!-- Writing resources content goes here -->
        </section>

        <section id="community" class="hidden">
            <!-- Community forum content goes here -->
        </section>

        <section id="books" class="hidden">
            <!-- Books content goes here -->
        </section>

        <section id="poems">
            <div id="poem-of-the-day">
                <h3>Poem of the Day</h3>
                <?php
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

                // Fetch Poem of the Day
                $result = $conn->query("SELECT * FROM poems WHERE is_poem_of_the_day = TRUE LIMIT 1");
                $poem = $result->fetch_assoc();
                if ($poem) {
                    echo '<div class="poem-card">';
                    echo '<h3>"' . htmlspecialchars($poem['title']) . '"</h3>';
                    echo '<p>By ' . htmlspecialchars($poem['author']) . '</p>';
                    echo '<p>' . nl2br(htmlspecialchars($poem['content'])) . '</p>';
                    echo '<p><em>Published: ' . htmlspecialchars($poem['published_date']) . '</em></p>';
                    echo '</div>';
                } else {
                    echo '<p>No Poem of the Day available.</p>';
                }

                // Fetch General Poems
                $result = $conn->query("SELECT * FROM poems WHERE is_poem_of_the_day = FALSE ORDER BY published_date DESC");
                if ($result->num_rows > 0) {
                    echo '<div id="general-poems">';
                    echo '<h3>General Poems</h3>';
                    while ($poem = $result->fetch_assoc()) {
                        echo '<div class="poem-card">';
                        echo '<h3>"' . htmlspecialchars($poem['title']) . '"</h3>';
                        echo '<p>By ' . htmlspecialchars($poem['author']) . '</p>';
                        echo '<p>' . nl2br(htmlspecialchars($poem['content'])) . '</p>';
                        echo '<p><em>Published: ' . htmlspecialchars($poem['published_date']) . '</em></p>';
                        echo '</div>';
                    }
                    echo '</div>';
                } else {
                    echo '<p>No general poems available.</p>';
                }

                $conn->close();
                ?>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 UNILIA WRITERS FORUM. All rights reserved.</p>
        <p><a href="#privacy">Privacy Policy</a> | <a href="#terms">Terms of Service</a></p>
    </footer>

    <script>
        function showSection(sectionId) {
            const sections = document.querySelectorAll('main section');
            sections.forEach((section) => {
                section.classList.add('hidden'); // Hide all sections
            });
            document.getElementById(sectionId).classList.remove('hidden'); // Show the selected section
        }

        // Optionally, show the poems section by default or any other section
        showSection('poems');
    </script>
</body>
</html>
