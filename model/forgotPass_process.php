<?php
    require '../config/config.php';
    require 'conn.php';
    require '../PHPMailer/Buoi5Mailer.php';
    if (isset($_POST['email']) && isset($_POST['usr']) && $_POST['email'] != "" && $_POST['usr'] != "") {
        $linkReset = '<a href="https://maitocxinh.id.vn/view/resetPass.php">Bấm vào đây</a>';
        $email = $_POST['email'];
        $usr = $_POST['usr'];
        echo $usr . "<br>" . $email;
        $stmt = $conn -> prepare("SELECT * FROM usr WHERE username = ? and email = ?");
        $stmt -> bindParam(1,$usr);
        $stmt -> bindParam(2,$email);
        $stmt -> execute();
        $user = $stmt -> fetch();
        if($user){
            setcookie('idForgot', $user['username'], time()+600,"/");
            sendMail($email,"Hello Bae", "Hãy $linkReset để đặt lại mật khẩu <br> Bạn chỉ có 10 phút cho đến khi link HẾT hiệu lực");
            echo "<script>alert('Hãy kiểm tra Email của ngay bây giờ');</script>";
            echo "<script> window.location.href='../index.php';</script>";
        }else{
            echo "<script>alert('Username hoặc Email của bạn sai');</script>";
            echo "<script> window.location.href='../view/forgotPass.php';</script>";
        }
    }else {
        echo "<script>alert('Thiếu Email hoặc Username');</script>";
        echo "<script> window.location.href='../view/forgotPass.php';</script>";
    }
?>