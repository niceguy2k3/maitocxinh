<?php
    require '../config/config.php';
    require 'conn.php';
    if (isset($_POST['btn'])) {
        if(isset($_COOKIE['usr'])) {
            $usr = $_COOKIE['usr'];
            $stmt = $conn -> prepare("SELECT * FROM usr WHERE username =  '$usr'");
            $stmt -> execute();
            $user = $stmt -> fetch();
            if ($user) {
                if (isset($_POST['email']) && ($_POST['email'] != "")) {
                    $email = $_POST['email'];
                    echo $email . "<br>";
                    $stmt = $conn -> prepare("UPDATE usr SET Email = '$email' WHERE username = '$usr'");
                    $stmt -> execute();
                    $user = $stmt -> fetch();
                }
                if (isset($_POST['name']) && ($_POST['name'] != "")) {
                    $name = $_POST['name'];
                    echo $name . "<br>";
                    $stmt = $conn -> prepare("UPDATE usr SET name = '$name' WHERE username = '$usr'");
                    $stmt -> execute();
                    $user = $stmt -> fetch();
                    // setcookie('usr', $user['username'], time()+7200,"/");
                    // setcookie('name', $user['name'], time()+7200,"/");
                    // setcookie('img', $user['img'], time()+7200,"/");
                }
                if (isset($_FILES['file'])) {
                    $file = $_FILES['file']['name'];
                    if ($file != "") {
                        //delete file cu
                        $stmt = $conn -> prepare("SELECT * From usr WHERE username = '$usr'");
                        $stmt -> execute();
                        $user = $stmt -> fetch();
                        if ($user['img'] != "user.png") {
                            $file_delete = "../uploads_user/" . $user['img'];
                            unlink("$file_delete");
                        }
                        //update file moi
                        $file_name = $usr."-".$file;
                        echo "<br> File_name: ".$file_name;
                        $stmt = $conn -> prepare("UPDATE usr SET img = '$file_name' WHERE username = '$usr'");
                        $stmt -> execute();
                        $user = $stmt -> fetch();

                        
                        // setcookie('usr', $user['username'], time()+7200,"/");
                        // setcookie('name', $user['name'], time()+7200,"/");
                        // setcookie('img', $user['img'], time()+7200,"/");

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
                        }else{
                            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                            echo "<script>alert('Đổi Thông Tin Thành Công');</script>";
                            echo "<script> window.location.href='../index.php';</script>";
                            echo "The file ". htmlspecialchars( basename( $_FILES["file"]["name"])). " has been uploaded.";
                            } else {
                            echo "Sorry, there was an error uploading your file.";
                            }
                        }
                    }else{
                        echo "<script>alert('Đổi Thông Tin Thành Công');</script>";
                        echo "<script> window.location.href='../index.php';</script>";
                    }
                }
                date_default_timezone_set("Asia/Ho_Chi_Minh");
                $update_at = date('H:i:s d/m/Y', time());
                $stmt = $conn -> prepare("UPDATE usr SET update_at = CURRENT_TIMESTAMP WHERE username = '$usr'");
                $stmt -> execute();
                $user = $stmt -> fetch();
            }
        }else{
            echo "<script>alert('Bạn chưa đăng nhập');</script>";
        }
    }
?>