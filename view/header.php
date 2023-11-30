<?php
    if(isset($_POST['delete_prod'])){
        $stt = $_POST['stt'];
        array_splice($_SESSION['cart'],$stt,1);
        if(isset($_REQUEST['page'])){
            $page = $_REQUEST['page'];  
            // header("location: index.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-JM59YES2RN"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-JM59YES2RN');
    </script>
    <title>Mái Tóc Xinh </title>
    <link rel="icon" type="images/x-icon" href="assets/images/logo.png" />
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords" content="Mái Tóc Xinh"/>
    <script>
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);
        var manghinh = [];
        function nap(){
            for(var i =0; i < 10; i++){
                manghinh[i] = new Image();
                manghinh[i].src="../assets/images/Property 1=Variant"+i+".png";
            }
        }
        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!-- //Meta tag Keywords -->

    <!-- Custom-Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <!-- Bootstrap-Core-CSS -->
    <link rel="stylesheet" href="assets/css/style.css" type="text/css" media="all" />
    <link rel="stylesheet" href="assets/css/product.css">
    <link rel="stylesheet" href="assets/css/cart.css">
    
    <!-- Style-CSS -->
    <!-- font-awesome-icons -->
    <!-- <link href="assets/css/font-awesome.css" rel="stylesheet"> -->
    <!-- //font-awesome-icons -->
    <!-- /Fonts -->
    <link href="//fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900" rel="stylesheet">
    <!-- //Fonts -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        .user{
            display: flex;
        }
        .user>a,image{
            margin-top: -4px;
        }
        .user:hover>ul{
            display: flex;
            flex-wrap: wrap;
        }
        img#imgUser{
            margin-left: 10px; 
            margin-top: -2px; 
            width: 50px; 
            height: 50px;
            border-radius: 30px
        }
        @media (max-width: 768px){
            div#imgUser{
                display: none;
            }
        }
    </style>
</head>

