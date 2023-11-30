<?php
require '../config/config.php';
require '../model/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ids = $_POST['ids'];
    $status = $_POST['status'];

    // Chuyển mảng ids thành chuỗi 'id1, id2, ...'
    $idList = implode(',', $ids);

    $stmt = $conn->prepare("UPDATE categories SET status = ? WHERE id IN ($idList)");
    $stmt->execute([$status]);

    echo "Cập nhật trạng thái thành công";
} else {
    echo "Invalid Request";
}
?>
