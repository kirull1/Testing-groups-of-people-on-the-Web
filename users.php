<?php    

    require_once "settings/connect.php";

    admin_status();

    if(isset($_POST['submit_add_users'])){
        header("Location: add_users.php?u=1");
    }
    if(isset($_POST['submit_add_group'])){
        header("Location: add_users.php?u=2");
    }
    if(isset($_POST['submit_add_users_link'])){
        header("Location: add_users.php?u=3");
    }

    include "settings/doctype.php";

?>
    <section class="question">
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation"><a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Пользователи</a></li>
        <li class="nav-item" role="presentation"><a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Группы</a></li>
        <li class="nav-item" role="presentation"><a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-link" role="tab" aria-controls="pills-profile" aria-selected="false">Ссылки</a></li>
    </ul>
    <div class="tab-content" id="pills-tabContent">

        <div id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" class="ques_answ tab-pane fade show active">
        <form method="POST">
            <?php

                    //Вывод пользователей.

                    echo '<table id="table" class="table table-striped"><thead><tr class="table_tr"><th>id</th><th>Имя</th><th>Группа</th><th>Удалить</th></tr></thead><tbody>';

                        $c_users = mysqli_query($connect, "SELECT * FROM `user` ORDER BY `id` DESC");
                        $c_user = mysqli_fetch_assoc($c_users);

                        $del_us = $c_user['id'];

                        for ($a=1; $a <= $del_us+1; $a++) { 
                            $c_users = mysqli_query($connect, "SELECT * FROM `user` WHERE id =". $a);
                            $c_user = mysqli_fetch_assoc($c_users);

                            if (!empty($c_user)) {
                                echo '<tr class="table_tr">';
                                echo '<td>'.$c_user['id'].'</td>';;
                                echo '<td>'.$c_user['name'].'</td>';
                                echo '<td>'.$c_user['groups'].'</td>';
                                echo '<td><button name="u'.$c_user['id'].'" type="submit" class="btn btn-sm btn-danger">Del</button></td>';
                            }
                        }
                    echo '</tbody></table>';

                    for ($i=0; $i < $del_us + 1; $i++) { 
                        if (isset($_POST['u'.$i])) {
                            mysqli_query($connect, "DELETE FROM `user` WHERE `user`.`id` = ". $i);
                            exit("<meta http-equiv='refresh' content='0'>");
                        }  
                    }    

            ?>
            <input value="Дабавить" class="btn btn-secondary" type="submit" name="submit_add_users">
            <input style="margin-left: 14px;" value="Создать ссылку" class="btn btn-secondary" type="submit" name="submit_add_users_link">
        </form>
        </div>

        <div id="pills-profile" role="tabpanel" aria-labelledby="pills-home-tab" class="ques_answ tab-pane fade show">

        <form method="POST">
            <?php

                    // Вывод групп.

                    echo '<table id="table" class="table table-striped"><thead><tr class="table_tr"><th>Название</th><th>Группа</th><th>Удалить</th></tr></thead><tbody>';

                        $c_users = mysqli_query($connect, "SELECT * FROM `groups` ORDER BY `id` DESC");
                        $c_user = mysqli_fetch_assoc($c_users);

                        $del_g = $c_user['id'];

                        for ($a=1; $a <= $del_g+1; $a++) { 
                            $c_users = mysqli_query($connect, "SELECT * FROM `groups` WHERE id =". $a);
                            $c_user = mysqli_fetch_assoc($c_users);

                            $count_g = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) FROM `user` WHERE `groups` = '". $c_user['title'] ."'"));

                            if (!empty($c_user)) {
                                echo '<tr class="table_tr">';
                                echo '<td>'.$c_user['title'].'</td>';
                                echo '<td>'.$count_g['COUNT(*)'].'</td>';
                                echo '<td><button name="v'.$c_user['id'].'" type="submit" class="btn btn-sm btn-danger">Del</button></td>';
                            }
                        }
                    echo '</tbody></table>';

                    for ($i=0; $i < $del_g + 1; $i++) { 
                        if (isset($_POST['v'.$i])) {
                            mysqli_query($connect, "DELETE FROM `groups` WHERE `groups`.`id` = ". $i);
                            exit("<meta http-equiv='refresh' content='0'>");
                        }  
                    }    

            ?>
            <input value="Дабавить" class="btn btn-secondary" type="submit" name="submit_add_group">
        </form>

        </div>

        
        <div id="pills-link" role="tabpanel" aria-labelledby="pills-home-tab" class="ques_answ tab-pane fade show">

        <form method="POST">
            <?php

                    // Вывод ссылок.

                    echo '<table id="table" class="table table-striped"><thead><tr class="table_tr"><th>Группа</th><th>Ссылка</th><th>Кол-во вступивших</th><th>Удалить</th></tr></thead><tbody>';

                        $c_users = mysqli_query($connect, "SELECT * FROM `users_add` ORDER BY `id` DESC");
                        $c_user = mysqli_fetch_assoc($c_users);

                        $del_l = $c_user['id'];

                        for ($a=1; $a <= $del_l+1; $a++) { 
                            $c_users = mysqli_query($connect, "SELECT * FROM `users_add` WHERE id =". $a);
                            $c_user = mysqli_fetch_assoc($c_users);

                            if (!empty($c_user)) {
                                echo '<tr class="table_tr">';
                                echo '<td>'.$c_user['groups'].'</td>';;
                                echo '<td>'.$c_user['token'].'</td>';
                                echo '<td>'.$c_user['count2'].'/'.$c_user['count'].'</td>';
                                echo '<td><button name="l'.$c_user['id'].'" type="submit" class="btn btn-sm btn-danger">Del</button></td>';
                            }
                        }
                    echo '</tbody></table>';

                    for ($i=0; $i < $del_l + 1; $i++) { 
                        if (isset($_POST['l'.$i])) {
                            mysqli_query($connect, "DELETE FROM `users_add` WHERE `users_add`.`id` = ". $i);
                            exit("<meta http-equiv='refresh' content='0'>");
                        }  
                    }    

            ?>
            
        </form>

        </div>

    </div>
    </section>
