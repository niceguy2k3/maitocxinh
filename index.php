<?php
session_start();
ob_start();
require 'config/config.php';
require 'model/conn.php';

include 'view/header.php';
if(isset($_REQUEST['page'])){
    $page = $_REQUEST['page'];  
    switch ($page){
        case 'about':
            include 'view/about.php';
            break;
        case 'blog':
            include 'view/blog.php';
            break;
        case 'contact':
            include 'view/contact.php';
            break;
        case 'login':
            echo "<script> window.location.href='view/login-register.php';</script>";
            break;
        case 'register':
            echo "<script> window.location.href='view/register.php';</script>";
            break;
        case 'admin':
            echo "<script> window.location.href='admin/admin.php';</script>";
            break;
        case 'user':
            echo "<script> window.location.href='user/user.php';</script>";
            break;
        case 'logout':
            echo "<script> window.location.href='model/logout.php';</script>";
            break;
        case 'categories':
            include 'view/categories.php';
            break;
        case 'product':
            include 'view/product.php';
            break;
        case 'cart':
            include 'view/cart.php';
            break;
        case 'thanks':
            include 'view/thanks.php';
            break;
        case 'pay':
            include 'view/pay.php';
            break;
        case 'search':
            include 'view/search.php';
            break;
        case 'blog-details':
            include 'view/blog-details.php';
            break;
        default:
            include 'view/banner.php';
            include 'view/promo.php';
            include 'view/bestSeller.php';
            break;  
    }
}else{
    include 'view/banner.php';
    include 'view/promo.php';
    require 'view/bestSeller.php';
}
include 'view/footer.php';
?>
