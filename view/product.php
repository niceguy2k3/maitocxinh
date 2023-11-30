<?php
    $id_prod = $_REQUEST['id_prod'];
    $stmt = $conn -> query("SELECT * FROM product where id = $id_prod");
    $prod = $stmt->fetch();
    // kiểm tra sản phẩm thuộc loại (ẩn hiện hoặc bị xóa);
    $stmt = $conn -> query("SELECT product.id, product.status, product.deleted, categories.status, categories.deleted FROM product JOIN categories 
                            WHERE product.id_cate = categories.id 
                            AND product.id=$id_prod 
                            AND product.status=1 
                            AND product.deleted=0
                            AND categories.status=1 
                            AND categories.deleted = 0");
    $status_cate = $stmt->fetch();
    if($status_cate){

    }else{
        header("location: index.php");
    }
    // tăng lượt xem;
    $view = $prod[8];
    $view++;
    $stmt = $conn ->prepare("UPDATE product SET view = $view where id = $prod[0]");
    //execute(): thực thi
    $stmt -> execute();
    // echo $view;
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

    //    echo count($_SESSION['cart']) . "<br>";
    //    echo $i. "<br>";
    //    var_dump($_SESSION['cart']);
       
       $array_cart = [$prod_id,$prod_name,$prod_img,$prod_price,$prod_quanlity];
       
       array_push($_SESSION['cart'], $array_cart);

       echo "<div class='alert alert-success'>
           <strong></strong>Thêm Giỏ Hàng Thành Công.
        </div>";

       header("location: index.php?page=product&id_prod=$id_prod");
       
       
    //    unset($_SESSION['cart']);

    // Comment

    
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
    .media{
        width: 100%;
    }

</style>
</html>
<body>
    <!---->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="index.php">Home</a>
        </li>
        <li class="breadcrumb-item active">Sản Phẩm</li>
        <li class="breadcrumb-item active"><?=$prod[1]?></li>
    </ol>
    <!---->
    <section class="about pt-5">
        <div class="container pb-lg-3">
            <div class="wrap-content">
                <div class = "card-wrapper">
                    <div class = "card">
                        <!-- card left -->
                        <div class = "product-imgs">
                            <div class = "img-display">
                                <div class = "img-showcase">
                                <img src = "uploads_product/<?php echo $prod[4]?>" alt = "shoe image">
                                <img src = "https://fadzrinmadu.github.io/hosted-assets/product-detail-page-design-with-image-slider-html-css-and-javascript/shoe_2.jpg" alt = "shoe image">
                                <img src = "https://fadzrinmadu.github.io/hosted-assets/product-detail-page-design-with-image-slider-html-css-and-javascript/shoe_3.jpg" alt = "shoe image">
                                <img src = "https://fadzrinmadu.github.io/hosted-assets/product-detail-page-design-with-image-slider-html-css-and-javascript/shoe_4.jpg" alt = "shoe image">
                                </div>
                            </div>
                            <div class = "img-select">
                                <div class = "img-item">
                                <a href = "#" data-id = "1">
                                    <img src = "uploads_product/<?php echo $prod[4]?>" alt = "shoe image">
                                </a>
                                </div>
                                <div class = "img-item">
                                <a href = "#" data-id = "2">
                                    <img src = "https://fadzrinmadu.github.io/hosted-assets/product-detail-page-design-with-image-slider-html-css-and-javascript/shoe_2.jpg" alt = "shoe image">
                                </a>
                                </div>
                                <div class = "img-item">
                                <a href = "#" data-id = "3">
                                    <img src = "https://fadzrinmadu.github.io/hosted-assets/product-detail-page-design-with-image-slider-html-css-and-javascript/shoe_3.jpg" alt = "shoe image">
                                </a>
                                </div>
                                <div class = "img-item">
                                <a href = "#" data-id = "4">
                                    <img src = "https://fadzrinmadu.github.io/hosted-assets/product-detail-page-design-with-image-slider-html-css-and-javascript/shoe_4.jpg" alt = "shoe image">
                                </a>
                                </div>
                            </div>
                        </div>
                            <!-- card right -->
                        <div class = "product-content">
                            <h2 class = "product-title"><?php echo $prod[1]?></h2>
                            <!-- <a href = "#" class = "product-link">visit nike store</a> -->
                            <!-- <div class = "product-rating">
                                <i class = "fas fa-star"></i>
                                <i class = "fas fa-star"></i>
                                <i class = "fas fa-star"></i>
                                <i class = "fas fa-star"></i>
                                <i class = "fas fa-star-half-alt"></i>
                                <span>4.7(21)</span>
                            </div> -->

                            <div class = "product-price">
                                <p class = "last-price">Giá Gốc: <span><?php echo number_format($prod[2])?> VNĐ</span></p>
                                <p class = "new-price">Giảm Giá: <span><?php echo number_format($prod[3])?> VNĐ</span></p>
                            </div>

                            <div class = "product-detail">
                                <h2>thông tin sản phẩm </h2>
                                <p><?php /*echo $prod[7]*/?></p>
                                <!-- <ul>
                                <li>Color: <span>Black</span></li>
                                <li>Available: <span>in stock</span></li>
                                <li>Category: <span>Shoes</span></li>
                                <li>Shipping Area: <span>All over the world</span></li>
                                <li>Shipping Fee: <span>Free</span></li>
                                </ul> -->
                            </div>

                            <div class = "purchase-info">
                                <div class="product__main__info__addquantity">
                                    <form action="" method="post">
                                        <input class="change-color" type="button" value="-" onclick="minus()">
                                        <input id="soluong" name="prod_quanlity" class="shadow" style="text-align: center;" type="text" value="1">
                                        <input class="change-color" type="button" value="+" onclick="plus()">
                                        <input type="hidden" name="prod_id" value="<?=$prod[0]?>">
                                        <input type="hidden" name="prod_name" value="<?=$prod[1]?>">
                                        <input type="hidden" name="prod_img" value="<?=$prod[4]?>">
                                        <input type="hidden" name="prod_price" value="<?=$prod[2]?>">
                                        <!-- <input type="hidden" name="prod_quanlity" value="1"> -->
                                        <button type = "submit" class="btn" name="add_prod">
                                            THÊM VÀO GIỎ HÀNG 
                                            <i class = "fa fa-shopping-cart"></i>
                                        </button>
                                        
                                    </form>
                                </div>
                                
                                
                                <!-- <button type = "button" class = "btn">Compare</button> -->
                            </div>

                            <div class = "social-links">
                                <p>Chia Sẻ: </p>
                                <a href = "#">
                                <i class = "fa fa-facebook-f"></i>
                                </a>
                                <a href = "#">
                                <i class = "fa fa-twitter"></i>
                                </a>
                                <a href = "#">
                                <i class = "fa fa-instagram"></i>
                                </a>
                                <a href = "#">
                                <i class = "fa fa-whatsapp"></i>
                                </a>
                                <a href = "#">
                                <i class = "fa fa-pinterest"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="ab-info-main py-md-3 pt-3">
        <div class="container py-md-3">
            <h3 class="tittle text-center mb-lg-5 mb-3">Chi tiết Sản Phẩm</h3>
            <div class="speak px-lg-5">
                <div class="row mt-lg-5 mt-4">
                    <?php echo $prod[7]?>
                <div class="single-form-left">
                    <!-- contact form grid -->
                    <div class="contact-single">
                        <h3><span class="sub-tittle"></span>Bình Luận</h3>
                        <?php
                            //Kiểm Tra Đăng Nhập
                            if (isset($_COOKIE['usr'])) {
                                echo '<form action="model/post_comment.php" method="post" class="mt-4">
                                    <div class="form-group">
                                        <textarea name="content" class="form-control border" rows="5" id="contactcomment" required="" placeholder="Viết Bình Luận"></textarea>
                                    </div>
                                    <div class="d-sm-flex">
                                        <div class="col-sm-6 form-group p-0">
                                            <input name="id_prod" value="'.$id_prod.'" type="hidden" class="form-control border" id="contactusername" required="">
                                        </div>
                                        <div class="col-sm-6 form-group ml-sm-3">
                                            <input name="id_user" value="'.$_COOKIE['usr'].'" type="hidden" class="form-control border" id="contactemail" required="">
                                        </div>
                                    </div>
                                    <button type="submit" name="submit" class="mt-3 btn btn-success btn-block py-3">Đăng Bình Luận</button>
                                </form>';
                            }else{
                                echo "<div class='alert alert-warning'>
                                    <strong></strong>Đăng nhập để bình luận.
                                    </div>";
                                echo "<div class='alert alert-warning'>
                                <strong></strong><a style='color: #254525;' href='index.php?page=login'>ĐĂNG NHẬP NGAY</a>
                                </div>";
                            }
                        ?>
                        
                    </div>
                    <!--  //contact form grid ends here -->
                </div>
                <?php
                    
                    $stmt = $conn -> prepare("SELECT id, id_user, content, name, img FROM cmt join usr where cmt.id_user = usr.username and id_prod = $id_prod");
                    $stmt -> execute();
                    while ($cmt = $stmt->fetch()) {
                        if(isset($_COOKIE['usr'])){
                            if ($_COOKIE['usr']!=$cmt[1]){
                                $delete = "display: none;'";
                            }else{
                                $delete = "";
                            }
                        }else{
                            $delete = "display: none;'";
                        }
                        
                        echo "<div class='media py-5'>
                        <img src='uploads_user/$cmt[4]' style='width: 80px; height: 80px;' class='mr-3 img-fluid rounded-circle' alt='image'>
                        <div class='media-body'>
                            <h5 class='mt-0'>$cmt[3]</h5>
                            <p class='mt-2'>$cmt[2]</p>
                            <a style='color: blue; $delete' href='' onclick='delete_cmt($cmt[0])'>Xóa</a>
                            <!-- reply comment -->
                            <!-- <div class='media mt-5'>
                                <a class='pr-3' href='#'>
                                    <img src='uploads_user/dodo-bac.jpg' style='width: 80px; height: 80px;' class='img-fluid rounded-circle' alt='image'>
                                </a>
                                <div class='media-body'>
                                    <h5 class='mt-0'>Leia Organa</h5>
                                    <p class='mt-2'> Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla..</p>
                                </div>
                            </div> -->
                        </div>
                    </div>";
                    }
                ?>

            </div>
        </div>
    </section>
</body>

<script>
const imgs = document.querySelectorAll('.img-select a');
const imgBtns = [...imgs];
let imgId = 1;

imgBtns.forEach((imgItem) => {
    imgItem.addEventListener('click', (event) => {
        event.preventDefault();
        imgId = imgItem.dataset.id;
        slideImage();
    });
});

function slideImage(){
    const displayWidth = document.querySelector('.img-showcase img:first-child').clientWidth;

    document.querySelector('.img-showcase').style.transform = `translateX(${- (imgId - 1) * displayWidth}px)`;
}

window.addEventListener('resize', slideImage);
var soluong = document.getElementById("soluong").value;
function plus(){
    soluong++;
    document.getElementById("soluong").value=soluong;
}
function minus(){
    if(soluong>1){
        soluong--;
        document.getElementById("soluong").value=soluong;
    }
}
</script>
<script>
    delete_cmt=(id)=>{
        let check=confirm("Bạn có chắc chắn xóa không ??")
        console.log(id)
        if(check){
            $.post("model/delete_cmt.php",{'id_cmt':id},
            (data)=>{ 
                console.log(data);
                if(data== 0) location.reload(); else alert(data); 
            })
        }
    }
</script>