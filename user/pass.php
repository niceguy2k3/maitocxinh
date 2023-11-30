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
   <?php require_once "user-menu.php";?>
   <!-- Tab panes -->
   <div class="tab-content">
      <div class="tab-pane active" id="">
      <?php
      // lấy ra danh mục thể loại hiên thị trong select
        require '../config/config.php';
        require '../model/conn.php';
        $msg="";
        $username=$_COOKIE['usr'];
        if($username!=""){
            $h2="ĐỔI MẬT KHẨU";
            $stmt = $conn -> prepare("SELECT * FROM usr WHERE username = '$username'");
            $stmt->execute();
            $user = $stmt->fetch();
        }      
        if(isset($_POST['submit'])){
            if (isset($_POST['old_pwd']) && $_POST['old_pwd'] != "") {
                $old_pwd = $_POST['old_pwd']??"";
                if(password_verify($old_pwd, $user['pass'])){
                    if (isset($_POST['pwd']) && ($_POST['pwd'] != "") && ($_POST['cfm'] != "") && ($_POST['pwd'] == $_POST['cfm'])) {
                        $pwd = $_POST['pwd'];
                        echo $pwd . "<br>";
                        $stmt = $conn -> prepare("UPDATE usr SET pass = ?, update_at = CURRENT_TIMESTAMP WHERE username = '$user[0]'");
                        $stmt -> bindParam(1, password_hash($pwd, PASSWORD_BCRYPT));
                        $stmt -> execute();
                        $user = $stmt -> fetch();
                        echo "<script>alert('Đổi mật khẩu thành công');</script>";
                        echo "<script> window.location.href='user.php?page=pass';</script>";
                    }else{
                        echo "<script>alert('Đổi mật khẩu THẤT BẠI');</script>";
                        echo "<script> window.location.href='user.php?page=pass';</script>";
                    }
                }else{
                    echo "<script>alert('Password KHÔNG ĐÚNG !');</script>";
                    echo "<script> window.location.href='user.php?page=pass';</script>";
                }
            }else{
                // echo "<script>alert('Lo Con CAc goi !');</script>";
                // echo "<script> window.location.href='user.php?page=info';</script>";
            }  
        }
      ?>
      <div class="container m-auto">
      <h2 class="py-2 text-center h4 "><?= $h2 ?></h2>
      <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="">Mật khẩu hiện tại (bỏ trống nếu không đổi)</label>
                <input name="old_pwd" type="password" value="" class="form-control bg-light" >
            </div>
            <div class="mb-3">
                <label for="">Mật khẩu mới (bỏ trống nếu không đổi)</label>
                <input name="pwd" type="password" value="" class="form-control bg-light" >
            </div>
            <div class="mb-3">
                <label for="">Xác nhận mật khẩu mới</label>
                <input name="cfm" type="password" value="" class="form-control bg-light" >
            </div>
            <button class="btn btn-success px-4" name="submit">Lưu</button>
            <div class="error-msg"><?= $msg ?></div>
      </form>
      </div>
      </div> <!-- tab-pane -->
   </div>
   </div>
</body>
</html>