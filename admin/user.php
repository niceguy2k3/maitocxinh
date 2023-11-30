<div class="container">
    <h2 class="py-2 text-center h4">KHÁCH HÀNG</h2>
    <table class="table table-hover table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Tài Khoản</th>
                <th>Tên</th>
                <th>Ảnh</th>
                <th>Email</th>
                <th>Số Điện Thoại</th>
                <th>Vai Trò</th>
                <th >Thời Gian Tạo</th>
            
            </tr>
        </thead>
        <tbody>
            <?php
            require '../config/config.php';
            require '../model/conn.php';
            $stmt = $conn->prepare("SELECT * FROM `usr` WHERE 1");
            $stmt->execute();
            while ($usr = $stmt->fetch()) {
                if ($usr[6] == 0) {
                    $usr[6] = "Admin";
                } else if ($usr[6] == 1) {
                    $usr[6] = "User";
                }
                // Assuming $yourDateString is the string date you have
                $dateTime = new DateTime($usr[7]);
                
                // Now you can use date_format with $dateTime
                $formattedDate = date_format($dateTime, 'd/m/Y H:i:s');
                
                // Use $formattedDate as needed
                echo "<tr>
                    <td>$usr[0]</td>
                    <td>$usr[2]</td>
                    <td><img src='../uploads_user/$usr[3]' style='width: 70px; height: 70px;' alt=''></td>
                    <td>$usr[4]</td>
                    <td>$usr[5]</td>
                    <td>$usr[6]</td>
                    <td>$formattedDate</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Thêm vào cuối trang HTML -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function deleteCustomer(username) {
        if (confirm("Xác nhận xoá khách hàng?")) {
            $.ajax({
                url: "customers-delete.php",
                method: "POST",
                data: { username_delete: username },
                success: function (data) {
                    console.log(data); // In dữ liệu nhận được từ server ra console để kiểm tra
                    if (data.trim() === "success") {
                        alert("Xoá khách hàng thành công");
                        location.reload();
                    } else {
                        alert("Xoá khách hàng thất bại");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log("AJAX Error: " + textStatus, errorThrown); // In lỗi AJAX ra console
                }
            });
        }
    }
</script>
