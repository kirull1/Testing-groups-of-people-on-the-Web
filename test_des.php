<?php

    require_once "settings/connect.php";

    if (isset($_POST['submit_ques'])) {
        $i = 0;
        foreach ($_POST as $key => $value) {
          if ($key != 'submit_ques') {
            $ques = explode('ques', $key);
            $answ .= $ques[1].'-'.$value.'_';
          }
        }
        $old_us = mysqli_query($connect, "SELECT * FROM `qq` WHERE `token` = '".$_GET['token']."'");
        $old_user = mysqli_fetch_assoc($old_us);
        $old_user['user_comp'] .= $_COOKIE['id'].'.';
        mysqli_query($connect, "INSERT INTO `answer` (`user_id`, `answ`, `test_token`) VALUES ('".$_COOKIE['id']."', '".$answ."', '".$_GET['token']."')");
        mysqli_query($connect, "UPDATE `qq` SET `user_comp` = '".$old_user['user_comp']."' WHERE `qq`.`token` = '".$_GET['token']."'");
        header("location: index.php");
    }

    include "settings/doctype.php";

?>

    <section class="question">
        <?php
            $tests = mysqli_query($connect, "SELECT * FROM `qq` WHERE `token` = '".$_GET['token']."'");
            $test = mysqli_fetch_assoc($tests);
            $title = explode('|', $test['title']);
            $ques = array_diff(explode('__', $test['qq']), array(''));
        ?>
        <div class="ques_info">
            <h1><?php echo $title[0] ?></h1>
            <p class="ques_info_p"><?php echo $title[1] ?></p>
            <p class="ques_info_p"><?php echo $title[2] ?></p>
        </div>
        <form method="POST">
        <?php

            for ($i=0, $h2=1; $i < count($ques); $i++, $h2++) { 
                $ques_qq = explode('|', $ques[$i]) ;
                echo '<div class="ques_answ">';
                echo '<h2>'.$h2.'. '.$ques_qq[0].'</h2>';
                echo '<div class="answer_flex">';
                for ($a=1; $a < count($ques_qq)-1; $a++) { 
                    echo '<div class="answer_block"><input type="radio" id="contactChoice1" name="ques'.$i.'" value="'.$a.'">';
                    echo '<span> '.$ques_qq[$a].'</span></div>';
                }
                echo '</div></div>';
                unset($ques_qq);
            }

        ?>
        <div class="ques_end_block">
            <input value="Закончить" class="ques_end" type="submit" name="submit_ques">
        </div>
        </form>
    </section>
</body>

</html>