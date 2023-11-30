<?php
require '../config/config.php';
require '../model/conn.php';

if (isset($_POST['username_delete'])) {
    $username = $_POST['username_delete'];

    // Thực hiện truy vấn xóa trong cơ sở dữ liệu
    $stmt = $conn->prepare("DELETE FROM `usr` WHERE username = ?");
    $stmt->execute([$username]);

    // Kiểm tra xem truy vấn đã thành công hay không
    $rowCount = $stmt->rowCount();
    
    if ($rowCount > 0) {
        echo "success";
    } else {
        echo "failure";
    }
} else {
    echo "Invalid request";
}
?>
