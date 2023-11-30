<div class="container">
    <h2 class="py-2 text-center h4 ">BÌNH LUẬN</h2>
    <table class="table table-hover table-bordered">
    <thead  class="thead-dark" >
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Tên Sản Phẩm</th>
            <th>Nội Dung</th>
            <th>Ngày Đăng </th>
            <th>Ngày Chỉnh Sửa </th>
            <th colspan="2"></th>
        </tr>
        
    </thead>
    <tbody>
    <?php
        require '../config/config.php';
        require '../model/conn.php';
        $stmt = $conn ->prepare("SELECT cmt.id, content, id_prod, id_user, cmt.create_at, cmt.update_at, product.name 
        FROM cmt join product on cmt.id_prod = product.id"); 
        $stmt -> execute();
        while($cmt = $stmt->fetch()){
                // Assuming $yourDateString is the string date you have
                $dateTime = new DateTime($cmt[5]);
                
                // Now you can use date_format with $dateTime
                $formattedDate = date_format($dateTime, 'd/m/Y H:i:s');
                
                // Use $formattedDate as needed
                // Assuming $yourDateString is the string date you have
                $dateTime1 = new DateTime($cmt[4]);
                
                // Now you can use date_format with $dateTime
                $formattedDate1 = date_format($dateTime1, 'd/m/Y H:i:s');
                
                // Use $formattedDate as needed
            echo "<tr>
                <td>$cmt[0]</td>
                <td>$cmt[3]</td>
                <td><a href='../index.php?page=product&id_prod=$cmt[2]'>$cmt[6]</a></td>
                <td>$cmt[1]</td>
                <td>$formattedDate1</td>
                <td>$formattedDate</td>

                <td style='width:60px'>
                    <button class='btn btn-danger' onclick='deleteComment($cmt[0])'>Xóa</button>
                </td>

            </tr>";
        }
    ?>
    </tbody>
</table>
</div>

<script>
    function deleteComment(commentId) {
        if (confirm("Xác Nhận Xóa") == true) {
            $.ajax({
                url: "comment-delete.php", // Thay đổi đường dẫn nếu cần
                method: "POST",
                data: { id_delete: commentId },
                success: function (data) {
                    if (data) {
                        alert("Xóa Bình Luận Thành Công");
                        location.reload();
                    } else {
                        alert("Xóa Bình Luận Thất Bại");
                    }
                }
            });
        }
    }

</script>
