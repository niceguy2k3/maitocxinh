<?php
require '../config/config.php';
require '../model/conn.php';
$stmt = $conn->query("SELECT * FROM categories where deleted = 0");
?>
<div class="container">
    <h2 class="py-2 text-center h4">LOẠI HÀNG </h2> 
    <table class="table table-hover table-bordered">
        <thead class="thead-dark">
            <tr>
                <th><input type="checkbox" id="select-all"></th>
                <th>ID</th>
                <th>Tên Loại</th>
                <th>Số Thứ Tự</th>
                <th>Trạng Thái</th>
                <th>Danh Sách Sản Phẩm</th>
                <th>
                    <a class="btn btn-success" href="javascript:void(0);" id="hide-btn">Ẩn(<strong id="length">0</strong>)</a>
                    
                </th>
                <th>
                    <a class="btn btn-success" href="javascript:void(0);" id="show-btn">Hiện(<strong id="length">0</strong>)</a>
                </th>
            </tr>
        </thead>
        <style>
            #hide-btn, #show-btn, #delete-btn {
                display: none;
            }
        </style>
        <tbody>
            <?php while ($cate = $stmt->fetch()) : ?>
                <?php
                if ($cate["status"] == 0) {
                    $cate["status"] = "Ẩn";
                } else if ($cate["status"] == 1) {
                    $cate["status"] = "Hiện";
                }
                ?>
                <tr>
                    <td><input type='checkbox' class='category-checkbox' data-id='<?= $cate['id'] ?>'></td>
                    <td><?= $cate['id'] ?></td>
                    <td><?= $cate['name'] ?></td>
                    <td><?= $cate['stt'] ?></td>
                    <td><?= $cate['status'] ?></td>
                    <td><a href='admin.php?page=product&id_cate=<?= $cate['id'] ?>'>Xem Danh Sách Sản Phẩm</a></td>
                    <td style='width:60px'><a href='./categories-add.php?id=<?= $cate['id'] ?>'><button class='btn btn-warning'>Sửa</button></a></td>
                    <td style='width:60px'><button class='btn btn-danger delete-categories' data-id='<?= $cate['id'] ?>'>Xóa</button></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Nút "Thùng Rác" -->
<div class="trash-button-container">
    <a class="btn btn-success" href="admin.php?page=categories-trash">Thùng Rác</a>
</div>
<div class="add-button-container">
    <a class="btn btn-success" href="admin.php?page=categories-add">Thêm Mới</a>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<style>
    #hide-btn, #show-btn, #delete-btn {
        display: none;
    }

    .trash-button-container {
        position: fixed;
        bottom: 5px;
        right: 20px;
    }
    
  .add-button-container {
        position: fixed;
        bottom:5px;
        left:20px;
    }
</style>

<script>
    $(document).ready(function () {
        // Sự kiện change cho checkbox chọn tất cả
        $('#select-all').change(function () {
            var isChecked = $(this).prop('checked');
            $('.category-checkbox').prop('checked', isChecked);
            toggleButtonsVisibility();
        });

        // Sự kiện change cho các checkbox loại hàng
        $('.category-checkbox').change(function () {
            toggleButtonsVisibility();
        });

        // Hàm kiểm tra và điều chỉnh hiển thị nút "Ẩn" và "Hiện"
        function toggleButtonsVisibility() {
            var selectedCategories = $('.category-checkbox:checked');
            $("strong#length").text(selectedCategories.length);
            // Nếu có ít nhất một checkbox được chọn, hiển thị nút
            if (selectedCategories.length > 0) {
                $('#hide-btn, #show-btn, #delete-btn').show();
            } else {
                // Nếu không có checkbox nào được chọn, ẩn nút
                $('#hide-btn, #show-btn, #delete-btn').hide();
            }
        }

        // Hàm xử lý sự kiện khi click vào nút "Ẩn"
        $('#hide-btn').click(function () {
            hideCategories();
        });

        // Hàm xử lý sự kiện khi click vào nút "Hiện"
        $('#show-btn').click(function () {
            showCategories();
        });

        // Hàm ẩn loại hàng
        function hideCategories() {
            var selectedCategories = $('.category-checkbox:checked');
            changeCategoryStatus(selectedCategories, 0); // Thay đổi status thành 0 (Ẩn)
        }

        // Hàm hiện loại hàng
        function showCategories() {
            var selectedCategories = $('.category-checkbox:checked');
            changeCategoryStatus(selectedCategories, 1); // Thay đổi status thành 1 (Hiện)
        }

        // Hàm thay đổi trạng thái của loại hàng
        function changeCategoryStatus(categories, status) {
            var ids = categories.map(function () {
                return $(this).data('id');
            }).get();

            $.ajax({
                url: "categories-status.php",
                method: "POST",
                data: { ids: ids, status: status },
                success: function (data) {
                    alert(data); // Hiển thị thông báo từ server
                    location.reload(); // Tải lại trang sau khi thay đổi
                }
            });
        }

        // Sự kiện click cho nút "Xóa"
        $('.delete-categories').click(function () {
            var categoryId = $(this).data('id');
            deleteCategory(categoryId);
        });

        function deleteCategory(id) {
            if (confirm("Xác Nhận Xóa")) {
                $.ajax({
                    url: "categories-delete.php",
                    method: "POST",
                    data: { id_delete: id },
                    success: function (data) {
                        if (data) {
                            alert("Xóa Thành Công");
                            location.reload();
                        } else {
                            alert("Xóa Thất Bại");
                        }
                    }
                });
            }
        }
    });
</script>
