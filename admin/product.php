<div class="container">
    <h2 class="py-2 text-center h4">SẢN PHẨM</h2>
    <div class="form-group">
        <label for="search">Tìm Kiếm:</label>
        <input type="text" class="form-control" id="search" placeholder="Nhập tên sản phẩm">
    </div>

    <table class="table table-hover table-bordered">
        <thead class="thead-dark">
            <tr>
                <th><input type="checkbox" id="select-all" onchange="toggleSelectAll()"></th>
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
                <th>Trạng Thái</th>

                <th>
                    <button class="btn btn-success" id="hide-btn" onclick="hideProducts()" style="display: none;">Ẩn</button>
                </th>
                <th>
                    <button class="btn btn-success" id="show-btn" onclick="showProducts()" style="display: none;">Hiện</button>
                </th>

            </tr>
        </thead>
        <tbody>
            <?php
            require '../config/config.php';
            require '../model/conn.php';

            // Xử lý các điều kiện lọc
            $id_cate = "";
            $search = "";

            if (isset($_REQUEST['id_cate'])) {
                $id_cate = "AND id_cate = " . $_REQUEST['id_cate'];
            }

            if (isset($_REQUEST['search'])) {
                $searchTerm = $_REQUEST['search'];
                $search = "AND (product.name LIKE '%$searchTerm%' OR categories.name LIKE '%$searchTerm%')";
            }

            // Truy vấn từ cơ sở dữ liệu
            $stmt = $conn->query("SELECT * FROM product JOIN categories ON product.id_cate = categories.id WHERE product.deleted = 0 $id_cate $search ORDER BY product.id");

            while ($prod = $stmt->fetch()) {
                $status = ($prod["11"] == 0) ? "Ẩn" : "Hiện";
                $formattedPrice = number_format($prod["price"], 0, ",", ".");
                $formattedDiscount = number_format($prod["discount"], 0, ",", ".");
                                // Assuming $yourDateString is the string date you have
                $dateTime = new DateTime($prod[update_at]);
                
                // Now you can use date_format with $dateTime
                $formattedDate = date_format($dateTime, 'd/m/Y H:i:s');
                
                // Use $formattedDate as needed
                echo "<tr>
                    <td><input type='checkbox' class='product-checkbox' data-id='$prod[0]'></td>
                    <td>$prod[0]</td>
                    <td><a href='../index.php?page=product&id_prod=$prod[0]'>$prod[1]</a></td>
                    <td>$formattedPrice</td>
                    <td>$formattedDiscount</td>
                    <td><img src='../uploads_product/$prod[img]' style='width: 70px; height: 70px;' alt=''></td>

                    <td></td>
                    <td>$prod[view]</td>
                    <td>$prod[13]</td>
                    <td>$prod[create_at]</td>
                    <td>$formattedDate</td>
                    <td>$status</td>
                    <td style='width:60px'><a href='./product-add.php?id=$prod[0]'><button class='btn btn-warning'>Sửa</button></a></td>
                    <td style='width:60px'><button class='btn btn-danger' onclick='deleteProduct($prod[0])'>Xóa</button></td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Nút "Thùng Rác" -->
<div class="trash-button-container">
    <a class="btn btn-success" href="admin.php?page=product-trash">Thùng Rác</a>
</div>
<div class="add-button-container">
    <a class="btn btn-success" href="admin.php?page=product-add">Thêm Mới</a>
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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function toggleSelectAll() {
        var isChecked = $('#select-all').prop('checked');
        $('.product-checkbox').prop('checked', isChecked);
        toggleButtonsVisibility();
    }

    function toggleButtonsVisibility() {
        var selectedProducts = $('.product-checkbox:checked');

        if (selectedProducts.length > 0) {
            $('#hide-btn, #show-btn, #delete-btn').show();
        } else {
            $('#hide-btn, #show-btn, #delete-btn').hide();
        }
    }

    function hideProducts() {
        var selectedProducts = $('.product-checkbox:checked');
        var productIds = $.map(selectedProducts, function (el) {
            return $(el).data('id');
        });

        if (productIds.length > 0) {
            changeProductStatus(productIds, 0); // Thay đổi status thành 0 (Ẩn)
        }
    }

    function showProducts() {
        var selectedProducts = $('.product-checkbox:checked');
        var productIds = $.map(selectedProducts, function (el) {
            return $(el).data('id');
        });

        if (productIds.length > 0) {
            changeProductStatus(productIds, 1); // Thay đổi status thành 1 (Hiện)
        }
    }

    function deleteSelectedProducts() {
        var selectedProducts = $('.product-checkbox:checked');
        var confirmDelete = confirm("Xác Nhận Xóa");

        if (confirmDelete) {
            var productIds = $.map(selectedProducts, function (el) {
                return $(el).data('id');
            });

            if (productIds.length > 0) {
                changeProductStatus(productIds, -1); // Thay đổi status thành -1 (Xóa)
            }
        }
    }

    function deleteProduct(id) {
        if (confirm("Xác Nhận Xóa")) {
            $.ajax({
                url: "product-delete.php",
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

    $(document).ready(function () {
        $('#search').on('input', function () {
            filterProducts($(this).val().toLowerCase());
        });

        function filterProducts(searchTerm) {
            $('tbody tr').each(function () {
                var productName = $(this).find('td:eq(2)').text().toLowerCase();
                if (productName.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            toggleButtonsVisibility();
        }

        $('.product-checkbox').change(function () {
            toggleButtonsVisibility();
        });
    });

    function toggleButtonsVisibility() {
        var selectedProducts = $('.product-checkbox:checked');

        if (selectedProducts.length > 0) {
            $('#hide-btn, #show-btn, #delete-btn').show();
        } else {
            $('#hide-btn, #show-btn, #delete-btn').hide();
        }
    }
function changeProductStatus(productIds, status) {
    $.ajax({
        url: "product-status.php",
        method: "POST",
        data: { ids: productIds, status: status },
        success: function (data) {
            alert(data); // Hiển thị thông báo từ server
            location.reload(); // Tải lại trang sau khi thay đổi
        }
    });
}

</script>
