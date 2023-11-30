<?php
$vnp_response = $_GET['vnp_ResponseCode'];
$vnp_txn_ref = $_GET['vnp_TxnRef'];

if ($vnp_response == '00') {
    echo 'Thanh toán thành công. Mã đơn hàng: ' . $vnp_txn_ref;
    // Cập nhật trạng thái đơn hàng trong cơ sở dữ liệu của bạn
} else {
    echo 'Thanh toán không thành công. Mã đơn hàng: ' . $vnp_txn_ref;
    // Xử lý khi thanh toán không thành công
}
?>
