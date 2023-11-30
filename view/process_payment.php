<?php
$amount = $_POST['amount'];
$order_desc = $_POST['order_desc'];
$email = $_POST['email'];
$phone = $_POST['phone'];

$merchant_code = 'ENK7PXF0';
$access_code = ''; // Bạn không cần sử dụng access code trong trường hợp này
$secure_secret = 'ZBSKWDHZHTWKDCHZWNFXGKUIYNLDXVMY';

$order_id = uniqid();
$return_url = 'URL trả về sau khi thanh toán thành công'; // Thay thế URL thực tế của bạn

$vnp_url = 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
$vnp_params = array(
    'vnp_Version' => '2.0.0',
    'vnp_TmnCode' => $merchant_code,
    'vnp_Amount' => $amount * 100,
    'vnp_Command' => 'pay',
    'vnp_CreateDate' => date('YmdHis'),
    'vnp_CurrCode' => 'VND',
    'vnp_OrderInfo' => $order_desc,
    'vnp_OrderType' => 'billpayment',
    'vnp_ReturnUrl' => $return_url,
    'vnp_TxnRef' => $order_id,
    'vnp_IpAddr' => $_SERVER['REMOTE_ADDR'],
    'vnp_CreateDate' => date('YmdHis'),
);

ksort($vnp_params);

$query = '';
foreach ($vnp_params as $key => $value) {
    $query .= '&' . urlencode($key) . '=' . urlencode($value);
}
$vnp_Url = $vnp_url . '?' . $query . '&vnp_SecureHashType=SHA256&vnp_SecureHash=' . hash('sha256', $secure_secret . $query);

header('Location: ' . $vnp_Url);
exit();
?>
