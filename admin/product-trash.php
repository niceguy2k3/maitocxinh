<?php
    if(isset($_REQUEST['id_cate'])){
        $id_cate = "and id_cate = " . "".$_REQUEST['id_cate']."";
    }else{
        $id_cate = "";
    }
?>
<div class="container">
    <h2 class="py-2 text-center h4 ">THÙNG RÁC SẢN PHẨM</h2>
    <table class="table table-hover table-bordered">
    <thead  class="thead-dark" >
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Giá</th>
            <th>Giảm Giá</th>
            <th>Hình ảnh</th>
            <th>Mô Tả</th>
            <th>Lượt Xem</th>
            <th>Tên Loại</th>
            <th>Ngày Tạo</th>
            <th>Ngày Cập Nhật</th>
            <th colspan="2"></th>
        </tr>
        
    </thead>
    <tbody>
    <?php
        require '../config/config.php';
        require '../model/conn.php';
        $stmt = $conn -> query("SELECT * FROM product join categories where product.id_cate = categories.id $id_cate AND product.deleted = 1 order by product.id"); 
        while($prod = $stmt->fetch()){
            if($prod[16] == 1){
                $disabled= "disabled";
            }else{
                $disabled= "";
            }
            echo "<tr>
                <td>$prod[0]</td>
                <td><a href = '../index.php?page=product&id_prod=$prod[0]'>$prod[1]</a></td>
                <td>".number_format($prod["price"], 0, "," , ".")."</td>
                <td>".number_format($prod["discount"], 0, "," , ".")."</td>
                <td><img src='../uploads_product/$prod[img]' style='width: 70px; height: 70px;' alt=''></td>
                <td></td>
                <td>$prod[view]</td>
                <td>$prod[12]</td>
                <td>$prod[create_at]</td>
                <td>$prod[update_at]</td>
                <td style='width:130px'><button class='btn btn-warning' $disabled onclick='restoreProduct($prod[0])'>Khôi Phục</button></td>
                <td style='width:150px'><button class='btn btn-danger' onclick='restoreCategory($prod[0])'>Xóa Vĩnh Viễn</button></td>
            </tr>";
        }
    ?>
    </tbody>
</table>
</div>
<script>
    function restoreProduct(id) {
        if (confirm("Xác Nhận Khôi Phục") == true) {
            $(document).ready(function(){
            $.ajax({
                url: "product-delete.php",
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
    function deleteProduct(id) {
        if (confirm("Xác Nhận Xóa Vĩnh Viễn") == true) {
            $(document).ready(function(){
                $.ajax({
                    url: "product-delete-permanent.php",
                    method: "POST",
                    data: {id_delete: id},
                    success: function(data){
                        if (data === "success") {
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