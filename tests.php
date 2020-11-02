<?php
    require_once "settings/connect.php";
    admin_status();
    include "settings/doctype.php";
?>
    <section class="question">
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation"><a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Активные тесты</a></li>
        <li class="nav-item" role="presentation"><a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Завершенные</a></li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <!-- 1 -->
        <div id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" class="ques_answ ques_answ_flex tab-pane fade show active">

            <?php

                $pages = mysqli_query($connect, "SELECT * FROM `qq` ORDER BY id DESC LIMIT 1");
                $page = mysqli_fetch_assoc($pages);

                if (!empty($page)) {
                    for ($i=$page['id']+1; $i > 0; $i--) { 
                        $c_pages = mysqli_query($connect, "SELECT * FROM `qq` WHERE `status` = 0 AND id =". $i);
                        $c_page = mysqli_fetch_assoc($c_pages);

                        $title = explode('|' ,$c_page['title']);
                        $ques = explode('__' ,$c_page['qq']);
                        $users = explode('.' ,$c_page['user']);
                        $users_res = explode('.' ,$c_page['user_comp']);

                        $users = count($users) - 1;
                        $users_res = count($users_res) - 1;

                        $ques = count($ques) - 1;

                        if(!empty($c_page)){
                            echo '<div class="ques_block"><a style="color: black; text-decoration: none;" href="test_red.php?token='.$c_page['token'].'">';
                            echo '<h4>'.$title[0].'</h4>';
                            echo '<p class="p_block">'.$ques.' вопросов.</p>';
                            echo '<p class="p_block">'.$users_res.' человек выполнел из '.$users.'</p>';
                            echo '</a></div>';
                        }
                        unset($title);unset($ques);unset($users);
                    }
                }

            ?>
        </div>
        <!-- 2 -->
        <div class="ques_answ ques_answ_flex tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            <?php

                $pages = mysqli_query($connect, "SELECT * FROM `qq` ORDER BY id DESC LIMIT 1");
                $page = mysqli_fetch_assoc($pages);

                if (!empty($page)) {
                    for ($i=$page['id']+1; $i > 0; $i--) { 
                        $c_pages = mysqli_query($connect, "SELECT * FROM `qq` WHERE `status` = 1 AND id =". $i);
                        $c_page = mysqli_fetch_assoc($c_pages);

                        $title = explode('|' ,$c_page['title']);
                        $ques = explode('__' ,$c_page['qq']);
                        $users = explode('.' ,$c_page['user']);
                        $users_res = explode('.' ,$c_page['user_comp']);

                        $users = count($users) - 1;
                        $users_res = count($users_res) - 1;

                        $ques = count($ques) - 1;

                        if(!empty($c_page)){
                            echo '<div class="ques_block"><a style="color: black; text-decoration: none;" href="test_red.php?token='.$c_page['token'].'">';
                            echo '<h4>'.$title[0].'</h4>';
                            echo '<p class="p_block">'.$ques.' вопросов.</p>';
                            echo '<p class="p_block">'.$users_res.' человек выполнел из '.$users.'</p>';
                            echo '</a></div>';
                        }
                        unset($title);unset($ques);unset($users);
                    }
                }

            ?>
        </div>
    </div>
    </section>