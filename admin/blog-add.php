
<?php
// require_once "../functions.php";
// if (checklogin()==false){  header('Location: login.php'); exit(); }
$page = $_GET['page'] ?? "theloai";
?>
<html>
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
   
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
   
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

   

   <link rel="stylesheet" href="./main.css">
   <title>Quản trị web tổng hợp</title>
   <style>
      .error-msg {
         width: 100%;
         text-align: center;
         color: rgb(92, 2, 2);
         background: rgba(218, 77, 77, 0.729);
         border-radius: 5px;
         margin: 5px 0;
         font-weight: 600;
      }
   </style>
</head>
<body>
   <!-- Nav tabs -->
   <div class="container">
   <?php require_once "admin-menu.php";?>
   <!-- Tab panes -->
   <div class="tab-content">
      <div class="tab-pane active" id="">
      <?php
      // lấy ra danh mục thể loại hiên thị trong select
        require '../config/config.php';
        require '../model/conn.php';
        $msg="";
        $h2="THÊM MỚI BÀI VIẾT";
        $id=$_GET['id']??"";
        $check0 = "";
        $check1 = "";
        if($id!=""){
            $h2="CHỈNH SỬA BÀI VIẾT";
            $stmt = $conn -> prepare("SELECT * FROM post WHERE id = '$id'");
            $stmt->execute();
            $blog = $stmt->fetch();
            if($blog["status"] == 0){
                $check0 = "checked";
            }else{
                $check0 = "";
            }
            if($blog["status"] == 1){
                $check1 = "checked";
            }else{
                $check1 = "";
            }
        }      
        if(isset($_POST['submit'])){
            $name=$_POST['name']??"";
            // $price=$_POST['price']??0;
            // $discount=$_POST['discount']??0;
            $status=$_POST['status']??0;
            if (isset($_FILES['img']) && $_FILES['img']['name']!= "") {
                $img=$_FILES['img']['name']??"";
                $target_dir = "../uploads_blog/";
                $target_file = $target_dir . $img;
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                // Check if image file is a actual image or fake image
                if(isset($_POST["submit"])) {
                    $check = getimagesize($_FILES["img"]["tmp_name"]);
                    if($check !== false) {
                        echo "File is an image - " . $check["mime"] . ".";
                        $uploadOk = 1;
                    } else {
                        echo "File is not an image.";
                        $uploadOk = 0;
                    }
                }

                // Check if file already exists
                if (file_exists($target_file)) {
                    echo "Sorry, file already exists.";
                    $uploadOk = 0;
                }

                // Check file size
                if ($_FILES["img"]["size"] > 5000000) {
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                    
                    echo "The file ". htmlspecialchars( basename( $_FILES["img"]["name"])). " has been uploaded.";
                    } else {
                    echo "Sorry, there was an error uploading your file.";
                    }
                }
            }else{
                $img=$blog['img'];
            }
            $id_cate=$_POST['id_cate']??"";
            // $view=$_POST['view']??;
            $meta_descrip=$_POST['meta_descrip']??"";
            $description=$_POST['description']??"";
            if($name!=""){
                if($id==!""){
                    $stmt = $conn -> prepare("UPDATE post set name = '$name',
                    img = '$img', id_cate = $id_cate, /*view = $view,*/
                    update_at = CURRENT_TIMESTAMP, description = '$description', meta_description = '$meta_descrip', status = $status WHERE id =$id");
                    $stmt->execute();
                    header('Location: admin.php?page=blog'); 
                    // exit();
                }else{
                    $stmt = $conn -> prepare("INSERT INTO post(name, img, id_cate, /*view,*/ create_at, update_at, description, meta_description, status)
                    VALUES ('$name', '$img', $id_cate, /*$view,*/ CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '$description', '$meta_descrip', $status)");
                    $stmt -> execute();
                    header('Location: admin.php?page=blog'); /*die()*/;
                }
            }else $msg="Vui lòng nhập đầy đủ thông tin";         
        }
      ?>
      <div class="container col-8 m-auto">
      <h2 class="py-2 text-center h4 "><?= $h2 ?></h2>
      <form class="form" action="" method="post" enctype="multipart/form-data">
            <div class="img mb-3">
                <label for="img">Ảnh Bìa</label>
                <input style="display: <?php if ($id == "") {
                    echo "none";
                }?>;" type="input" name="img" value="<?= $blog['img']??"" ?>" disabled class="form-control bg-light" >
                <img style="display: <?php if ($id == "") {
                    echo "none";
                }?>;" width="300px" height="300px" src="../uploads_blog/<?= $blog['img']??"" ?>" alt="">
                <input type="file" name="img" value="<?= $blog['img']??"" ?>" class="form-control bg-light" >
            </div>
            <div class="input mb-3">
                <label for="">ID Sản Phẩm</label>
                <input type="text" name="id" value="<?= $blog['id']??"" ?>" disabled class="form-control bg-light" >
            </div>
            <div class="input mb-3">
                <label for="">Tên</label>
                <input type="text" name="name" value="<?= $blog['name']??"" ?>" required class="form-control bg-light" >
            </div>
            <div class="input mb-3">
                <label for="">Mô Tả Ngắn</label>
                <input type="text" name="meta_descrip" value="<?= $blog['meta_description']??"" ?>" required class="form-control bg-light" maxlength="2555">
            </div>
            
            <div class="input mb-3">
                <label for="">Loại Bài Viết</label>
                <select name="id_cate" id="" class="form-control bg-light" >
                   <option value="0">--Chọn loại bài viết--</option>
                   <?php
                        $stmt = $conn -> prepare("SELECT * FROM post_categories WHERE status = 1 AND deleted = 0");
                        $stmt->execute();
                        while($cate = $stmt -> fetch()){
                            if ($cate['id'] == $blog['id_cate']){
                                echo "<option value='$cate[id]' selected >$cate[name]</option>";
                            }
                            else
                                echo "<option value='$cate[id]'>$cate[name]</option>";
                        }
                   ?>
                </select>
            </div>
            <div class="input mb-3">
                <label for="">Lượt Xem</label>
                <input type="text" name="view" value="<?= $blog['view']??""?>" disabled class="form-control bg-light" >
            </div>
            <div class="input mb-3">
                <label for="">Ngày Tạo</label>
                <input type="text" name="create_at" value="<?= $blog['create_at']??"" ?>" disabled class="form-control bg-light" >
            </div>
            <div class="input mb-3">
                <label for="">Ngày Cập Nhật</label>
                <input type="text" name="update_at" value="<?= $blog['update_at']??"" ?>" disabled class="form-control bg-light" >
            </div>
            
            <div class="input mb-3">
                <label for="">Trạng Thái:</label>
                <input type="radio" name="status" value="0" <?=$check0?>> Ẩn
                <input type="radio" name="status" value="1" <?=$check1?>> hiện
            </div>
            <div class="descrip mb-3">
                <label for="">Mô Tả</label>
                <textarea name="description" id="description" class="form-control bg-light" rows="5"><?= $blog['description']??"" ?></textarea>
            </div>
            
            <div class="button mb-3">
                <button class="btn btn-success px-4" name="submit">Lưu</button>
            </div>
            <div class="error-msg"><?= $msg ?></div>
      </form>
      </div>
      </div> <!-- tab-pane -->
   </div>
   </div>
</body>
</html>


<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

<script>
    ClassicEditor
        .create( document.querySelector( '#description' ),{
            
        } )
        .catch( error => {
            console.error( error );
        } );
</script>
<style>
.ck-editor__editable_inline {
   min-height: 250px;
   max-height: 450px;
}
</style>