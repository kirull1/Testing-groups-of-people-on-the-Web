<?php

    setcookie('id', $_COOKIE['id'], time() - 3600 * 24 * 365, "/");
    setcookie('login', $_COOKIE['pass'], time() - 3600 * 24 * 365, "/");
    setcookie('password', $_COOKIE['name'], time() - 3600 * 24 * 365, "/");
    setcookie('status', $_COOKIE['status'], time() - 3600 * 24 * 365, "/");

    header("Location: login.php");

?>