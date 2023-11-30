<?php

function convert_name($str) {
    // hàm chuyển Tiếng Việt thành tieng-viet;
    $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
    $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
    $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
    $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
    $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
    $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
    $str = preg_replace("/(đ)/", 'd', $str);
    $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
    $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
    $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
    $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
    $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
    $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
    $str = preg_replace("/(Đ)/", 'D', $str);
    $str = preg_replace("/(\“|\”|\‘|\’|\,|\!|\&|\;|\@|\#|\%|\~|\`|\=|\_|\'|\]|\[|\}|\{|\)|\(|\+|\^)/", '-', $str);
    $str = preg_replace("/( )/", '-', $str);
    //strtolower($str) -> viết hoa thành viết thường
    return strtolower($str);
}
    // $str1 = "Tài liệu học PHP";
    // echo convert_name($str1);
    // $number = '24082017.56';
 
    // // trường hợp có 1 tham số
    // $format_number_1 = number_format($number);
    // echo "1 tham số - " . $format_number_1 . "<br />";
    
    // // trường hợp có 4 tham số
    // $format_number_4 = number_format($number, 2, ',', ' ');
    // echo "4 tham số - " . $format_number_4;
?>
<html>
    <style>
        .container{
            position: relative;
            border: 1px solid red;
            width: 500px;
            height: 500px;
            /* overflow: hidden; */
        }
        .container>.box{
            position: absolute;
            top: 0;
            width: 100%;
            height: 100%;
        }
        .box1{
            background-color: green;
            left: 0;
        }
        .box2{
            left: 500px;
            background-color: red;
        }
    </style>
    <body>
        <div class="container">
            <div class="box box1" id="box1"></div>
            <div class="box box2"></div>
        </div>
        <button id="left"  onclick="left()">
            Click here
        </button>
    </body>
</html>
<script>
    function left(){
        const giatri = document.querySelector("#box1");
        const left = document.getElementsByClassName("box");
        // for(var i = 0; i <= 2; i++){
        //     left[i].style.left += 500;
        // }
        left[1].style.left += 1000;
        
    }
</script>
