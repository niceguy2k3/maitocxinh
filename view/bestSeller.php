<?php
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
          
        //   var_dump($array_cart);
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

  header("location: index.php");

}
?>
<!DOCTYPE html>
<html lang="zxx">
<body>
<section class="about py-5">
    <div class="container pb-lg-3">
        <h3 class="tittle text-center">Xem nhiều nhất</h3>
        <div class="wrap-content pt-4 pb-4">
            <?php
                $stmt = $conn -> query("SELECT * FROM product WHERE deleted = 0 AND status = 1 order by view desc limit 8");
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

</section>
<section class="about py-5">
    <div class="container pb-lg-3">
        <h3 class="tittle text-center">Mua nhiều nhất</h3>
        <div class="wrap-content pt-4 pb-4">
            <?php
                $stmt = $conn -> query("SELECT * FROM product JOIN (SELECT id_prod, sum(quantity) AS quantity FROM `order_details` GROUP BY id_prod) as bestseller WHERE product.id = bestseller.id_prod AND deleted = 0 AND status = 1 ORDER BY bestseller.quantity DESC limit 8");
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
</section>
<section class="about py-5">
    <div class="container pb-lg-3">
        <h3 class="tittle text-center">Sản Phẩm Mới Nhất</h3>
        <div class="wrap-content pt-4 pb-4">
            <?php
                $stmt = $conn -> query("SELECT * FROM `product` WHERE deleted = 0 AND status = 1 ORDER BY `create_at`DESC limit 8");
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
</section>
<section class="about py-5">
    <div class="container pb-lg-3">
        <h3 class="tittle text-center">Nước Hoa Mới Nhất</h3>
        <div class="wrap-content pt-4 pb-4">
            <?php
                $stmt = $conn -> query("SELECT * FROM `product` WHERE id_cate = 9 OR id_cate = 10 OR id_cate = 11 OR id_cate = 12 AND deleted = 0 AND status = 1 ORDER BY `create_at`DESC limit 8");
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
</section>
