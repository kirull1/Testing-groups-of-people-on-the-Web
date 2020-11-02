<?php

    require_once "../settings/config.php";

    function Addtable($Table){
        define('MYSQL_SERVER', $Table['server']);
        define('MYSQL_USER', $Table['user']);
        define('MYSQL_PASSWORD', $Table['password']);
        define('MYSQL_DB', $Table['db']);
    
        $connect = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);

        mysqli_query($connect, "CREATE TABLE `answer` (
            `id` int(11) NOT NULL,
            `user_id` int(11) NOT NULL,
            `answ` text NOT NULL,
            `test_token` varchar(255) NOT NULL
          )");
        mysqli_query($connect, "CREATE TABLE `groups` (
            `id` int(11) NOT NULL,
            `title` varchar(255) NOT NULL
          )");  
        mysqli_query($connect, "CREATE TABLE `qq` (
            `id` int(11) NOT NULL,
            `title` text NOT NULL,
            `qq` text NOT NULL,
            `answer` text NOT NULL,
            `user` text DEFAULT NULL,
            `user_comp` text NOT NULL,
            `status` int(11) NOT NULL DEFAULT 0,
            `token` varchar(255) NOT NULL
          )");  
        mysqli_query($connect, "CREATE TABLE `user` (
            `id` int(11) NOT NULL,
            `name` varchar(255) NOT NULL,
            `pass` varchar(255) NOT NULL,
            `groups` varchar(255) NOT NULL,
            `status` int(11) NOT NULL DEFAULT 0,
            `token` varchar(255) NOT NULL
          )");  
        mysqli_query($connect, "CREATE TABLE `users_add` (
            `id` int(11) NOT NULL,
            `token` varchar(50) NOT NULL,
            `groups` varchar(255) NOT NULL,
            `count` int(11) NOT NULL,
            `count2` int(11) NOT NULL
          )");  
        
        mysqli_query($connect, "ALTER TABLE `answer` ADD PRIMARY KEY (`id`);");  
        mysqli_query($connect, "ALTER TABLE `groups` ADD PRIMARY KEY (`id`);");  
        mysqli_query($connect, "ALTER TABLE `qq` ADD PRIMARY KEY (`id`);");  
        mysqli_query($connect, "ALTER TABLE `user` ADD PRIMARY KEY (`id`);");  
        mysqli_query($connect, "ALTER TABLE `users_add` ADD PRIMARY KEY (`id`);");
        
        mysqli_query($connect, "ALTER TABLE `answer` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;");  
        mysqli_query($connect, "ALTER TABLE `groups` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;");  
        mysqli_query($connect, "ALTER TABLE `qq` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;");  
        mysqli_query($connect, "ALTER TABLE `user` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;");  
        mysqli_query($connect, "ALTER TABLE `users_add` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;COMMIT;");  
    }

    if (!empty($server_connect)) Addtable($rb_config['conf'])

?>