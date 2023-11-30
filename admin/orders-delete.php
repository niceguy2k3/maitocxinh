<!-- Trang quản lý đơn hàng -->
<div class="container">
    <!-- ... (phần code trang quản lý đơn hàng như trước) ... -->

    <script>
        function deleteOrder(orderId) {
            if (confirm("Xác Nhận Xóa") == true) {
                $.ajax({
                    url: "order-delete.php",
                    method: "POST",
                    data: { id_delete: orderId },
                    success: function (data) {
                        if (data) {
                            alert("Xóa Đơn Hàng Thành Công");
                            location.reload();
                        } else {
                            alert("Xóa Đơn Hàng Thất Bại");
                        }
                    }
                });
            }
        }
    </script>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_delete'])) {
        $orderId = $_POST['id_delete'];

        require '../config/config.php';
        require '../model/conn.php';

        // Xóa trước các chi tiết đơn hàng liên quan
        $stmtDeleteOrderDetails = $conn->prepare("DELETE FROM order_details WHERE id_order = ?");
        $stmtDeleteOrderDetails->execute([$orderId]);

        // Sau đó, xóa đơn hàng chính
        $stmtDeleteOrder = $conn->prepare("DELETE FROM orders WHERE id = ?");
        $stmtDeleteOrder->execute([$orderId]);

        echo true; // Trả về true nếu xoá thành công
        exit();
    }
}
echo false; // Trả về false nếu có lỗi hoặc không có dữ liệu

