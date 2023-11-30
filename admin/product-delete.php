<?php
require "../config/config.php";
require "../model/conn.php";

    if (isset($_POST["id_delete"])) {
        $id = $_POST["id_delete"];
        $stmt = $conn -> prepare("UPDATE product set deleted = 1 WHERE id = $id");
        $stmt -> execute();
        echo "Hello";
    }else{
        header("location: admin.php");
        echo "cút";
    }
    if (isset($_POST["id_restore"])) {
        $id = $_POST["id_restore"];
        $stmt = $conn -> prepare("UPDATE product set deleted = 0 WHERE id = $id");
        $stmt -> execute();
        echo "Hello";
    }else{
        header("location: admin.php");
        echo "cút";
    }
?>