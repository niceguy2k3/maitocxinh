<?php
    $id_blog = $_REQUEST['id_blog'];
    $stmt = $conn -> query("SELECT * FROM post where id = $id_blog");
    $blog = $stmt->fetch();
    // kiểm tra sản phẩm thuộc loại (loại đã ẩn hoặc chưa);
    $stmt = $conn -> query("SELECT post.id, post.status, post.deleted, post_categories.deleted, post_categories.status FROM post JOIN post_categories 
                            WHERE post.id_cate = post_categories.id 
                            AND post.id = $id_blog 
                            AND post.status = 1 
                            AND post.deleted = 0
                            AND post_categories.status = 1 
                            AND post_categories.deleted = 0");
    $status_cate = $stmt->fetch();
    if($status_cate){

    }else{
        header("location: index.php?page=index.php");
    }
    // tăng lượt xem;
    $view = $blog[5];
    $view++;
    $stmt = $conn ->prepare("UPDATE post SET view = $view where id = $blog[0]");
    //execute(): thực thi
    $stmt -> execute();
?>
<html>
<style>
    .main-banner{
        background: url("uploads_blog/<?=$blog[2]?>") no-repeat top;
        -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            -ms-background-size: cover;
            background-size: cover;
            background-attachment: fixed;
        position: relative;
        height: 300px;
        /* animation: banner 5s ease-in-out infinite; */
        display: flex;
        align-items: center;
        justify-content: center;

    }
    .main-banner>.overlay{
        position: absolute;
        z-index: 0;
        width: 100%;
        height: 100%;
        background-color: black;
        opacity: .5;
    }
    .main-banner>.container{
        position: absolute;
        z-index: 1;
    }
    .main-banner>.container>h3{
        color: white;
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
        <li class="breadcrumb-item active">Bài Viết</li>
        <li class="breadcrumb-item active"><?=$blog[1]?></li>
    </ol>
    <!---->
    <section class="ab-info-main py-md-5">
        <div class="main-banner">
            <div class="overlay"></div>
            <div class="container">
                <h3 class="tittle text-center mb-lg-5 mb-3"><?=$blog[1]?></h3>
            </div>
        </div>
        <div class="container py-md-3">
            
            <div class="speak px-lg-5">
                <div class="row mt-lg-5 mt-4">
                    <?php echo $blog[7]?>
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
                                            <input name="id_blog" value="'.$id_blog.'" type="hidden" class="form-control border" id="contactusername" required="">
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
                    
                    $stmt = $conn -> prepare("SELECT id, id_user, content, name, img FROM cmt join usr where cmt.id_user = usr.username and id_prod = $id_blog");
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