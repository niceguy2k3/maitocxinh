<?php 
   if (isset($_COOKIE['usr'])) {
      if ($_COOKIE['adm'] == 0) {

      }else{
         echo "<script>alert('Bạn không có quyền admin');</script>";
         header("location: ../index.php");
         // echo "<script> window.location.href='../index.php'</script>";
      }
   }else{
      echo "<script>alert('Bạn chưa đăng nhập');</script>";
      echo "<script> window.location.href='../index.php'</script>";
   }
?>
<html>
<script src="https://kit.fontawesome.com/9a5f8c4800.js" crossorigin="anonymous"></script>
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
</html>
<body>
    <!-- Nav tabs -->
   <div class="container">
   <?php require_once "admin-menu.php";?>
   <!-- Tab panes -->
   <div class="tab-content">
      <div class="tab-pane active" id="">
        <?php 
            if(isset($_REQUEST['page'])){
                $page = $_REQUEST['page'];  
                // switch ($page){
                //     case 'categories':
                //         include 'categories.php';
                //         break;
                //     default :
                //         include 'categories.php';
                //         break;
                // }
                include "$page.php";
            }else{
                include 'categories.php';
            }
        ?>
      </div>
   </div>
   </div>
</body>
