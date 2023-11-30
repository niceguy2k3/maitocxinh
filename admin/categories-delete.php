<?php
require "../config/config.php";
require "../model/conn.php";

// Xử lý yêu cầu xóa tạm thời
if (isset($_POST["id_delete"])) {
    $id = $_POST["id_delete"];
    $stmt = $conn->prepare("UPDATE categories SET deleted = 1 WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $stmt = $conn->prepare("UPDATE product SET deleted = 1 WHERE id_cate = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Tạm xóa thành công']);
} else if (isset($_POST["id_restore"])) {
    // Xử lý yêu cầu khôi phục
    $id = $_POST["id_restore"];
    $stmt = $conn->prepare("UPDATE categories SET deleted = 0 WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $stmt = $conn->prepare("UPDATE product SET deleted = 0 WHERE id_cate = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Khôi phục thành công']);
} else if (isset($_POST['id_delete_permanently'])) {
    
    // Xử lý yêu cầu xóa vĩnh viễn
    $idToDeletePermanently = $_POST['id_delete_permanently'];
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = :id");
    $stmt->bindParam(':id', $idToDeletePermanently);
    
    $success = $stmt->execute();
    echo json_encode(['success' => $success, 'message' => $success ? 'Xóa vĩnh viễn thành công' : 'Xóa vĩnh viễn thất bại']);
} else {
    echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ']);
}
?>

<script>
    function restoreCategory(id) {
        if (confirm("Xác Nhận Khôi Phục") == true) {
            $.ajax({
                url: "categories-delete.php",
                method: "POST",
                data: { id_restore: id },
                success: function (data) {
                    handleResponse(data);
                }
            });
        }
    }

    function deletePermanently(id) {
        if (confirm("Xác Nhận Xóa Vĩnh Viễn") == true) {
            $.ajax({
                url: "categories-delete.php",
                method: "POST",
                data: { id_delete_permanently: id },
                success: function (data) {
                    handleResponse(data);
                }
            });
        }
    }

    function handleResponse(data) {
        var parsedData = JSON.parse(data);
        if (parsedData.success) {
            alert(parsedData.message);
            location.reload();
        } else {
            alert(parsedData.message);
        }
    }
</script>