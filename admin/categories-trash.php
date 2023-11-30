<div class="container">
    <h2 class="py-2 text-center h4 ">THÙNG RÁC LOẠI HÀNG</h2>
    <table class="table table-hover table-bordered">
    <thead  class="thead-dark" >
        <tr>
            <th>ID</th>
            <th>Tên Loại</th>
            <th>Số Thứ Tự</th>
            <th>Trạng Thái</th>
            <th>Danh Sách Sản Phẩm</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
    <?php
        require '../config/config.php';
        require '../model/conn.php';
        $stmt = $conn -> query("SELECT * FROM categories where deleted = 1"); 
        while($cate = $stmt->fetch()){
            // if($item['lang']=='vi') $lang='Vietnamse'; else $lang='English';
            if($cate["status"] == 0){
                $cate["status"] = "Ẩn";
            }else if($cate["status"] == 1){
                $cate["status"] = "hiện";
            }
            
            echo "<tr>
                <td id='id'>$cate[id]</td>
                <td>$cate[name]</td>
                <td>$cate[stt]</td>
                <td>$cate[status]</td>
                <td><a href='admin.php?page=product&id_cate=$cate[id]'>Xem Danh Sách Sản Phẩm</a></td>
                <td style='width:130px'><button class='btn btn-warning' onclick='restoreCategory($cate[id])'>Khôi Phục</button></td>
               <td style='width:150px'><button class='btn btn-danger' onclick='deletePermanently($cate[id])'>Xóa Vĩnh Viễn</button></td>

            </tr>";
        }
            
        
    ?>
    </tbody>
</table>
</div>
<script>
    function restoreCategory(id) {
        if (confirm("Xác Nhận Khôi Phục") == true) {
            $(document).ready(function(){
            $.ajax({
                url: "categories-delete.php",
                method: "POST",
                data:{id_restore:id},
                success:function(data){
                    if (data) {
                        alert("Khôi Phục Thành Công");
                        location.reload()
                    }else{
                        alert("Khôi Phục Thất Bại")
                    }
                }
               
            });
        })
        }
    }
    function deletePermanently(id) {
    if (confirm("Xác Nhận Xóa Vĩnh Viễn") == true) {
        $(document).ready(function(){
            $.ajax({
                url: "categories-delete.php",
                method: "POST",
                data: { id_delete_permanently: id },
                success: function(data) {
                    if (data) {
                        alert("Xóa Vĩnh Viễn Thành Công");
                        location.reload();
                    } else {
                        alert("Xóa Vĩnh Viễn Thất Bại");
                    }
                }
            });
        });
    }
}
</script>