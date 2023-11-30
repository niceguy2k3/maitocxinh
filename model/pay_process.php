<?php
session_start();
ob_start();

require '../config/config.php';
require 'conn.php';
    if (isset($_POST['order_button'])) {
        $id_user = $_POST['id_user']??"";
        $name_user = $_POST['name_user'];
        $email = $_POST['email'];
        $sdt = $_POST['SDT'];
        if (isset($_POST['city'])) {
            $stmt = $conn -> prepare("SELECT * FROM devvn_tinhthanhpho WHERE matp = ".$_POST['city']."");
            $stmt->execute();
            $adr = $stmt->fetch();
            $city = $adr[1];
        }
        if (isset($_POST['district'])) {
            $stmt = $conn -> prepare("SELECT * FROM devvn_quanhuyen WHERE maqh = ".$_POST['district']."");
            $stmt->execute();
            $adr = $stmt->fetch();
            $district = $adr[1];
        }
        if (isset($_POST['ward'])) {
            $stmt = $conn -> prepare("SELECT * FROM devvn_xaphuongthitran WHERE xaid = ".$_POST['ward']."");
            $stmt->execute();
            $adr = $stmt->fetch();
            $ward = $adr[1];
        }
        $address = $_POST['address'];
        $final_address = $address. ", " .$ward .", " .$district .", " .$city;
        $note = $_POST['note']??"";
        
        $stmt = $conn -> prepare("INSERT INTO orders(id_user, name, email, phone, address, note, order_date, status)
        VALUES ('$id_user', '$name_user', '$email', '$sdt', '$final_address', '$note',  CURRENT_TIMESTAMP, 1)");
        $stmt -> execute();

        $stmt = $conn -> prepare("SELECT id from orders ORDER BY id DESC");
        $stmt -> execute();
        $id_order = $stmt -> fetch();

        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $value) {
                $total_money = $value[3]*$value[4];
                $stmt = $conn -> prepare("INSERT INTO order_details(id_order, id_prod, name_prod, price, quantity, total_money)
                VALUES ($id_order[0], $value[0], '$value[1]', $value[3], $value[4], $total_money)");
                $stmt -> execute();
            }
        }
        
        // tạo session sản phẩm liên quan để gợi ý sản phẩm trang thanks 
        $_SESSION['splq'] = [];
        $_SESSION['afterpay'] = [];
        if (isset($_SESSION['cart'])) {
            $dieukien = "AND ";
            foreach ($_SESSION['cart'] as $value) {
                $dieukien .= "id = " .  $value[0] . " OR ";
                array_push($_SESSION['afterpay'], $value);
            }
            // câu lệnh xuất id_cate liên quan đến sản phẩm đã mua
            $stmt = $conn -> prepare("SELECT id_cate from product WHERE deleted = 0 AND status = 1 $dieukien id = RAND() GROUP BY id_cate");
            $stmt -> execute();
            while($id_cate = $stmt -> fetch()){
                echo $id_cate[0] . "<br>";
                array_push($_SESSION['splq'], $id_cate[0]);
            }
                
        }
        
        var_dump($_SESSION['cart']);
        var_dump($_SESSION['splq']);
        
        
        $_SESSION['cart'] = [];

        $_SESSION['thanks'] = 1;

        // header('Location: ../index.php?page=thanks'); /*die()*/;

        echo $id_user ."<br>";
        echo $name_user ."<br>";
        echo $email ."<br>";
        echo $sdt ."<br>";
        echo $final_address;
        echo $note ."<br>";
        echo $total_money ."<br>";
        
        if(isset($_POST['payment'])){
            if($_POST['payment'] == "vnpay"){
                error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                
                $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
                $vnp_Returnurl = "https://maitocxinh.id.vn?page=thanks";
                $vnp_TmnCode = "ENK7PXF0";//Mã website tại VNPAY 
                $vnp_HashSecret = "ZBSKWDHZHTWKDCHZWNFXGKUIYNLDXVMY"; //Chuỗi bí mật
                
                $vnp_TxnRef = rand(00,9999); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
                $vnp_OrderInfo = 'Noi dung thanh toan';
                $vnp_OrderType = 'billpayment';
                $vnp_Amount = $total_money * 100;
                $vnp_Locale = 'vn';
                $vnp_BankCode = '';
                $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
                //Add Params of 2.0.1 Version
                // $vnp_ExpireDate = $_POST['txtexpire']; //thời gian thanh toán cộng thêm 15 so với hiện tại
                //Billing
                // $vnp_Bill_Mobile = $_POST['txt_billing_mobile'];
                // $vnp_Bill_Email = $_POST['txt_billing_email'];
                // $fullName = trim($_POST['txt_billing_fullname']);
                // if (isset($fullName) && trim($fullName) != '') {
                //     $name = explode(' ', $fullName);
                //     $vnp_Bill_FirstName = array_shift($name);
                //     $vnp_Bill_LastName = array_pop($name);
                // }
                // $vnp_Bill_Address=$_POST['txt_inv_addr1'];
                // $vnp_Bill_City=$_POST['txt_bill_city'];
                // $vnp_Bill_Country=$_POST['txt_bill_country'];
                // $vnp_Bill_State=$_POST['txt_bill_state'];
                // // Invoice
                // $vnp_Inv_Phone=$_POST['txt_inv_mobile'];
                // $vnp_Inv_Email=$_POST['txt_inv_email'];
                // $vnp_Inv_Customer=$_POST['txt_inv_customer'];
                // $vnp_Inv_Address=$_POST['txt_inv_addr1'];
                // $vnp_Inv_Company=$_POST['txt_inv_company'];
                // $vnp_Inv_Taxcode=$_POST['txt_inv_taxcode'];
                // $vnp_Inv_Type=$_POST['cbo_inv_type'];
                $inputData = array(
                    "vnp_Version" => "2.1.0",
                    "vnp_TmnCode" => $vnp_TmnCode,
                    "vnp_Amount" => $vnp_Amount,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $vnp_IpAddr,
                    "vnp_Locale" => $vnp_Locale,
                    "vnp_OrderInfo" => $vnp_OrderInfo,
                    "vnp_OrderType" => $vnp_OrderType,
                    "vnp_ReturnUrl" => $vnp_Returnurl,
                    "vnp_TxnRef" => $vnp_TxnRef,
                    // "vnp_ExpireDate"=>$vnp_ExpireDate,
                    // "vnp_Bill_Mobile"=>$vnp_Bill_Mobile,
                    // "vnp_Bill_Email"=>$vnp_Bill_Email,
                    // "vnp_Bill_FirstName"=>$vnp_Bill_FirstName,
                    // "vnp_Bill_LastName"=>$vnp_Bill_LastName,
                    // "vnp_Bill_Address"=>$vnp_Bill_Address,
                    // "vnp_Bill_City"=>$vnp_Bill_City,
                    // "vnp_Bill_Country"=>$vnp_Bill_Country,
                    // "vnp_Inv_Phone"=>$vnp_Inv_Phone,
                    // "vnp_Inv_Email"=>$vnp_Inv_Email,
                    // "vnp_Inv_Customer"=>$vnp_Inv_Customer,
                    // "vnp_Inv_Address"=>$vnp_Inv_Address,
                    // "vnp_Inv_Company"=>$vnp_Inv_Company,
                    // "vnp_Inv_Taxcode"=>$vnp_Inv_Taxcode,
                    // "vnp_Inv_Type"=>$vnp_Inv_Type
                );
                
                if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                    $inputData['vnp_BankCode'] = $vnp_BankCode;
                }
                if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
                    $inputData['vnp_Bill_State'] = $vnp_Bill_State;
                }
                
                //var_dump($inputData);
                ksort($inputData);
                $query = "";
                $i = 0;
                $hashdata = "";
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                    } else {
                        $hashdata .= urlencode($key) . "=" . urlencode($value);
                        $i = 1;
                    }
                    $query .= urlencode($key) . "=" . urlencode($value) . '&';
                }
                
                $vnp_Url = $vnp_Url . "?" . $query;
                if (isset($vnp_HashSecret)) {
                    $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
                    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                }
                $returnData = array('code' => '00'
                    , 'message' => 'success'
                    , 'data' => $vnp_Url);
                    if (isset($_POST['payment'])) {
                        header('Location: ' . $vnp_Url);
                        die();
                    } else {
                        echo json_encode($returnData);
                    }
                	// vui lòng tham khảo thêm tại code demo
            }else if($_POST['payment'] == "ship_cod"){
                header("location: ../index.php?page=thanks");
            }
        }
    }else{
        echo "Sao k bấm button?";
    }
?>