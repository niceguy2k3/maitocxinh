<?php
    if(isset($_REQUEST['id_post_cate'])){
        $id_cate = "and post_categories.id = " . "".$_REQUEST['id_post_cate']."";
    }else{
        $id_cate = "";
    }
?>
<div class="container">
    <h2 class="py-2 text-center h4 ">THÙNG RÁC BÀI VIẾT</h2>
    <a class="btn btn-warning" href="javascript:void(0);" id="restore-all-btn">Khôi Phục(<strong id="length">0</strong>)</a>
    <a class="btn btn-danger" href="javascript:void(0);" id="delete-all-btn">Xóa(<strong id="length">0</strong>)</a>
    <table class="table table-hover table-bordered">
    <thead  class="thead-dark" >
        <tr>
            <th style="text-align: center;"><input type="checkbox" id="checkbox-all" ></th>
            <th>ID</th>
            <th>Tên</th>
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
        $stmt = $conn -> query("SELECT * FROM post join post_categories where post.id_cate = post_categories.id $id_cate AND post.deleted = 1 order by post.id"); 
        while($blog = $stmt->fetch()){
            if($blog[15] == 1){
                $disabled= "disabled";
            }else{
                $disabled= "";
            }
            echo "<tr>
                <td style='text-align: center;'><input class='checkbox' type='checkbox' name='checkbox-id[]' value='".$blog[0]."'></td>
                <td>$blog[0]</td>
                <td><a href = '../index.php?page=blog-details&id_blog=$blog[0]'>$blog[1]</a></td>
                <td><img src='../uploads_blog/$blog[img]' style='width: 70px; height: 70px;' alt=''></td>
                <td>$blog[meta_description]</td>
                <td>$blog[view]</td>
                <td>$blog[10]</td>
                <td>$blog[create_at]</td>
                <td>$blog[update_at]</td>
                <td style='width:60px'><button class='btn btn-warning' $disabled onclick='restoreBlog($blog[0])'>Khôi Phục</button></td>
                <td style='width:60px'><button class='btn btn-danger' onclick='restoreBlog($blog[0])'>Xóa Vĩnh Viễn</button></td>
            </tr>";
        }
    ?>
    </tbody>
</table>
</div>
<script>
    $(document).ready(function(){
        $("#checkbox-all").change(function(){
            $(".checkbox").prop("checked", this.checked);
            toggleButtonsVisibility();
        })
        $('.checkbox').change(function () {
            toggleButtonsVisibility();
        });
        function toggleButtonsVisibility() {
            var checkboxLength = $('.checkbox').length
            var selectedCategories = $('.checkbox:checked');
            $("strong#length").text(selectedCategories.length);
            // Nếu có ít nhất một checkbox được chọn, hiển thị nút
            if (selectedCategories.length >= 0 & selectedCategories.length < checkboxLength) {
                
                $("#checkbox-all").prop("checked", false);
            } else {
                $("#checkbox-all").prop("checked", true);
                
            }
        }
        $("#restore-all-btn").click(function(){
            if (confirm("Xác Nhận Khôi Phục") == true) {
                var id = [];
                $('.checkbox:checked').each(function(i){
                    id[i] = $(this).val();
                });
                id.forEach(element => {
                    console.log(element);
                });
                if (id.length === 0) {
                    alert("Hãy Chọn Ít Nhất Một Sản Phẩm");
                }else{
                    $.ajax({
                        url: "blog-delete.php",
                        method: "POST",
                        data: {id_restore_all:id},
                        success:function(data){
                            if (data) {
                                alert("Đã Khôi Phục Các Sản Phẩm Đã Chọn Và Những Sản Phẩm Liên Quan")
                                location.reload();
                            }else{
                                alert("Khôi Phục Thất Bại")
                            }
                            
                        }
                    })
                }
                // var something = $('.checkbox:checked').attr('name');
                // alert(something);
            }
        })

        
    })
    function restoreBlog(id) {
        if (confirm("Xác Nhận Khôi Phục") == true) {
            $(document).ready(function(){
            $.ajax({
                url: "blog-delete.php",
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
</script>
