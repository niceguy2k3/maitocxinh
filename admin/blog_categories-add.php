
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
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
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
        $h2="THÊM MỚI LOẠI BÀI VIẾT";
        $id=$_GET['id']??"";
        // check trạng thái
        $check0 = "";
        $check1 = "";
        //check trạng thái
        if($id!=""){
            $h2="CHỈNH SỬA LOẠI BÀI VIẾT";
            $stmt = $conn -> prepare("SELECT * FROM post_categories WHERE id = '$id'");
            $stmt->execute();
            $cate = $stmt->fetch();
            if($cate["status"] == 0){
                $check0 = "checked";
            }else{
                $check0 = "";
            }
            if($cate["status"] == 1){
                $check1 = "checked";
            }else{
                $check1 = "";
            }
        }      
        if(isset($_POST['submit'])){
            $name=$_POST['name']??"";
            $stt=$_POST['stt']??1;
            $status=$_POST["status"]??0;
            if($name!=""){
                if($id==!""){
                    $stmt = $conn -> prepare("UPDATE post_categories set name = '$name', stt = $stt, status = $status WHERE id =$id");
                    $stmt->execute();
                    header('Location: admin.php?page=blog_categories'); 
                    exit();
                }else{
                    $stmt = $conn -> prepare("INSERT INTO post_categories(name, stt, status)
                    VALUES ('$name', $stt, $status)");
                    $stmt -> execute();
                    header('Location: admin.php?page=blog_categories'); die();
                }
            }else $msg="Vui lòng nhập đầy đủ thông tin";         
        }
      ?>
      <div class="container col-8 m-auto">
      <h2 class="py-2 text-center h4 "><?= $h2 ?></h2>
      <form class="form" action="" method="post">
            <div class="input mb-3">
                <label for="">ID Loại</label>
                <input type="text" name="id" value="<?= $cate['id']??"" ?>" disabled class="form-control bg-light" >
            </div>
            <div class="input mb-3">
                <label for="">Tên</label>
                <input type="text" name="name" value="<?= $cate['name']??"" ?>" class="form-control bg-light" >
            </div>
            <div class="input mb-3">
                <label for="">Số Thứ Tự</label>
                <input type="text" name="stt" value="<?= $cate['stt']??"" ?>" class="form-control bg-light" >
            </div>
            <div class="input mb-3">
                <label for="">Trạng Thái:</label>
                <input type="radio" name="status" value="0" <?=$check0?>> Ẩn
                <input type="radio" name="status" value="1" <?=$check1?>> hiện
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