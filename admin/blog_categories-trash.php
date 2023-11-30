<div class="container">
    <h2 class="py-2 text-center h4 ">THÙNG RÁC LOẠI BÀI VIẾT</h2>
    <a class="btn btn-warning" href="javascript:void(0);" id="restore-all-btn">Khôi Phục(<strong id="length">0</strong>)</a>
    <a class="btn btn-danger" href="javascript:void(0);" id="delete-all-btn">Xóa(<strong id="length">0</strong>)</a>

    <table class="table table-hover table-bordered">
    <thead  class="thead-dark" >
        <tr>
            <th style="text-align: center;"><input type="checkbox" id="checkbox-all" ></th>
            <th>ID</th>
            <th>Tên Loại</th>
            <th>Số Thứ Tự</th>
            <th>Trạng Thái</th>
            <th>Danh Sách Bài Viết</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
    <?php
        require '../config/config.php';
        require '../model/conn.php';
        $stmt = $conn -> query("SELECT * FROM post_categories WHERE deleted = 1"); 
        while($blog_cate = $stmt->fetch()){
            // if($item['lang']=='vi') $lang='Vietnamse'; else $lang='English';
            if($blog_cate["status"] == 0){
                $blog_cate["status"] = "Ẩn";
            }else if($blog_cate["status"] == 1){
                $blog_cate["status"] = "hiện";
            }
            
            echo "<tr>
            <td style='text-align: center;'><input class='checkbox' type='checkbox' name='checkbox-id[]' value='".$blog_cate['id']."'></td>
                <td>$blog_cate[id]</td>
                <td>$blog_cate[name]</td>
                <td>$blog_cate[stt]</td>
                <td>$blog_cate[status]</td>
                <td><a href='admin.php?page=blog&id_post_cate=$blog_cate[id]'>Xem Danh Sách Bài Viết</a></td>
                <td style='width:60px'><button class='btn btn-warning' onclick='restoreCategory($blog_cate[id])'>Khôi Phục</button></td>
                <td style='width:60px'><button class='btn btn-danger' onclick='deleteCT($blog_cate[id])'>Xóa Vĩnh Viễn</button></td>
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
                    alert("Hãy Chọn Ít Nhất Một Mục");
                }else{
                    $.ajax({
                        url: "blog_categories-delete.php",
                        method: "POST",
                        data: {id_restore_all:id},
                        success:function(data){
                            if (data) {
                                alert("Đã Khôi Phục Danh Mục Đã Chọn Và Những Sản Phẩm Liên Quan")
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
    function restoreCategory(id) {
        if (confirm("Xác Nhận Khôi Phục") == true) {
            $(document).ready(function(){
            $.ajax({
                url: "blog_categories-delete.php",
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