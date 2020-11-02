<?php

    require_once "settings/connect.php";

    $status = mysqli_query($connect, "SELECT * FROM `users_add` WHERE `token` = '".$_GET['token']."'");
    $stat = mysqli_fetch_assoc($status);

    if ($stat['count2'] >= $stat['count'] or empty($stat)) {
        echo '<h2>По этой ссылке больше зарегистрироваться нельзя!</h2>';
        exit;
    }

    if (isset($_POST['submit'])) {
        $err = array();

        if (!empty($_POST['login'])) {

            if (!empty($_POST['pass']) and strcmp($_POST['pass'], $_POST['pass2']) === 0) {

                $token = openssl_random_pseudo_bytes(10);
                $token = bin2hex($token);

                $users = mysqli_query($connect, "SELECT * FROM `users_add` WHERE `token` = '".$_GET['token']."'");
                $user = mysqli_fetch_assoc($users);

                mysqli_query($connect, "INSERT INTO `user` (`name`, `pass`, `groups`, `token`) VALUES ('".$_POST['login']."', '".$_POST['pass']."', '".$user['groups']."', '')");
                mysqli_query($connect, "UPDATE `users_add` SET `count2` = `count2` + 1 WHERE `users_add`.`id` = ". $user['id']);
    
                header("Location: index.php");

            }else{
                $err[] = 'Строки не совпадают';
            }
        }else{
            $err[] = 'Ошибка'; 
        }
    }

?>


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
    <span class="login-title">Регистрация</span>
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
        <div class="login-form">
            <label for="pillInput">Пароль ещё раз</label>
            <input name="pass2" type="password" class="form-control input-square" id="squareInput" placeholder="password">
        </div>
    </div>

    <div class="login_action">
        <div class="login-bottom">
            <input name="submit" type='submit' class="btn btn-success" value="Sign up">
        </div>
    </div>
    </form>

    </div>

</body>
</html>