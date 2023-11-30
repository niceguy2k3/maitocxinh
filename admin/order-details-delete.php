<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_order'])) {
        $orderId = $_POST['id_order'];

        // Thực hiện xử lý xoá chi tiết đơn hàng tại đây
        require '../config/config.php';
        require '../model/conn.php';

        $stmt = $conn->prepare("DELETE FROM order_details WHERE id_order = :id");
        $stmt->bindParam(':id', $orderId, PDO::PARAM_INT);
        $result = $stmt->execute();

        echo $result; // Trả về true nếu xoá thành công, false nếu có lỗi
        exit();
    }
}
echo false; // Trả về false nếu có lỗi hoặc không có dữ liệu
?>
