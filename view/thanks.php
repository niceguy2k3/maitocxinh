<?php
    if (isset($_SESSION['thanks'])) {
        if ($_SESSION['thanks'] == 1) {
            $_SESSION['thanks'] = 0;
        }else{
            header("location: index.php");
        }
    }else{
        header("location: index.php");
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
    
    .alert1 {
        position: relative;
        padding: 0.75rem 1.25rem;
        margin-bottom: -1rem;
        border: 1px solid transparent;
        border-radius: 0.25rem;
        text-align: center;
    }
    
    .alert-success1 {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
        margin-left: 380px;
        margin-right: 380px;
    }
            @media (max-width: 768px) {
            .main-banner {
                height: 60px;
            }

            .alert-success1 {
                margin-left: 10px;
                margin-right: 10px;
              
            }
        }
          @media (max-width: 768px) {
        .footer-cta {
            text-align: center;
        }

        .single-cta {
            text-align: center;
            margin-bottom: 20px;
        }

        .cta-text {
            padding-left: 0;
            display: block;
            text-align: center;
        }

        .footer-pattern img {
            height: auto;
            max-width: 100%;
        }

        .footer-widget {
            text-align: center;
            margin-bottom: 30px;
        }

        .subscribe-form {
            text-align: center;
        }

        .subscribe-form input {
            width: calc(100% - 60px);
            margin-right: 0;
        }

        .subscribe-form button {
            right: 0;
            top: 10px;
            margin-top: 10px;
        }
    }
</style>
</html>
<section class="about pt-5">
        <div class="container pb-lg-3">
            <h3 class="tittle text-center">Cảm Ơn Bạn Đã Mua Hàng</h3>
            <!--<div class='alert1 alert-success1'> -->
            <!--  <a href = "user/user.php?page=orders"><strong></strong>Đặt Hàng Thành Công.<br>Chi Tiết Đơn Hàng</a>-->
            <!--</div>-->
            <div class="container">
                <div class="container__cart" >
                    <div class="container__cart__first">
                        <!--start container__cart__first__DSSP-->
                        <div class="container__cart__first__DSSP">
                            <table>
                                <thead>
                                    <tr >
                                        <th>Hình ảnh</th>
                                        <th >Sản Phẩm</th>
                                        <!-- <th id="hidden">Giá</th> -->
                                        <!-- <th >Số Lượng</th> -->
                                        <th id="hidden">Tạm Tính</th>
                                        <!-- <th>Xóa</th> -->
                                        
                                    </tr>
                                </thead>
                                    <!-- Ranh Gioi -->
                                <tbody >
                                    <?php
                                        if (isset($_SESSION['afterpay'])) {
                                            $prod_total =0;
                                            $i=0;
                                            foreach ($_SESSION['afterpay'] as $value) {
                                                $tamtinh = (int)$value[3]*(int)$value[4];
                                                $prod_total += $tamtinh; 
                                                echo "<tr>
                                                    <td>
                                                        <a href='index.php?page=product&id_prod=$value[0]' style='width: 100%; height: 100%;'></a>
                                                        <img src='uploads_product/$value[2]' style='width: 70px; height: 70px;' alt=''>
                                                    </td>
                                                    <td>
                                                        <a href='index.php?page=product&id_prod=$value[0]'>$value[1]</a>
                                                        <p style='width=100%;'>".number_format((int)$value[3], 0, "," , ".") . " VNĐ"." * $value[4]</p>
                                                    </td>
                                                    <td id='hidden'>
                                                        ".number_format($tamtinh, 0, "," , "."). " VNĐ"." 
                                                    </td>
                                                </tr>";
                                                $i++;
                                            };
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!--end container__cart__first__DSSP-->
                        <div class="container__cart__first__pay">
                            <div class="Tong">
                                <div id="congTienShip">
                                    <?php if (isset($prod_total)) {
                                        echo "Tổng: ".  number_format($prod_total, 0, "," , ".") . " VNĐ";
                                    }?>
                                </div>
                            </div>
                            <div class="Tien__Hanh_Thanh__Toan" style="border: none; margin-top: 10px;">
                                <form action="index.php" method="post">
                                    <button class="pay_button" type="submit">TIẾP TỤC MUA HÀNG</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<section class="about">
    <div class="container pb-lg-3">
        <h3 class="tittle text-center">Gợi Ý</h3>
        <div class="wrap-content pt-4 pb-4">
            <?php
                $dieukien = "AND ";
                if (isset($_SESSION['splq'])) {
                    foreach ($_SESSION['splq'] as $value) {
                        $dieukien .= "id_cate = " . $value . " OR ";
                    }
                }
                // var_dump($_SESSION['splq']);
                // echo $dieukien;
                $stmt = $conn -> query("SELECT * FROM product WHERE deleted = 0 AND status = 1 $dieukien id_cate = RAND() order by RAND() limit 8");
                while ($row = $stmt->fetch()) {
                    echo '<div class="container">
                        <img src="uploads_product/'.$row['img'].'" class="img-fluid" alt="">
                        <div class="overlay">
                        <div class = "items"></div>
                        <div class = "items head">
                            <p><a href="index.php?page=product&id_prod='.$row['id'].'">'.$row['name'].'</a></p>
                            <hr>
                        </div>
                        <div class = "items price">
                            <p class="old">'.number_format($row['price'], 0, "," , ".").' VNĐ</p>
                            <p class="new">'.number_format($row['discount'], 0, "," , ".").' VNĐ</p>
                        </div>
                        <div class="items cart">
                            
                            <form action="index.php?page=product&id_prod='.$row['id'].'"method="post">
                                <input type="hidden" name="prod_id" value="'.$row['id'].'">
                                <input type="hidden" name="prod_name" value="'.$row['name'].'">
                                <input type="hidden" name="prod_img" value="'.$row['img'].'">
                                <input type="hidden" name="prod_price" value="'.$row['price'].'">
                                <input type="hidden" name="prod_quanlity" value="1">
                                <button type = "submit" class="btn" name="add_prod">
                                    XEM CHI TIẾT
                                    <i class = "fa fa-bookmark"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    </div>';
                };
            ?>
        </div>
    </div>
</section>