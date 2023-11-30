<?php
require "../config/config.php";
require "../model/conn.php";

    if (isset($_POST["id_delete"])) {
        $id = $_POST["id_delete"];
        $stmt = $conn -> prepare("UPDATE post_categories set deleted = 1 WHERE id = $id");
        $stmt -> execute();
        $stmt = $conn -> prepare("UPDATE post set deleted = 1 WHERE id_cate = $id");
        $stmt -> execute();
        echo "Hello";
    }else{
        header("location: admin.php");
        echo "cút";
    }
    if (isset($_POST['id_delete_all'])) {
        foreach ($_POST["id_delete_all"] as $id) {
            $stmt = $conn -> prepare("UPDATE post_categories set deleted = 1 WHERE id = $id");
            $stmt -> execute();
            $stmt = $conn -> prepare("UPDATE post set deleted = 1 WHERE id_cate = $id");
            $stmt -> execute();
            echo "Hello";
        }
    }else{
        header("location: admin.php");
        echo "cút";
    }
    if (isset($_POST["id_restore"])) {
        $id = $_POST["id_restore"];
        $stmt = $conn -> prepare("UPDATE post_categories set deleted = 0 WHERE id = $id");
        $stmt -> execute();
        $stmt = $conn -> prepare("UPDATE post set deleted = 0 WHERE id_cate = $id");
        $stmt -> execute();
        echo "Hello";
    }else{
        header("location: admin.php");
        echo "cút";
    }
    if (isset($_POST['id_restore_all'])) {
        foreach ($_POST["id_restore_all"] as $id) {
            $stmt = $conn -> prepare("UPDATE post_categories set deleted = 0 WHERE id = $id");
            $stmt -> execute();
            $stmt = $conn -> prepare("UPDATE post set deleted = 0 WHERE id_cate = $id");
            $stmt -> execute();
            echo "Hello";
        }
    }else{
        header("location: admin.php");
        echo "cút";
    }
?>