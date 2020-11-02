<?php    

    require_once "settings/connect.php";
    admin_status();
    
    if (isset($_POST['submit_add_group'])) {
      if (!empty($_POST['group'])) {
        mysqli_query($connect, "INSERT INTO `groups` (`title`) VALUES ('".$_POST['group']."')");
        header("Location: qq_answ.php?add=true");
      }else{
        echo Ошибка;
      }
    }
    if (isset($_POST['add_users'])) {
      if (!empty($_POST['name_user'])) {
        mysqli_query($connect, "INSERT INTO `user` (`name`, `pass`, `groups`, `token`) VALUES ('".$_POST['name_user']."', '', '".$_POST['select_grops']."', '')");
        header("Location: qq_answ.php?add=true");
      }else{
        echo Ошибка;
      }
    }
    if (isset($_POST['submit_add_users_link'])) {
      if (!empty($_POST['count_user'])) {
        $token = bin2hex(openssl_random_pseudo_bytes(16));
        mysqli_query($connect, "INSERT INTO `users_add` (`token`, `groups`, `count`, `count2`) VALUES ('".$token."', '".$_POST['select_grops']."','".$_POST['count_user']."', '0')");
        header("Location: qq_answ.php?add=true&link=".$token);
      }else{
        echo Ошибка;
      }
    }

    include "settings/doctype.php";

?>
    <section class="question">
        <div id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" class="ques_answ tab-pane fade show active">
        <form method="POST">
            <?php

                    //Добавление.

                    if ($_GET['u'] == 1) {
                        echo '<form method="POST">
                        <div class="form-group">
                          <label for="exampleInput">Группа</label>
                          <select name="select_grops" class="form-control" id="exampleFormControlSelect1">';
                          $c_users = mysqli_query($connect, "SELECT * FROM `groups` ORDER BY `id` DESC");
                          $c_user = mysqli_fetch_assoc($c_users);
                          $del_g = $c_user['id'];
                          for ($a=1; $a <= $del_g+1; $a++) { 
                            $c_users = mysqli_query($connect, "SELECT * FROM `groups` WHERE id =". $a);
                            $c_user = mysqli_fetch_assoc($c_users);

                            if (!empty($c_user)) {
                                echo '<option>'.$c_user['title'].'</option>';
                            }
                        }
                        echo '</select>
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1">Имя</label>
                          <input name="name_user" type="text" class="form-control" id="exampleInput">
                        </div>
                        <input value="Дабавить" class="btn btn-secondary" type="submit" name="add_users">
                      </form>';
                    }elseif ($_GET['u'] == 2) {
                      echo '<form method="POST">
                      <div class="form-group">
                        <label for="exampleInput">Название группы</label>
                        <input name="group" type="text" class="form-control" id="exampleInput">
                      </div>
                      <input value="Дабавить" class="btn btn-secondary" type="submit" name="submit_add_group">
                    </form>';
                    }elseif ($_GET['u'] == 3) {
                        echo '<form method="POST">
                        <div class="form-group">
                          <label for="exampleInput">Группа</label>
                          <select name="select_grops" class="form-control" id="exampleFormControlSelect1">';
                          $c_users = mysqli_query($connect, "SELECT * FROM `groups` ORDER BY `id` DESC");
                          $c_user = mysqli_fetch_assoc($c_users);
                          $del_g = $c_user['id'];
                          for ($a=1; $a <= $del_g+1; $a++) { 
                            $c_users = mysqli_query($connect, "SELECT * FROM `groups` WHERE id =". $a);
                            $c_user = mysqli_fetch_assoc($c_users);

                            if (!empty($c_user)) {
                                echo '<option>'.$c_user['title'].'</option>';
                            }
                        }
                        echo '</select>
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1">Количество человек</label>
                          <input name="count_user" type="text" class="form-control" id="exampleInput">
                        </div>
                        <input value="Создать ссылку" class="btn btn-secondary" type="submit" name="submit_add_users_link">
                      </form>';
                    }else{
                      echo Ошибка;
                    }

            ?>
        </form>
        </div>
    </section>
