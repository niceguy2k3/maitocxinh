<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Modern Login Page | AsmrProg</title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="../model/register_process.php" method="post" enctype="multipart/form-data">
                <h1>Create Account</h1>
                <span>or use your email for registeration</span>
                <input type="text" class="form-control" name="usr" placeholder="Tài Khoản">
                <input type="text" class="form-control" name="email" placeholder="Email">
                <input type="text" class="form-control" name="phone" placeholder="Số Điện Thoại">
                <input type="text" class="form-control" name="name" placeholder="Họ và Tên">
                <input type="password" class="form-control" name="pwd" placeholder="Mật Khẩu">
                <input type="password" class="form-control" name="cfm" placeholder="Xác Nhận Mật Khẩu">
                <input type="file" class="form-control" name="file" placeholder="Image">
                <button  name="btn">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="../model/login_process.php" method="post">
                <h1>Sign In</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>or use your email password</span>
                <input type="text" class="form-control" name="usr" placeholder="Tài Khoản">
                <input type="password" class="form-control" name="pwd" placeholder="Mật Khẩu">
                <a href="#">Forget Your Password?</a>
                <button>Sign In</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>