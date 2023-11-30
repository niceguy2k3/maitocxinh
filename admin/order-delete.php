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
        
        // Thực hiện xử lý xoá đơn hàng tại đây

        echo true; // Trả về true nếu xoá thành công
        exit();
    }
}
echo false; // Trả về false nếu có lỗi hoặc không có dữ liệu