<body onload="nap()">
    <!-- main-content -->
    <div class="container-fluid px-lg-5">
        <nav class="py-4">
            <!-- start main-menu  -->
            <div class="container">
                <div class="main-menu">
                    <div id="menu-768">
                        <label id="menu_alert" for="drop" class="toggle">Menu
                            <div style="display: <?php
                                // if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                                //     echo "block";
                                // }else{
                                //     echo "none";
                                // }
                                ?>;" class="cart_hover">
                                <?php
                                    // if (isset($_SESSION['cart'])) {
                                    //     echo count($_SESSION['cart']);
                                    // }
                                ?>
                            </div>
                        </label>
                    </div>
                    <div id="logo">
                        <a href="index.php"><img style="width: 250px; height: 100px;" src="assets/images/logo.png" alt=""></a>
                    </div>
                    <div id="search">
                        <form id="search" action="index.php?page=search" method="post" >
                            <input name="key" id="search" type="text" placeholder="Nhập ít nhất 3 ký tự để tìm sản phẩm">
                            <button name="submit" id="search" type="submit"><i class="fa fa-search" style="color: #255c45;"></i></button>
                            <div id="searchresult">

                            </div>
                        </form>
                        
                    </div>
                    <!-- start -->
                    <div class="container-user">
                        <div id="container-login">
                            <?php
                                // if (isset($_COOKIE['usr'])) {
                                //     echo "class='user'";
                                // }
                            ?>
                            <?php
                                if (isset($_COOKIE['usr'])) {
                                    // $username = ;
                                    $stmt = $conn -> query("SELECT * FROM usr where username = '".$_COOKIE['usr']."'");
                                    $usr = $stmt->fetch();
                                    if (isset($_COOKIE['adm']) && $_COOKIE['adm'] == 0) {
                                        $admin = "";
                                    }else{
                                        $admin = "style='display: none;'";
                                    }
                                    echo '<label for="drop-5" class="toggle">'.$usr['name'].'<span class="fa fa-angle-down" aria-hidden="true"></span> </label>
                                    <a id="login" href="#">'.$usr['name'].'<span class="fa fa-angle-down" aria-hidden="true"></span>
                                        
                                    </a>
                                    <input type="checkbox" id="drop-5"/>';
                                    echo '<ul>
                                            <li '.$admin.'><a href="index.php?page=admin">Quản Trị Website</a></li>
                                            <li><a href="index.php?page=user">Tài khoản</a></li>
                                            <li><a href="index.php?page=logout">Đăng Xuất</a></li>
                                        </ul>';
                                }else{
                                    echo '<a id="login" href="index.php?page=login">Đăng Nhập/Đăng Ký</a>';
                                }
                            ?>
                        </div>
                        <div id="imgUser"
                                    style="display: 
                                    <?php
                                        if (isset($_COOKIE['usr'])) {
                                            echo "block";
                                        }else{
                                            echo "none";
                                        }
                                    ?>;">
                                <!-- start img -->
                                <img id="imgUser"   
                                    src="<?php
                                        if (isset($_COOKIE['usr'])) {
                                            echo "uploads_user/".$usr['img'];
                                        }
                                    ?>" 
                                alt="">
                                <!-- end img -->
                        </div>
                    </div>
                    <!-- end -->
                    <div class="div-cart">
                        <a class="cart_icon" href="index.php?page=cart">
                            <i id="cart_header" class="fa fa-shopping-cart"></i>
                            <div style="display: <?php
                                if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                                    echo "block";
                                }else{
                                    echo "none";
                                }
                            ?>;" class="cart_hover">
                                <?php
                                    if (isset($_SESSION['cart'])) {
                                        echo count($_SESSION['cart']);
                                    }
                                ?>
                            </div>
                            
                        </a>
                        <div class="list-cart-hover">
                            <div class="cau"></div>
                            <?php
                                if (isset($_SESSION['cart']) & $_SESSION['cart'] != []) {
                                    $i=0;
                                    foreach ($_SESSION['cart'] as $value) {
                                        echo '<a href="index.php?page=product&id_prod='.$value[0].'" class="product">
                                        <div class="img">
                                            <img src="uploads_product/'.$value[2].'" alt="">
                                        </div>
                                        <div class="info">
                                            <div class="name">
                                                '.$value[1].'
                                            </div>
                                            <div class="price">
                                                <span class="price">'.number_format((int)$value[3], 0, "," , ".").'</span> * <span class="quantity">'.$value[4].'</span>
                                            </div>
                                        </div>
                                        <div class="delete">
                                            <form action="" method="post">
                                                <input type="hidden" name="stt" value='.$i.'>
                                                <button name="delete_prod" class="delete">X</button>
                                            </form>
                                        </div>
                                    </a>
                                    <hr>';
                                    $i++;
                                    }
                                }else{
                                    echo '
                                    <div class="product">
                                        Không có sản phẩm nào
                                    </div>';
                                }
                                if (isset($_SESSION['cart']) & $_SESSION['cart'] != []) {
                                    $tamtinh = 0;
                                    foreach ($_SESSION['cart'] as $value) {
                                        $tamtinh = (int)$value[3]*(int)$value[4];
                                    }
                                    echo '<div class="cart-info">
                                        <strong>Tổng số phụ: '.number_format($tamtinh, 0, "," , ".").'</strong>
                                        <a href="index.php?page=cart"><div class="cart-btn">Xem Giỏ Hàng</div></a>
                                        <a href="index.php?page=pay"><div class="cart-btn">Thanh Toán Ngay</div></a>
                                    </div>
                                    
                                    ';
                                }
                            ?>
                            
                            
                        </div>
                    </div>
                    <div id="menu">
                        <label style="display: none;" id="menu_alert" for="drop" class="toggle">Menu
                            <div style="display: <?php
                                // if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                                //     echo "block";
                                // }else{
                                //     echo "none";
                                // }
                                ?>;" class="cart_hover">
                            </div>
                        </label>
                        <input type="checkbox" id="drop" />
                        <ul class="menu mt-2">
                            <li class="active"><a href="index.php">Trang Chủ</a></li>
                            <li>
                                <label for="drop-1" class="toggle">Danh Mục<span class="fa fa-angle-down" aria-hidden="true"></span> </label>
                                <a href="#">Danh Mục<span class="fa fa-angle-down" aria-hidden="true"></span></a>
                                <input type="checkbox" id="drop-1" />
                                <ul>
                                <?php
                                    $stmt = $conn -> query("SELECT * FROM categories WHERE status = 1 and deleted = 0 ORDER BY stt");
                                    while ($cate = $stmt->fetch()) {
                                        Echo "<li><a href='index.php?page=categories&id_cate=$cate[0]'>$cate[1]</a></li>";
                                    }
                                ?>
                                </ul>
                            </li>
                            <li class="active"><a href="index.php?page=about">Về chúng tôi</a></li>
                            <li>
                                <label for="drop-2" class="toggle">Bài Viết<span class="fa fa-angle-down" aria-hidden="true"></span> </label>
                                <a href="#">Bài Viết<span class="fa fa-angle-down" aria-hidden="true"></span></a>
                                <input type="checkbox" id="drop-2" />
                                <ul>
                                <?php
                                    $stmt = $conn -> query("SELECT * FROM post_categories WHERE status = 1 AND deleted = 0 ORDER BY stt");
                                    while ($cate = $stmt->fetch()) {
                                        Echo "<li><a href='index.php?page=blog&id_cate=$cate[0]'>$cate[1]</a></li>";
                                    }
                                ?>
                                </ul>
                            </li>
                            <li class="active"><a href="index.php?page=contact">Liên Hệ</a></li>
                        </ul>
                    </div>

                </div>
                <!-- end main-menu  -->
            </div>
        </nav>
    </div>

<script type="text/javascript">
    $("#searchresult").css("display","none");
    $(document).ready(function(){
        $("input#search").keyup(function(){
            var input = $(this).val();
            // alert(input);
            if(input.length >= 3){
                $.ajax({
                    url: "model/search.php",
                    method: "POST",
                    data:{input:input},

                    success:function(data){
                        $("#searchresult").html(data);
                    }
                });
                $("#searchresult").css("display","block");
            }else{
                $("#searchresult").css("display","none");
            }

        })
    });
</script>
