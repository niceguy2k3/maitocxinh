<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Cập Nhật Mật Khẩu Mới</title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-in">
            <form action="../model/resetPass_process.php" method="post">
                <h1>Cập Nhật Mật Khẩu Mới</h1>
                <input type="password" class="form-control" name="pwd" placeholder="Mật Khẩu">
                <input type="password" class="form-control" name="cfm" placeholder="Xác Nhận Mật Khẩu">
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