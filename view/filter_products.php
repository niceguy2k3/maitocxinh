<?php
    include 'db_connection.php'; // Include your database connection file

    $min_price = $_POST['min_price'];
    $max_price = $_POST['max_price'];

    $stmt = $conn->prepare("SELECT * FROM product WHERE id_cate = ? AND status = 1 AND deleted = 0 AND price BETWEEN ? AND ?");
    $stmt->bindParam(1, $id_cate);
    $stmt->bindParam(2, $min_price);
    $stmt->bindParam(3, $max_price);
    $stmt->execute();

    while ($row = $stmt->fetch()) {
        // Output your product HTML as you did before
        echo '<div class="container">
            <!-- Your product HTML here -->
        </div>';
    }
?>
