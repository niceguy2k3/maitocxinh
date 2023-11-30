<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Đăng Nhập|Đăng Ký </title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="../model/register_process.php" method="post" enctype="multipart/form-data">
                <h1>Đăng Ký</h1>
                
                <input type="text" class="form-control" name="usr" placeholder="Tài Khoản">
                <input type="text" class="form-control" name="email" placeholder="Email">
                <input type="text" class="form-control" name="phone" placeholder="Số Điện Thoại">
                <input type="text" class="form-control" name="name" placeholder="Họ và Tên">
                <input type="password" class="form-control" name="pwd" placeholder="Mật Khẩu">
                <input type="password" class="form-control" name="cfm" placeholder="Xác Nhận Mật Khẩu">
                <input type="file" class="form-control" name="file" placeholder="Image">
                <button  name="btn">Đăng Ký</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="../model/login_process.php" method="post">
                <h1>Đăng Nhập</h1>

               
                <input type="text" class="form-control" name="usr" placeholder="Tài Khoản">
                <input type="password" class="form-control" name="pwd" placeholder="Mật Khẩu">
                <a href="forgotPass.php">Quên Mật Khẩu?</a>
                <button>Đăng Nhập</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Chào Mừng Bạn Trở Lại</h1>
                    <p>Đăng Nhập Để Sử Dụng Dịch Vụ Của Chúng Tôi</p>
                    <button class="hidden" id="login">Đăng Nhập</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Chào Mừng Bạn</h1>
                    <p>Đăng Ký Để Sử Dụng Dịch Vụ Của Chúng Tôi</p>
                    <button class="hidden" id="register">Đăng Ký</button>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>