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
        $h2="THÊM MỚI ĐƠN HÀNG";
        $id=$_GET['id']??"";
        if($id!=""){
            $h2="CHỈNH SỬA ĐƠN HÀNG";
            $stmt = $conn ->prepare("SELECT * FROM orders 
            join (SELECT id_order, sum(total_money) as total_money from order_details GROUP BY id_order) as order_details 
            on orders.id = order_details.id_order and orders.id = $id ORDER BY orders.id"); 
            $stmt -> execute();
            $order = $stmt->fetch();
        }      
        if (isset($_POST['to_oder_details'])) {
            echo "HEllo";
        }
        if(isset($_POST['submit'])){
            $id_user=$_POST['id_user']??"";
            $name=$_POST['name']??"";
            $email=$_POST['email']??"";
            $phone=$_POST['phone']??"";
            $address=$_POST['address']??"";
            $note=$_POST['note']??"";
            $status = $_POST["status"]??1;
            if($name!=""){
                if($id==!""){
                    $stmt = $conn -> prepare("UPDATE orders set name = '$name', 
                    email = '$email', phone = '$phone', address = '$address', note = '$note', status = $status WHERE id =$id");
                    $stmt->execute();
                    header('Location: admin.php?page=orders'); 
                    // exit();
                }else{
                    $stmt = $conn -> prepare("INSERT INTO orders(id_user, name, email, phone, address, note, order_date, status)
                    VALUES ('$id_user', '$name', '$email', '$phone', '$address', '$note', CURRENT_TIMESTAMP, $status)");
                    $stmt -> execute();
                    header('Location: admin.php?page=orders'); /*die()*/;
                }
            }else $msg="Vui lòng nhập đầy đủ thông tin";         
        }
      ?>
      <div class="container col-8 m-auto">
      <h2 class="py-2 text-center h4 "><?= $h2 ?></h2>
      <form class="form" action="" method="post" enctype="multipart/form-data">
            <div class="input mb-3">
                <label for="">ID</label>
                <input type="text" name="id" value="<?= $order[0]??"" ?>" disabled class="form-control bg-light" >
            </div>
            <div class="input mb-3" style="display: <?php if($id != ""){echo "none";}else{echo "block";}?>;">
                <label for="">ID User</label>
                <input type="text" name="id_user" value="<?= $order[1]??"" ?>"class="form-control bg-light" >
            </div>
            <div class="input mb-3">
                <label for="">Tên</label>
                <input type="text" name="name" value="<?= $order[2]??"" ?>" required class="form-control bg-light" >
            </div>
            <div class="input mb-3">
                <label for="">Email</label>
                <input type="text" name="email" value="<?= $order[3]??"" ?>" required class="form-control bg-light" >
            </div>
            <div class="input mb-3">
                <label for="">Số Điện Thoại</label>
                <input type="text" name="phone" value="<?= $order[4]??"" ?>" required class="form-control bg-light" >
            </div>
            <div class="input mb-3">
                <label for="img">Địa Chỉ</label>
                <input type="text" name="address" value="<?= $order[5]??""?>" required class="form-control bg-light" >
            </div>
            <div class="input mb-3">
                <label for="img">Ghi Chú</label>
                <input type="text" name="note" value="<?= $order[6]??""?>" class="form-control bg-light" >
            </div>
            <div class="input mb-3">
                <label for="">Ngày Đặt Hàng</label>
                <input type="text" value="<?= $order[7]??""?>" disabled class="form-control bg-light" >
            </div>
            <div class="input mb-3">
                <label for="">Tổng Tiền</label>
                <input type="text" value="<?= $order[10]??"" ?>" disabled class="form-control bg-light" >
            </div>
            <div class="input mb-3">
                <label for="">Trạng Thái</label>
                <select name="status" id="" class="form-control bg-light" >
                    <option value="0">--Chọn Trạng Thái--</option>
                    <?php
                            $stmt = $conn -> prepare("SELECT * FROM status");
                            $stmt->execute();
                            while($status = $stmt -> fetch()){
                                if ($status[0] == $order[8]){
                                    echo "<option value='$status[0]' selected >$status[1]</option>";
                                }
                                else{
                                    echo "<option value='$status[0]'>$status[1]</option>";
                                }  
                            }
                    ?>
                </select>
            </div>
            <div class="input mt-3">
                <button class="btn btn-success px-4" name="submit">Lưu</button>
                <a <?php if($id == ""){echo "style='display: none;'";}?> class="btn btn-success px-4" name="to_order_details" href="admin.php?page=order_details&id_order=<?=$id?>">Xem Chi Tiết</a>
            </div>
            
            <div class="error-msg"><?= $msg ?></div>
        </form>
        
      </div>
      </div> <!-- tab-pane -->
   </div>
   </div>
</body>
</html>