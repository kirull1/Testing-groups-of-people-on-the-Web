<?php
    require_once "settings/connect.php";
    include "settings/doctype.php";
    
?>
    <section class="question">
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation"><a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Активные тесты</a></li>
        <li class="nav-item" role="presentation"><a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Завершенные</a></li>
        <li class="nav-item" role="presentation"><a class="nav-link" id="pills-tab" data-toggle="pill" href="#pills" role="tab" aria-controls="pills-profile" aria-selected="false">Проверенные</a></li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <!-- 1 -->
        <div id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" class="ques_answ ques_answ_flex tab-pane fade show active">

            <?php

                //Не подходит для большого кол-ва строк. 

                $pages = mysqli_query($connect, "SELECT * FROM `qq` ORDER BY id DESC LIMIT 1");
                $page = mysqli_fetch_assoc($pages);

                if (!empty($page)) {
                    for ($i=$page['id']+1; $i > 0; $i--) { 
                        $c_pages = mysqli_query($connect, "SELECT `id`, `user`, `token`, `status` FROM `qq` WHERE id =". $i);
                        $c_page = mysqli_fetch_assoc($c_pages);

                        $users = explode('.' ,$c_page['user']);

                        foreach ($users as $value) {
                            if (!empty($value)) {
                                $answ_pages = mysqli_query($connect, "SELECT `user_id` FROM `answer` WHERE `user_id` = ".$value." AND `test_token` = '".$c_page['token']."'");
                                $answ_page = mysqli_fetch_assoc($answ_pages);
                                if ($value == $_COOKIE['id'] and empty($answ_page['user_id']) and $c_page['status'] == 0) {
                                    $true_ques[] = $c_page['id'];
                                }elseif ($value == $_COOKIE['id'] and $c_page['status'] == 1) {
                                    $true_ques_res_vso[] = $c_page['id'];
                                }elseif ($value == $_COOKIE['id'] and !empty($answ_page['user_id']) and $c_page['status'] == 0) {
                                    $true_ques_res[] = $c_page['id'];
                                }
                            }
                        }
                        
                        unset($users);
                    }
                    if (!empty($true_ques)) {
                        foreach ($true_ques as $value) {
                            $c_pages = mysqli_query($connect, "SELECT `title`, `qq`, `token` FROM `qq` WHERE `status` = 0 AND id =". $value);
                            $c_page = mysqli_fetch_assoc($c_pages);

                            $title = explode('|' ,$c_page['title']);
                            $ques = explode('__' ,$c_page['qq']);
                            $users_res = explode('.' ,$c_page['user_comp']);

                            $users_res = count($users_res) - 1;

                            $ques = count($ques) - 1;

                            if(!empty($c_page)){
                                echo '<div class="ques_block"><a style="color: black; text-decoration: none;" href="test_des.php?token='.$c_page['token'].'">';
                                echo '<h4>'.$title[0].'</h4>';
                                echo '<p class="p_block">'.$ques.' вопросов.</p>';
                                echo '</a></div>';
                            }
                            unset($title);unset($ques);unset($users);
                        }
                    }else echo '<h2>Тестов нету(((</h2>';
                }

            ?>
        </div>
        <!-- 2 -->
        <div class="ques_answ ques_answ_flex tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            <?php

                if (!empty($true_ques_res)) {
                    foreach ($true_ques_res as $value) {
                        $c_pages = mysqli_query($connect, "SELECT `title`, `qq`, `token` FROM `qq` WHERE `status` = 0 AND id =". $value);
                        $c_page = mysqli_fetch_assoc($c_pages);

                        $title = explode('|' ,$c_page['title']);
                        $ques = explode('__' ,$c_page['qq']);
                        $users_res = explode('.' ,$c_page['user_comp']);

                        $users_res = count($users_res) - 1;

                        $ques = count($ques) - 1;

                        if(!empty($c_page)){
                            echo '<div class="ques_block">';
                            echo '<h4>'.$title[0].'</h4>';
                            echo '<p class="p_block">'.$ques.' вопросов.</p>';
                            echo '</a></div>';
                        }
                        unset($title);unset($ques);unset($users);
                    }
                }else echo '<h2>Тестов нету(((</h2>';

            ?>
        </div>
        <!-- 3 -->
        <div class="ques_answ ques_answ_flex tab-pane fade" id="pills" role="tabpanel" aria-labelledby="pills-profile-tab">
            <?php

                if (!empty($true_ques_res_vso)) {
                    foreach ($true_ques_res_vso as $value) {
                        $c_pages = mysqli_query($connect, "SELECT `title`, `qq`, `token`, `answer` FROM `qq` WHERE `status` = 1 AND id =". $value);
                        $c_page = mysqli_fetch_assoc($c_pages);

                        $title = explode('|' ,$c_page['title']);
                        $ques = explode('__' ,$c_page['qq']);
                        $users_res = explode('.' ,$c_page['user_comp']);
                        $count_answer = explode('.', $c_page['answer']);

                        $users_res = count($users_res) - 1;

                        $ques = count($ques) - 1;

                        //Тут ещё изменить

                        $id_users = mysqli_query($connect, "SELECT * FROM `answer` WHERE `user_id` = ".$_COOKIE['id']." AND test_token = '".$c_page['token']."'");
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

                        if(!empty($c_page)){
                            echo '<div class="ques_block"><a style="color: black; text-decoration: none;" href="#">';
                            echo '<h4>'.$title[0].'</h4>';
                            echo '<p class="p_block">'.$ques.' вопросов.</p>';
                            echo '<p class="p_block">'.$res.'</p>';
                            echo '<p class="p_block">'.($res_true-1).'/'.(count($count_answer)-1).'</p>';
                            echo '</a></div>';
                        }
                        unset($title);unset($ques);unset($users);unset($res);unset($res_true);unset($result);
                    }
                }else echo '<h2>Тестов нету(((</h2>';

            ?>
        </div>
    </div>
    </section>