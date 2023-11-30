<?php
    // var_dump($_SESSION['cart']);
    if(isset($_POST['minus'])){
        $stt = $_POST['stt'];
        $qty = $_POST['qty'];
        if ($qty>1) {
            $_SESSION['cart'][$stt][4] = $qty-1;
        }else{
            array_splice($_SESSION['cart'],$stt,1);
            
            header("location: index.php?page=cart");
        }
    }
    if(isset($_POST['plus'])){
        $stt = $_POST['stt'];
        $qty = $_POST['qty'];
        $_SESSION['cart'][$stt][4] = $qty+1;
    }
    // if(isset($_POST['delete_prod'])){
    //     $stt = $_POST['stt'];
    //     // array_splice($_SESSION['cart'],$stt,1);
    //     // header("location: index.php?page=cart");
    // }
    // if(isset($_POST['qty'])){
    //     $stt = $_POST['stt'];
    //     $qty = $_POST['qty'];
    //     if ($qty>1) {
    //         $_SESSION['cart'][$stt][4] = $qty;
    //     }else{
    //         array_splice($_SESSION['cart'],$stt,1);
    //     }
    // }
    if (isset($_SESSION['alert'])) {
        if ($_SESSION['alert'] == 1) {
            echo "<div class='alert alert-success'>
            <strong></strong>Thanh Toán Thành Công.
            </div>";
            $_SESSION['alert'] = 0;
        }
    }
    
    if (isset($_POST['pay_button']) ) {
        if ($_SESSION['cart'] != []) {
            echo "<script> window.location.href='index.php?page=pay';</script>";

            //Kiểm Tra Đăng Nhập
            // if (isset($_COOKIE['usr'])) {
            //     echo "<script> window.location.href='index.php?page=pay';</script>";
            // }else{
            //     echo "<div class='alert alert-warning'>
            //         <strong></strong>Đăng nhập để thanh toán.
            //         </div>";
            //     echo "<div class='alert alert-warning'>
            //     <strong></strong><a style='color: #254525;' href='view/login.php?page_return'>ĐĂNG NHẬP NGAY</a>
            //     </div>";
            // }
            
        }else{
            echo "<div class='alert alert-warning'>
            <strong></strong>Không có sản phẩm để thanh toán.
            </div>";
        }
    }
?>
<html>
<style>
    .main-banner {
        background: #255C45;
        height: 100px;
        animation: none;
    }
    .banner-info{
        display: none;
    }

</style>
</html>
<section class="about py-5">
        <div class="container pb-lg-3">
            <h3 class="tittle text-center">Giỏ Hàng</h3>
            <div class="container">
                <div class="container__cart" >
                    <div class="container__cart__first">
                        <div class="container__cart__first__DSSP">
                            <table>
                                <thead>
                                    <tr >
                                        <th>Hình ảnh</th>
                                        <th >Sản Phẩm</th>
                                        <th id="hidden">Giá</th>
                                        <th >Số Lượng</th>
                                        <th id="hidden">Tạm Tính</th>
                                        <th>Xóa</th>
                                        
                                    </tr>
                                </thead>
                                    <!-- Ranh Gioi -->
                                <tbody >
                                    <?php
                                        if (isset($_SESSION['cart'])) {
                                            $prod_total =0;
                                            $i=0;
                                            foreach ($_SESSION['cart'] as $value) {
                                                $tamtinh = (int)$value[3]*(int)$value[4];
                                                $prod_total += $tamtinh; 
                                                echo "<tr>
                                                    
                                                    <td>
                                                        <a href='index.php?page=product&id_prod=$value[0]' style='width: 100%; height: 100%;'></a>
                                                        <img src='uploads_product/$value[2]' style='width: 70px; height: 70px;' alt=''>
                                                    </td>
                                                    <td>
                                                        <a href='index.php?page=product&id_prod=$value[0]'>$value[1]</a>
                                                        <p id='hidden' style='width=100%;'>".number_format((int)$value[3], 0, "," , ".")." * $value[4]</p>
                                                    </td>
                                                    <td  id='hidden'> ".number_format((int)$value[3], 0, "," , ".")." VNĐ</td>
                                                    <td >
                                                    <div class='addquantity' id='soluong'>
                                                        <form action='' method='post'>
                                                            <input type='hidden' name='stt' value='$i'>
                                                            <input name='minus' class='change-color' type='submit' value='-'>
                                                            <input readonly name='qty' class='shadow' style='text-align: center;' type='text' value='$value[4]'>
                                                            <input name='plus' class='change-color' type='submit' value='+'>
                                                        </form>
                                                    </div>
                                                    </td>
                                                    <td id='hidden'>
                                                        ".number_format($tamtinh, 0, "," , ".")." VNĐ
                                                    </td>
                                                    <td id='xoa'>
                                                        <form action='' method='post'>
                                                            <input type='hidden' name='stt' value='$i'>
                                                            <input name='delete_prod' type='submit' value='Xóa' style='align-items: center;'>
                                                        </form>
                                                    </td>
                                                </tr>";
                                                $i++;
                                            };
                                        }
                                        // echo $i;
                                        
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- Ranh Gioi -->
                        <div class="container__cart__first__pay">
                            <div class="Tong">
                                <div id="congTienShip">
                                    <?php if (isset($prod_total)) {
                                        echo "Tổng: ".  number_format($prod_total, 0, "," , ".") . " VNĐ";
                                    }?>
                                </div>
                            </div>
                            <div class="Tien__Hanh_Thanh__Toan" style="border: none; margin-top: 10px;">
                                <form action="" method="post">
                                    <button name="pay_button" class="pay_button" type="submit">TIẾN HÀNH THANH TOÁN</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>