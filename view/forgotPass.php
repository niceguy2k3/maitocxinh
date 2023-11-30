<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Quên Mật Khẩu</title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-in">
            <form action="../model/forgotPass_process.php" method="post">
                <h1>Quên Mật Khẩu</h1>
                <input type="email" class="form-control" name="email" placeholder="Email">
                <input type="text" class="form-control" name="usr" placeholder="Tên Đăng Nhập">
                <button>Gửi Mật Khẩu Mới</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-right">
                    <h1>Bạn Quên Mật Khẩu</h1>
                    <p>Lỗi Của Bạn Thì Bạn Chịu!</p>
                </div>
            </div>
        </div>
    </div>

    <!-- <script src="../function/login.js"></script> -->
</body>

</html>