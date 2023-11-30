<?php
    if(isset($_REQUEST['id_post_cate'])){
        $id_cate = "and post_categories.id = " . "".$_REQUEST['id_post_cate']."";
    }else{
        $id_cate = "";
    }
?>
<div class="container">
    <h2 class="py-2 text-center h4 ">BÀI VIẾT</h2>
    <a class="btn btn-success" href="./blog-add.php">Thêm Mới</a>
    <a class="btn btn-success" href="admin.php?page=blog-trash">Thùng Rác</a>
    <a class="btn btn-success" href="javascript:void(0);" id="show-btn">Hiện(<strong id="length">0</strong>)</a>
    <a class="btn btn-success" href="javascript:void(0);" id="hide-btn">Ẩn(<strong id="length">0</strong>)</a>
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
            <th>Trạng Thái</th>
            <th>

            </th>
            <th>

            </th>
        </tr>
        
    </thead>
    <tbody>
    <?php
        require '../config/config.php';
        require '../model/conn.php';
        $stmt = $conn -> query("SELECT * FROM post join post_categories where post.id_cate = post_categories.id $id_cate AND post.deleted = 0 order by post.id"); 
        while($blog = $stmt->fetch()){
            if($blog["10"] == 0){
                $blog["10"] = "Ẩn";
            }else if($blog["10"] == 1){
                $blog["10"] = "Hiện";
            }
                // Assuming $yourDateString is the string date you have
                $dateTime1 = new DateTime($$blog[create_at]);
                
                // Now you can use date_format with $dateTime
                $formattedDate1 = date_format($dateTime1, 'd/m/Y H:i:s');
                
                // Use $formattedDate as needed
                                // Assuming $yourDateString is the string date you have
                $dateTime = new DateTime($blog[update_at]);
                
                // Now you can use date_format with $dateTime
                $formattedDate = date_format($dateTime, 'd/m/Y H:i:s');
                
                // Use $formattedDate as needed
            echo "<tr>
                <td style='text-align: center;'><input class='checkbox' type='checkbox' name='checkbox-id[]' value='".$blog[0]."'></td>
                <td>$blog[0]</td>
                <td><a href = '../index.php?page=blog-details&id_blog=$blog[0]'>$blog[1]</a></td>
                <td><img src='../uploads_blog/$blog[img]' style='width: 70px; height: 70px;' alt=''></td>
                <td>$blog[meta_description]</td>
                <td>$blog[view]</td>
                <td>$blog[12]</td>
                <td>$formattedDate1</td>
                <td>$formattedDate</td>
                <td>$blog[10]</td>
                <td style='width:60px'><a href='./blog-add.php?id=$blog[0]'><button class='btn btn-warning'>Sửa</button></a></td>
                <td style='width:60px'><button class='btn btn-danger' onclick='deleteBlog($blog[0])'>Xóa</button></td>
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
        $("#show-btn").click(function(){
            if (confirm("Xác Nhận Hiện") == true) {
                var id = [];
                $('.checkbox:checked').each(function(i){
                    id[i] = $(this).val();
                });
                id.forEach(element => {
                    console.log(element);
                });
                if (id.length === 0) {
                    alert("Hãy Chọn Ít Nhất Một Mục");
                }else{
                    $.ajax({
                        url: "blog-status.php",
                        method: "POST",
                        data: {id_show:id},
                        success:function(data){
                            if (data) {
                                alert("Đã Hiện Các Sản Phẩm Đã Chọn Và Những Sản Phẩm Liên Quan")
                                location.reload();
                            }else{
                                alert("Hiện Thất Bại")
                            }
                            
                        }
                    })
                }
                // var something = $('.checkbox:checked').attr('name');
                // alert(something);
            }
        })
        $("#hide-btn").click(function(){
            if (confirm("Xác Nhận Ẩn") == true) {
                var id = [];
                $('.checkbox:checked').each(function(i){
                    id[i] = $(this).val();
                });
                id.forEach(element => {
                    console.log(element);
                });
                if (id.length === 0) {
                    alert("Hãy Chọn Ít Nhất Một Mục");
                }else{
                    $.ajax({
                        url: "blog-status.php",
                        method: "POST",
                        data: {id_hide:id},
                        success:function(data){
                            if (data) {
                                alert("Đã Ẩn Các Sản Phẩm Đã Chọn Và Những Sản Phẩm Liên Quan")
                            location.reload();
                            }else{
                                alert("Ẩn Thất Bại")
                            }
                            
                        }
                    })
                }
                // var something = $('.checkbox:checked').attr('name');
                // alert(something);
            }
        })

        $("#delete-all-btn").click(function(){
            if (confirm("Xác Nhận Xóa") == true) {
                var id = [];
                $('.checkbox:checked').each(function(i){
                    id[i] = $(this).val();
                });
                id.forEach(element => {
                    console.log(element);
                });
                if (id.length === 0) {
                    alert("Hãy Chọn Ít Nhất Một Mục");
                }else{
                    $.ajax({
                        url: "blog-delete.php",
                        method: "POST",
                        data: {id_delete_all:id},
                        
                        success:function(data){
                            if (data) {
                                alert("Đã Xóa Các Sản Phẩm Đã Chọn")
                                location.reload();
                            }else{
                                alert("Xóa Thất Bại")
                            }
                            
                        }
                    })
                }
                // var something = $('.checkbox:checked').attr('name');
                // alert(something);
            }
        })
    })
    function deleteBlog(id) {
        if (confirm("Xác Nhận Xóa") == true) {
            $(document).ready(function(){
            $.ajax({
                url: "blog-delete.php",
                method: "POST",
                data:{id_delete:id},
                success:function(data){
                    if (data) {
                        alert("Xóa Thành Công");
                        location.reload();
                    }else{
                        alert("Xóa Thất Bại")
                    }
                }
            });
        })
        }
        
    }
</script>