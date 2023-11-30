<?php
    require '../config/config.php';
    require 'conn.php';
    if (isset($_COOKIE['usr'])) {
        $usr = $_COOKIE['usr'];
        $stmt = $conn -> prepare("DELETE FROM usr WHERE username =  '$usr'");
        $stmt -> execute();
        $user = $stmt -> fetch();
        if ($_COOKIE['img'] != "user.png") {
            $file_name = "../uploads_user/" . $_COOKIE['img'];
            unlink("$file_name");
        }
        setcookie('usr', $user['username'], time()+1,"/");
        setcookie('name', $user['name'], time()+1,"/");
        setcookie('img', $user['img'], time()+1,"/");
        echo "<script>alert('Xóa Tài Khoảng Thành Công');</script>";
        echo "<script> window.location.href='../index.php';</script>";
    }else{
        echo "lo con cac goi";
    }
?>