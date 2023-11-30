<?php
    require '../config/config.php';
    require 'conn.php';
    if (isset($_COOKIE['idForgot'])) {
        if (isset($_POST['pwd']) ) {
            if (($_POST['pwd'] == $_POST['cfm'])) {
                $pwd = $_POST['pwd'];
                $idForgot = $_COOKIE['idForgot'];
                echo $idForgot;
                echo $pwd . "<br>";
                $stmt = $conn -> prepare("UPDATE usr SET pass = ?, update_at = CURRENT_TIMESTAMP WHERE username = '$idForgot'");
                $stmt -> bindParam(1, password_hash($pwd, PASSWORD_BCRYPT));
                $stmt -> execute();
                $user = $stmt -> fetch();
                echo "<script>alert('Đổi mật khẩu Thành Công');</script>";
                echo "<script> window.location.href='../view/login.php';</script>";
                setcookie('idForgot', "", time()+1, "/");
            }else{
                echo "<script>alert('Password không khớp');</script>";
                echo "<script> window.location.href='../view/resetPass.php';</script>";
            } 
        }
    }else{
        echo "<script>alert('Bạn đã hết thời gian đặt lại mật khẩu');</script>";
        echo "<script> window.location.href='../view/forgotPass.php';</script>";
    }
    
?>
