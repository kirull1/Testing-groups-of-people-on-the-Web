<?php

    include "settings/config.php";
    include "settings/function_login.php";

    if (login_check($rb_config) === false) header("Location: logout.php");

    define('MYSQL_SERVER', $server_connect);
    define('MYSQL_USER', $user_connect);
    define('MYSQL_PASSWORD', $password_connect);
    define('MYSQL_DB', $db_connect);

    function db_connect(){

        $connect = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB)
        or die("Error: ".mysqli_error($connect));
        if(!mysqli_set_charset($connect, "utf8mb4")){
            print("Error: ".mysqli_error($connect));
        }
        return $connect;
    }

    $connect = db_connect();

?>