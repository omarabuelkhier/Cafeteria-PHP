<?php
session_start();
if ($_SESSION["login"]){
    header("Location: ../order/create-order.php");
}else{
    session_destroy();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
    <div class="content" style="margin-top:-50px">
    <img src="login.jpg" style="border-radius: 50%;" width="250px" height="170px" alt="">
    <div class="text">
        Login
    </div>
    <form action="loginvalidation.php" method="post">
        <div class="field">
            <input type="text" name="email" required>
            <span class=" fas fa-user"></span>
            <label>Email</label>
        </div>

        <div class="field">
            <input type="password" name="password" required>
            <span class="fas fa-lock"></span>
            <label>Password</label>
        </div>

        <div class="forgot-pass">
            <a href="#">Forgot Password?</a>
        </div>
        <button type="submit" name="login_btn">Sign in</button>
        <div class="sign-up">
            Not registered
            <a href="#">signup now </a>
        </div>
        <div class="sign-up">
            Back to home
            <a  href="home.php"> Home Page </a>
        </div>

    </form>
</div>
</body>
</html>