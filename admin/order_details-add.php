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
        $h2="THÊM MỚI CHI TIẾT ĐƠN HÀNG";
        $id=$_GET['id']??"";
        if($id!=""){
            $h2="CHỈNH SỬA CHI TIẾT ĐƠN HÀNG";
            $stmt = $conn ->prepare("SELECT * FROM order_details"); 
            $stmt -> execute();
            $order_details = $stmt->fetch();
        }      
        if(isset($_POST['submit'])){
            $id_order=$_POST['id_order']??"";
            $id_prod=$_POST['id_prod']??"";
            $name_prod=$_POST['name_prod']??"";
            $price=$_POST['price']??0;
            $quantity=$_POST['quantity']??0;
            $total_money=$price*$quantity;
            if($id_order!=""){
                if($id==!""){
                    $stmt = $conn -> prepare("UPDATE order_details set id_order = $id_order, 
                    id_prod = $id_prod, name_prod = '$name_prod', price = $price, quantity = $quantity, total_money = $total_money WHERE id =$id");
                    $stmt->execute();
                    header('Location: admin.php?page=order_details'); 
                    // exit();
                }else{
                    $stmt = $conn -> prepare("INSERT INTO order_details(id_order, id_prod, name_prod, price, quantity, total_money)
                    VALUES ($id_order, $id_prod, '$name_prod', $price, $quantity, $total_money)");
                    $stmt -> execute();
                    header('Location: admin.php?page=order_details'); /*die()*/;
                }
            }else $msg="Vui lòng nhập đầy đủ thông tin";         
        }
      ?>
      <div class="container col-8 m-auto">
      <h2 class="py-2 text-center h4 "><?= $h2 ?></h2>
      <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="">ID</label>
                <input type="text" name="id" value="<?= $order_details[0]??"" ?>" disabled class="form-control bg-light" >
            </div>
            <div class="mb-3">
                <label for="">ID Đơn Hàng</label>
                <input type="text" name="id_order" value="<?= $order_details[1]??""?>" class="form-control bg-light" >
            </div>
            <div class="mb-3">
                <label for="">ID Sản Phẩm</label>
                <input type="text" name="id_prod" value="<?= $order_details[2]??"" ?>" required class="form-control bg-light" >
            </div>
            <div class="mb-3">
                <label for="">Tên Sản Phẩm</label>
                <input type="text" name="name_prod" value="<?= $order_details[3]??"" ?>" required class="form-control bg-light" >
            </div>
            <div class="mb-3">
                <label for="">Giá</label>
                <input type="text" name="price" value="<?= $order_details[4]??"" ?>" required class="form-control bg-light" >
            </div>
            <div class="mb-3">
                <label for="img">Số Lượng</label>
                <input type="text" name="quantity" value="<?= $order_details[5]??""?>" required class="form-control bg-light" >
            </div>
            <div class="mb-3">
                <label for="img">Tổng Tiền</label>
                <input type="text" value="<?= $order_details[6]??""?>" disabled class="form-control bg-light" >
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