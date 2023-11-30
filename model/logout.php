<?php
    require '../config/config.php';
    require 'conn.php';
    if (isset($_COOKIE['usr'])) {
        setcookie('usr', $user['username'], time()+1,"/");
        setcookie('name', $user['name'], time()+1,"/");
        setcookie('img', $user['img'], time()+1,"/");
        setcookie('adm', $user['role'], time()+1,"/");
        header("location: ../index.php");
    }else{
        echo "Không có tk để thoát";
        setcookie('usr',"", time()+1,"/");
        setcookie('name', "", time()+1,"/");
        setcookie('img', "", time()+1,"/");
        setcookie('adm', "", time()+1,"/");
    }
    
?>