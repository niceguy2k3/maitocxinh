<?php
    include "../config/config.php";
    include "../model/conn.php";
    if (isset($_POST['id_show'])) {
        foreach ($_POST["id_show"] as $id) {
            $stmt = $conn -> prepare("UPDATE post_categories set status = 1 WHERE id = $id");
            $stmt -> execute();
            $stmt = $conn -> prepare("UPDATE post set status = 1 WHERE id_cate = $id");
            $stmt -> execute();
        }
        
    }else{
        header("location: admin.php");
        echo "cút";
    }
    if (isset($_POST['id_hide'])) {
        foreach ($_POST["id_hide"] as $id) {
            $stmt = $conn -> prepare("UPDATE post_categories set status = 0 WHERE id = $id");
            $stmt -> execute();
            $stmt = $conn -> prepare("UPDATE post set status = 0 WHERE id_cate = $id");
            $stmt -> execute();
        }
        
    }else{
        header("location: admin.php");
        echo "cút";
    }
?>