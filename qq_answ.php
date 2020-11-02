<?php

    require_once "settings/connect.php";
    admin_status();

    if (isset($_POST['submit_saves'])) {
        foreach ($_POST as $key => $value) {
            if ($key != 'table_length' and $key != 'submit_saves') {
                $res .= $key.'.';
            }
        }
        mysqli_query($connect, "UPDATE `qq` SET `user` = '".$res."' WHERE `qq`.`token` = '".$_GET['token']."'");
        header("Location: qq_answ.php?token=".$_GET['token']);
    }

    include "settings/doctype.php";


?>
        <link rel="stylesheet" type="text/css" href="style/datatables.min.css"/>
        <script type="text/javascript" src="js/datatables.min.js"></script>
        <script type="text/javascript" src="js/table.js" class="init"></script>

    <section class="question">
        <div class="ques_answ">
        <form method="POST">                
                <?php
                    if (empty($_GET['token'])) {
                        if ($_GET['add'] == 'true') {
                            echo '<h2>Запись создана!</h2>';
                            if (!empty($_GET['link'])) {
                                echo '<p>Передайте эту ссылку новому пользователю.</p>';
                                echo '<a href="new_user.php?token='.$_GET['link'].'">new_user.php?token='.$_GET['link'].'</a>';
                            }
                        }else{
                            echo 'Ошибка';
                        }
                        exit;
                    }
                    $users = mysqli_query($connect, "SELECT `user`,`id` FROM `qq` WHERE `token` ='".$_GET['token']."'");
                    $user = mysqli_fetch_assoc($users);

                    if ($user['user'] == null and !empty($user)) {
                        echo '<table id="table" class="table table-striped"><thead><tr class="table_tr"><th>Имя</th><th>Группа</th><th>Действие</th></tr></thead><tbody>';
                        $count_users = mysqli_query($connect, "SELECT * FROM `user` ORDER BY id DESC LIMIT 1");
                        $count_user = mysqli_fetch_assoc($count_users);

                        for ($i=1; $i < $count_user['id']+1; $i++) { 
                            $c_users = mysqli_query($connect, "SELECT * FROM `user` WHERE id =". $i);
                            $c_user = mysqli_fetch_assoc($c_users);

                            if (!empty($c_user)) {
                                echo '<tr class="table_tr">';
                                echo '<td>'.$c_user['name'].'</td>';
                                echo '<td>'.$c_user['groups'].'</td>';
                                echo '<td style="text-align: center;"><input name="'.$c_user['id'].'" type="checkbox" aria-label="Checkbox for following text input" checked></td>';
                            }
                        }
                        echo '</tbody></table>';

                        echo '<input value="Сохранить" class="btn btn-secondary" type="submit" name="submit_saves">';
                    }elseif ($user['id'] != 0) {
                        echo '<h2>Тест создан!</h2>';
                        echo '<p>Пройти его можно по ссылке или из личного кабинета.</p>';
                        echo '<a href="test_des.php?token='.$_GET['token'].'">test_des.php?token='.$_GET['token'].'</a>';
                    }else{
                        echo 'Ошибка';
                    }

                ?>
        </form>
        </div>
    </section>