<?php
    $id_cate = $_REQUEST['id_cate'];
    $stmt = $conn -> query("SELECT name FROM categories WHERE id = $id_cate AND status = 1 AND deleted = 0");
    $cate_name = $stmt->fetch();
    if($cate_name){
        
    }else{
        header("location: index.php");
    }
    // session_destroy();
    if (isset($_SESSION['cart'])) {
        
    }else{
        $_SESSION['cart'] = [];
    }
    if (isset($_POST['add_prod'])) {
        $i = 0;   
        $prod_id = $_POST['prod_id'];
        $prod_name = $_POST['prod_name'];
        $prod_img = $_POST['prod_img'];
        $prod_price = $_POST['prod_price'];
        $prod_quanlity = $_POST['prod_quanlity'];
        // if ($_SESSION['cart'] == null) {
        //     echo "Hello";
        // }
        foreach ($_SESSION['cart'] as $value) {
            if ($value[0] == $_POST['prod_id']) {
                // $prod_quanlity = $_POST['prod_quanlity'] + $value[4];
                // echo $value[0]." Đã tồn tại";
                $prod_quanlity += $value[4];
                array_splice($_SESSION['cart'],$i,1);
                
            }else{
                
                // var_dump($array_cart);
            }
            $i++;
        }
        
        // echo count($_SESSION['cart']) . "<br>";
        // echo $i. "<br>";
        // var_dump($_SESSION['cart']);

        $array_cart = [$prod_id,$prod_name,$prod_img,$prod_price,$prod_quanlity];
        
        array_push($_SESSION['cart'], $array_cart);
        
        echo "<div class='alert alert-success'>
            <strong></strong>Thêm Giỏ Hàng Thành Công.
        </div>";

        // unset($_SESSION['cart']);
        
        header("location: index.php?page=categories&id_cate=$id_cate");
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
<body>
    <!---->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="index.php">Home</a>
        </li>
        <li class="breadcrumb-item active">Danh mục</li>
        <li class="breadcrumb-item active"><?=$cate_name[0]?></li>
    </ol>
    <!---->
    <section class="about py-5">
        <div class="container pb-lg-3">
            <h3 class="tittle text-center"><?=$cate_name[0]?></h3>
            <div class="row">
                <div class="wrap-content pt-4 pb-4">
                    <?php
                        if (isset($_REQUEST['pagi'])) {
                            $offset = ($_REQUEST['pagi'] - 1)*8;
                        }else $offset = 0;
                        $stmt = $conn -> query("SELECT * FROM product where id_cate = $id_cate AND status = 1 AND deleted = 0 limit 8 offset $offset ");
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
                                    
                                    <form action="" method="post">
                                        <input type="hidden" name="prod_id" value="'.$row['id'].'">
                                        <input type="hidden" name="prod_name" value="'.$row['name'].'">
                                        <input type="hidden" name="prod_img" value="'.$row['img'].'">
                                        <input type="hidden" name="prod_price" value="'.$row['price'].'">
                                        <input type="hidden" name="prod_quanlity" value="1">
                                        <button type = "submit" class="btn" name="add_prod">
                                            THÊM VÀO GIỎ HÀNG 
                                            <i class = "fa fa-shopping-cart"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            </div>';
                        };
                    ?>
                </div>
                
            </div>
            <div id="pagi">
                <?php
                $rows = $conn->query("SELECT count(*) FROM product where id_cate = $id_cate")->fetchColumn();
                $total_pages = ceil($rows/8);
                $current_page = isset($_REQUEST['pagi']) ? $_REQUEST['pagi'] : 1;
                if ($current_page > 1) {
                    echo "<a href='index.php?page=$page&id_cate=$id_cate&pagi=" . ($current_page - 1) . "'>&laquo; Previous</a>";
                }
                for ($i=1; $i <= $total_pages; $i++) { 
                   echo "<a href='index.php?page=$page&id_cate=$id_cate&pagi=$i'>$i</a>";
                   echo "\t";
                }
                if ($current_page < $total_pages) {
                    echo "<a href='index.php?page=$page&id_cate=$id_cate&pagi=" . ($current_page + 1) . "'>Next &raquo;</a>";
                }
                ?>
                
            </div>
                
        </div>
    </section>