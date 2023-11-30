<?php
// product-status.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ yêu cầu POST
    $productIds = $_POST['ids'];
    $status = $_POST['status'];

    // Xử lý cập nhật trạng thái của sản phẩm trong cơ sở dữ liệu
    require '../config/config.php';
    require '../model/conn.php';

    foreach ($productIds as $productId) {
        // Thực hiện truy vấn cập nhật trạng thái tương ứng với $status
        $stmt = $conn->prepare("UPDATE product SET status = :status WHERE id = :id");
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
        $stmt->execute();
    }

    echo "Cập nhật trạng thái thành công!";
} else {
    // Trường hợp không phải là yêu cầu POST
    echo "Invalid request method.";
}
?>
