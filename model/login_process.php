<?php
    require '../config/config.php';
    require 'conn.php';
    if(isset($_POST['usr']) && isset($_POST['pwd']) && $_POST['usr'] != "" && $_POST['pwd'] != ""){
        $usr = $_POST['usr'];
        $pwd = $_POST['pwd'];
    }else{
        echo "<script>alert('Hãy nhập đầy đủ Username và Password !');</script>";
        echo "<script> window.location.href='../view/login.php';</script>";
    }
    $stmt = $conn -> prepare("SELECT * FROM usr WHERE username = ? /*and pass = ?*/");
    $stmt -> bindParam(1,$usr);
    // $stmt -> bindParam(2,$pwd);
    $stmt -> execute();
    $user = $stmt -> fetch();
    if($user && password_verify($pwd, $user['pass'])){
        setcookie('adm', $user['role'], time()+7200,"/");
        echo $user['role'];
        echo $_COOKIE['adm'];
        setcookie('usr', $user['username'], time()+7200,"/");
        // setcookie('name', $user['name'], time()+7200,"/");
        // setcookie('img', $user['img'], time()+7200,"/");

        header("location: ../index.php");
    }else{
        echo "<script>alert('Username hoặc Password KHÔNG ĐÚNG !');</script>";
        echo "<script> window.location.href='../view/login.php';</script>";
    }
?>