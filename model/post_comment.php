<?php
    include("../config/config.php");
    include("../model/conn.php");
    if (isset($_COOKIE["usr"])) {
        if (isset($_POST["submit"])) {
            $content = $_POST["content"];
            $id_prod = $_POST["id_prod"];
            $id_user = $_POST["id_user"];

            $stmt = $conn -> prepare("INSERT INTO cmt(content, id_prod, id_user, create_at, update_at)
            VALUES('$content', $id_prod, '$id_user', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");
            $stmt -> execute();
            header("location: ../index.php?page=product&id_prod=$id_prod");
        }else{
            echo "cút ";
        }
    }
?>