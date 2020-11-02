<?php
    include "settings/function_login.php";

    if (login_check($rb_config) === true) header("Location: index.php");
    
    if (isset($_POST['submit'])) {
        $login['login'] = $_POST['login'];
        $login['password'] = $_POST['pass'];
        $err[] = login_db($rb_config, $login);
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- bootstrap style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- bootstrap style end -->

    <link rel="stylesheet" href="style/style.css">

    <title>Kirulls - Test</title>
</head>
<body style="background-color: #f2f3f8; display: flex; justify-content: center; align-items: center;">
    
    <div class="login">

    <div class="login-header">
    <span class="login-title">Login</span>
    </div>
    <div class="error"><span><?php echo $err[0] ?></span></div>
    <form method="POST">
    <div class="login-body">
        <div class="login-form">
            <label for="pillInput">Логин</label>
            <input name="login" type="text" class="form-control input-square" id="squareInput" placeholder="login">
        </div>
        <div class="login-form">
            <label for="pillInput">Пароль</label>
            <input name="pass" type="password" class="form-control input-square" id="squareInput" placeholder="password">
        </div>
    </div>

    <div class="login_action">
        <div class="login-bottom">
            <input name="submit" type='submit' class="btn btn-success" value="login">
        </div>
    </div>
    </form>

    </div>

</body>
</html>