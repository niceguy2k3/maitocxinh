<?php
    require '../config/config.php';
    require '../model/conn.php';

    if (isset($_POST['id_delete'])) {
        $commentId = $_POST['id_delete'];

        // Thực hiện truy vấn xóa bình luận dựa trên $commentId
        $stmt = $conn->prepare("DELETE FROM cmt WHERE id = ?");
        $stmt->execute([$commentId]);

        // Kiểm tra và trả về kết quả
        if ($stmt->rowCount() > 0) {
            echo "true"; // Xóa thành công
        } else {
            echo "false"; // Xóa thất bại
        }
    } else {
        echo "false"; // Nếu không có id_delete được gửi, coi như xóa thất bại
    }
?>
