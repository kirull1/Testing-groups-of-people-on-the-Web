<?php
    require_once "settings/connect.php";
    admin_status();
    if (isset($_POST['submit_saves'])) {
        foreach ($_POST as $key => $value) {
            if ($key != 'table_length' and $key != 'submit_saves' and $key != 'input_add') {
                $res .= $key.'.';
            }
        }
        mysqli_query($connect, "UPDATE `qq` SET `user` = '".$res."' WHERE `qq`.`token` = '".$_GET['token']."'");
        header("Location: test_red.php?token=".$_GET['token']);
    }
    if (isset($_POST['submit_add'])) {
        $ques = mysqli_query($connect, "SELECT `user` FROM `qq` WHERE `token` = '".$_GET['token']."'");
        $que = mysqli_fetch_assoc($ques);

        $res = $que['user'].$_POST['input_add'].'.';

        mysqli_query($connect, "UPDATE `qq` SET `user` = '".$res."' WHERE `qq`.`token` = '".$_GET['token']."'");
        header("Location: test_red.php?token=".$_GET['token']);
    }
    if (isset($_POST['submit_close'])) {
        mysqli_query($connect, "UPDATE `qq` SET `status` = '1' WHERE `qq`.`token` = '".$_GET['token']."'");
        header("Location: tests.php");
    }
    if (isset($_POST['submit_del_test'])) {
        mysqli_query($connect, "DELETE FROM `qq` WHERE `qq`.`token` = '".$_GET['token']."'");
        header("Location: tests.php");
    }
    include "settings/doctype.php";
?>
        <link rel="stylesheet" type="text/css" href="style/datatables.min.css"/>
        <script type="text/javascript" src="js/datatables.min.js"></script>
        <script type="text/javascript" src="js/table.js" class="init"></script>
        
    <section class="question">
        <div class="ques_answ">
        <p>Ссылка на тест: <a href="test_des.php?token=<?php echo $_GET['token']?>">test_des.php?token=<?php echo $_GET['token']?></a></p>
        <form method="POST">
            <?php

                if (!empty($_GET['token'])) {
                    $pages = mysqli_query($connect, "SELECT * FROM `qq` WHERE `token` ='".$_GET['token']."'");
                    $page = mysqli_fetch_assoc($pages);

                    echo '<table id="table" class="table table-striped"><thead><tr class="table_tr"><th>Имя</th><th>Группа</th><th>Ответы</th><th>Статистика</th><th>Действие</th></tr></thead><tbody>';

                        $c_users = mysqli_query($connect, "SELECT `user`, `answer` FROM `qq` WHERE `token` = '".$_GET['token']."'");
                        $q_user = mysqli_fetch_assoc($c_users);

                        $count_us = explode('.', $q_user['user']);
                        $count_answer = explode('.', $q_user['answer']);

                        for ($a=0; $a < count($count_us)-1; $a++) { 
                            $c_users = mysqli_query($connect, "SELECT * FROM `user` WHERE id =". $count_us[$a]);
                            $c_user = mysqli_fetch_assoc($c_users);

                            $id_users = mysqli_query($connect, "SELECT * FROM `answer` WHERE `user_id` = ".$c_user['id']." AND test_token = '".$_GET['token']."'");
                            $id_user = mysqli_fetch_assoc($id_users);

                            $id_user = explode('_', $id_user['answ']);
                            foreach ($id_user as $value) {
                                $val = explode('-', $value);
                                $result[$val[0]] = $val[1];
                                unset($val);
                            }
                            for ($i=0; $i < count($count_answer); $i++) { 
                                if ($result[$i] == $count_answer[$i]){
                                    $res .= '<span style="color: green;">'.$result[$i].'</span> ';
                                    $res_true++;
                                }else{
                                    $res .= '<span style="color: red;">'.$result[$i].'</span> ';
                                }
                            }

                            if (!empty($c_user)) {
                                echo '<tr class="table_tr">';
                                echo '<td>'.$c_user['name'].'</td>';
                                echo '<td>'.$c_user['groups'].'</td>';
                                echo '<td>'.$res.'</td>';
                                echo '<td>'.($res_true-1).'/'.(count($count_answer)-1).'</td>';
                                echo '<td style="text-align: center;"><input name="'.$c_user['id'].'" type="checkbox" aria-label="Checkbox for following text input" checked></td>';
                            }
                            
                            unset($res);unset($res_true);unset($result);
                        }
                    echo '</tbody></table>';
                }

            ?>
                <input style="float: left;" value="Сохранить" class="btn btn-secondary" type="submit" name="submit_saves">
                <div style="float: left; width: max-content; padding-left: 20px;" class="input-group mb-3">
                    <input name="input_add" style="max-width: 30%;" type="text" class="form-control" placeholder="id" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <div class="input-group-append">
                        <button name="submit_add" class="btn btn-outline-secondary" type="submit" id="button-addon2">Добавить</button>
                    </div>
                </div>
                <input style="" value="Завершить тест" class="btn btn-secondary" type="submit" name="submit_close">
                <input style="margin-left: 10px;" value="Удалить тест" class="btn btn-secondary" type="submit" name="submit_del_test">
        </form>
        </div>
    </section>