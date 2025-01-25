<?php
session_start();
// Include functions and connect to the database using PDO MySQL
include 'functions.php';
$pdo = pdo_connect_mysql();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['img'])) {
    // Retrieve the form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $rrp = $_POST['rrp'];
    $quantity = $_POST['quantity'];
    
    // Handle the file upload
    $img = $_FILES['img']['name'];
    $target_dir = "imgs/";
    $target_file = $target_dir . basename($img);

    // Ensure the directory exists
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES['img']['tmp_name'], $target_file)) {
        // Insert the data into the database
        $stmt = $pdo->prepare('INSERT INTO products (title, description, price, rrp, quantity, img, date_added) VALUES (?, ?, ?, ?, ?, ?, NOW())');
        $stmt->execute([$title, $description, $price, $rrp, $quantity, $img]);
        echo 'Product added successfully!';
    } else {
        echo 'Failed to upload image.';
    }
}

?>

<?=template_header('CHANGU')?>

<div class="add-product content-wrapper">
    <h2>Add Product</h2>
    <form action="add_product.php" method="post" enctype="multipart/form-data">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" required>
        <br /><br />
        <label for="description">Description</label>
        <textarea id="description" name="description" required></textarea>
        <br /><br />
        <label for="price">Price</label>
        <input type="number" id="price" name="price" step="0.01" required>
        <br /><br />
        <label for="rrp">RRP</label>
        <input type="number" id="rrp" name="rrp" step="0.01" required>
        <br /><br />
        <label for="quantity">Quantity</label>
        <input type="number" id="quantity" name="quantity" required>
        <br /><br />
        <label for="img">Image File</label>
        <input type="file" id="img" name="img" required>
        <br />
        <input type="submit" value="Add Product">
    </form>
</div>

<?=template_footer()?>
