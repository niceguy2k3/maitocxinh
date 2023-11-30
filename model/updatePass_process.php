<?php
    require '../config/config.php';
    require 'conn.php';
    if (isset($_POST['btn'])) {
        if (isset($_COOKIE['usr'])) {
            $usr = $_COOKIE['usr'];
            if (isset($_POST['pwd']) && ($_POST['pwd'] != "") && ($_POST['cfm'] != "") && ($_POST['pwd'] == $_POST['cfm'])) {
                $pwd = $_POST['pwd'];
                echo $pwd . "<br>";
                $stmt = $conn -> prepare("UPDATE usr SET pass = ?, update_at = CURRENT_TIMESTAMP WHERE username = '$usr'");
                $stmt -> bindParam(1, password_hash($pwd, PASSWORD_BCRYPT));
                $stmt -> execute();
                $user = $stmt -> fetch();
                echo "<script>alert('Đổi mật khẩu thành công');</script>";
                echo "<script> window.location.href='../index.php';</script>";
            }else{
                echo "<script>alert('Đổi mật khẩu THẤT BẠI');</script>";
                echo "<script> window.location.href='../index.php';</script>";
            }
        }else{
            echo "<script>alert('Bạn Chưa Đăng Nhập');</script>";
            echo "<script> window.location.href='../view/login.php';</script>";
        }  
    }
?>