<?php

    require_once "rb.php";
    require "config.php";

    function login_check($rb_config){
        if (isset($_COOKIE['id']) AND isset($_COOKIE['login']) AND isset($_COOKIE['password'])) {
            R::setup( 'mysql:host='.$rb_config['conf']['server'].';dbname='.$rb_config['conf']['db'], $rb_config['conf']['user'], $rb_config['conf']['password'] );
            $users = R::find('user', 'id = ? AND name = ? AND pass = ?', array($_COOKIE['id'], $_COOKIE['login'], $_COOKIE['password']));
            foreach ($users as $key => $value);
            if ($users[$key]['id'] == $_COOKIE['id']) {
                if ($users[$key]['name'] == $_COOKIE['login']) {
                    if ($users[$key]['pass'] == $_COOKIE['password']) {
                        return true;
                    }else header("Location: logout.php");
                }else header("Location: logout.php");
            }else header("Location: logout.php");
        }else return false;
    }
    function login_db($rb_config, $login){
        R::setup( 'mysql:host='.$rb_config['conf']['server'].';dbname='.$rb_config['conf']['db'], $rb_config['conf']['user'], $rb_config['conf']['password'] );
        $user = R::find('user', 'name = ? AND pass = ?', array($login['login'], $login['password']));
        foreach ($user as $key => $value);
            if (!empty($user[$key]['name'])) {
                if (!empty($user[$key]['pass'])) {
                    setcookie('id', $user[$key]['id'], time() + 3600 * 24 * 365, "/");
                    setcookie('login', $user[$key]['name'], time() + 3600 * 24 * 365, "/");
                    setcookie('password', $user[$key]['pass'], time() + 3600 * 24 * 365, "/");
                    setcookie('status', $user[$key]['status'], time() + 3600 * 24 * 365, "/");

                    header("Location: index.php");
                }else{$error[] = 'Неверный логин или пароль';}
            }else{$error[] = 'Неверный логин или пароль';}
        if (!empty($error)) 
        return $error[0]; 
    }
    function admin_status(){
        if ($_COOKIE['status'] != 1) {
            header("Location: index.php");
        }
    }

?>