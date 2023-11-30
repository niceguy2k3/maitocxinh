<div class="container">
    <h2 class="py-2 text-center h4 ">ĐƠN HÀNG</h2>
    <table class="table table-hover table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Đơn Hàng</th>
                <th>Username</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Số Điện Thoại</th>
                <th>Địa Chỉ</th>
                <th>Ghi Chú</th>
                <th>Ngày Đặt</th>
                <th>Tổng Tiền</th>
                <th>Trạng Thái</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            require '../config/config.php';
            require '../model/conn.php';
            $stmt = $conn->prepare("SELECT * FROM orders 
                JOIN (SELECT id_order, sum(total_money) as total_money from order_details GROUP BY id_order) as order_details 
                WHERE orders.id = order_details.id_order ORDER BY orders.id");
            $stmt->execute();
            while ($order = $stmt->fetch()) {
                if ($order[8] == 1) {
                    $order[8] = "Chưa Giao Hàng";
                } else if ($order[8] == 2) {
                    $order[8] = "Đã Giao Hàng";
                }
                // Assuming $yourDateString is the string date you have
                $dateTime = new DateTime($order[7]);
                
                // Now you can use date_format with $dateTime
                $formattedDate = date_format($dateTime, 'd/m/Y H:i:s');
                
                // Use $formattedDate as needed
                echo "<tr>
                    <td>$order[0]</td>
                    <td>$order[1]</td>
                    <td>$order[2]</td>
                    <td>$order[3]</td>
                    <td>$order[4]</td>
                    <td>$order[5]</td>
                    <td>$order[6]</td>
                    <td>$formattedDate</td>
                    <td>" . number_format($order[10], 0, ",", ".") . "</td>
                    <td>$order[8]</td>
                    <td style='width:60px'><a href='./orders-add.php?id=$order[0]'><button class='btn btn-warning'>Sửa</button></a></td>
                    <td style='width:60px'><button class='btn btn-danger' onclick='deleteOrder($order[0])'>Xóa</button></td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Thêm vào cuối trang HTML -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function deleteOrder(orderId) {
        if (confirm("Xác nhận xoá đơn hàng?")) {
            $.ajax({
                url: "orders-delete.php",
                method: "POST",
                data: { id_delete: orderId },
                success: function (data) {
                    if (data) {
                        // Sau khi xoá đơn hàng, tiến hành xoá chi tiết đơn hàng
                        deleteOrderDetails(orderId);
                    } else {
                        alert("Xoá đơn hàng thất bại");
                    }
                }
            });
        }
    }

    function deleteOrderDetails(orderId) {
        $.ajax({
            url: "order-details-delete.php", // Đường dẫn xử lý xoá chi tiết đơn hàng
            method: "POST",
            data: { id_order: orderId },
            success: function (data) {
                if (data) {
                    alert("Xoá đơn hàng thành công");
                    location.reload();
                } else {
                    alert("Xoá đơn hàng thất bại");
                }
            }
        });
    }
</script>
