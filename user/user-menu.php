<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="user.php?page=info">Thông Tin Tài Khoản</a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="user.php?page=pass">Quản Lý Mật Khẩu</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="user.php?page=orders">Đơn Hàng Của Bạn</a>
    </li>

    <li style="display: none;" class="nav-item">
        <a class="nav-link" data-toggle="tab" href="user.php?page=order_details">Chi Tiết Đơn Hàng</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="user.php?page=comment">Bình Luận</a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link text-danger" href="#">Chào <?php echo $_COOKIE['usr']?></a>
    </li>
    <!--<li class="nav-item">-->
    <!--    <a class="nav-link" href="../" target="public">Trang Chủ</a>-->
    <!--</li>-->
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="../">Trang Chủ</a>
    </li>
</ul>
