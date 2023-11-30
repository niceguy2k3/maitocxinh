<?php
    require '../config/config.php';
    require 'conn.php';
    if (isset($_POST['btn'])) {
        $deleted = 1;
        $role = 1;
        if ($_POST['name'] == "") {
            $name = "User";
        }else{
            $name = $_POST['name'];
        }
        if ($_POST['usr'] != "") {
            $usr = $_POST['usr'];
        }else{
            echo "<script>alert('Username không được để trống');</script>";
            echo "<script> window.location.href='../view/login-register.php;</script>";
        }

        if ($_POST['email'] != "") {
            $email = $_POST['email'];
        }else{
            echo "<script>alert('Email không được để trống');</script>";
            echo "<script> window.location.href='../view/login-register.php';</script>";
        }

        $phone = $_POST['phone']??"";
        

        if (isset($_POST['pwd']) && ($_POST['pwd'] == $_POST['cfm'])) {
            $pwd = $_POST['pwd'];
            echo "Name : " . $name . "<br> Username: " . $usr ."<br> Password: " . $pwd;
            if (isset($_FILES['file'])) {
                if ($_FILES['file']['name'] != "") {
                    $file = $_FILES['file']['name'];
                    $file_name = $usr."-".$file;
                    echo "<br> File_name: ".$file_name;
                }else {
                    $file_name = "user.png";
                    echo "<br> File_name: ".$file_name;
                }
            }
            $stmt = $conn -> prepare("SELECT * FROM usr WHERE username =  '$usr'");
            $stmt -> execute();
            $user = $stmt -> fetch();
            if ($user) {
                echo "<script>alert('Username tồn tại');</script>";
                echo "<script> window.location.href='../view/login-register.php';</script>";
            }else{
                $stmt = $conn -> prepare("INSERT INTO usr(username, pass, name, img, email, role, deleted, create_at, update_at, SDT) VALUES(?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, ?)");
                $stmt -> bindParam(1, $usr);
                $stmt -> bindParam(2, password_hash($pwd, PASSWORD_BCRYPT));
                $stmt -> bindParam(3, $name);
                $stmt -> bindParam(4, $file_name);
                $stmt -> bindParam(5, $email);
                $stmt -> bindParam(6, $role);
                $stmt -> bindParam(7, $deleted);
                $stmt -> bindParam(8, $phone);
                $stmt -> execute();
                $user = $stmt -> fetch();
                // xử lý image
                $target_dir = "../uploads_user/";
                $target_file = $target_dir . $file_name;
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                // Check if image file is a actual image or fake image
                if(isset($_POST["submit"])) {
                    $check = getimagesize($_FILES["file"]["tmp_name"]);
                    if($check !== false) {
                        echo "File is an image - " . $check["mime"] . ".";
                        $uploadOk = 1;
                    } else {
                        echo "File is not an image.";
                        $uploadOk = 0;
                    }
                }

                // Check if file already exists
                if (file_exists($target_file)) {
                    echo "Sorry, file already exists.";
                    $uploadOk = 0;
                }

                // Check file size
                if ($_FILES["file"]["size"] > 5000000) {
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    
                    echo "The file ". htmlspecialchars( basename( $_FILES["file"]["name"])). " has been uploaded.";
                    } else {
                    echo "Sorry, there was an error uploading your file.";
                    }
                }
                echo "<script>alert('Đăng Ký Thành Công');</script>";
                echo "<script> window.location.href='../view/login-register.php';</script>";
            }
        }else{
            echo "<script>alert('Mật Khẩu Không Khớp');</script>";
            echo "<script> window.location.href='../view/login-register.php';</script>";
        }
        
    }else{
        echo "<script> window.location.href='../index.php';</script>";
    }
            
    
    
?>