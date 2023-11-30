<?php
session_start();
include("../config/config.php");
include("../model/conn.php");
$id_cmt=$_POST['id_cmt']??0;
if($id_cmt>0){
    $stmt = $conn -> prepare("DELETE FROM cmt WHERE id = $id_cmt");
    $stmt -> execute();
    header("");
}
else echo $id_cmt;
?>