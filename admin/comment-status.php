<?php
require '../config/config.php';
require '../model/conn.php';

if (isset($_POST['ids']) && isset($_POST['status'])) {
    $commentIds = $_POST['ids'];
    $status = $_POST['status'];

    // Thực hiện truy vấn thay đổi trạng thái của bình luận
    $stmt = $conn->prepare("UPDATE cmt SET status = ? WHERE id IN (" . implode(',', $commentIds) . ")");
    $stmt->execute([$status]);

    // Kiểm tra và trả về kết quả
    if ($stmt->rowCount() > 0) {
        echo "true"; // Thay đổi trạng thái thành công
    } else {
        echo "false"; // Thay đổi trạng thái thất bại
    }
} else {
    echo "false"; // Nếu không có ids hoặc status, coi như thay đổi trạng thái thất bại
}
?>
