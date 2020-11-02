<?php

    require_once "settings/connect.php";
    admin_status();

    if (isset($_POST['end_test'])) {
        $i = 1;
        foreach ($_POST as $key => $value) {
          if ($key != 'title1' and $key != 'title2' and $key != 'title3') {
            $array[$i][] = $value;
            if ($key === 'true'.$i) {
              $i++;
            }
          }else{
            $result_title .= $value.'|';
          }
        }
        for ($i=1; $i < count($array); $i++) { 
          for ($a=0; $a < count($array[$i]); $a++) { 
            if ($a == count($array[$i]) - 1) {
              $result_true .=  $array[$i][$a].".";
            }else{
              $result .= $array[$i][$a]."|";
            }
          }
          $result .= "__";
        }
        $token = bin2hex(openssl_random_pseudo_bytes(16));
        mysqli_query($connect, "INSERT INTO `qq` (`title`, `qq`, `answer`, `token`, `user_comp`) VALUES ('$result_title', '$result', '$result_true', '$token', '')");
        header("Location: qq_answ.php?token=".$token);
      }

    include "settings/doctype.php";
?>

    <section class="question">
        <form method="POST">
        <div id="ques_sect">
        <div class="ques_info">
            <h1 style="padding:0px;">Название теста</h1>
            <input name="title1" class="info_test_add" type="text">
            <p class="ques_info_p">Описание теста</p>
            <input name="title2" class="info_test_add" type="text">
            <input name="title3" class="info_test_add" type="text">
        </div>
        <div class="ques_answ questions1">
                <h2>1. </h2><input name="title_ques_1" type="text" class="fname" />
                <input onClick="delittques(this)" id="1" class="type del_bot" type="button" value="×">
                <table id="myTable1"> 
                <tr><td><input name="1" type="text" class="fname" /></td><td><input id="1" class="type_del" type="button" value="Del" onClick="getdetails(this)" /></td></tr> 
                <tr><td><input name="2" type="text" class="fname" /></td><td><input id="1" class="type_del" type="button" value="Del" onClick="getdetails(this)" /></td></tr>
                </table> 
                <p class="input_add"><input onClick="delittes(this)" id="1" class="type" type="button" value="Добавить"></p>
                <input class="true_answ" name="true1" type="text"> <span> - Номер правильного варианта</span>
        </div>
        </div>
        <div class="ques_end_block">
            <input id="ques_add" value="Добавить вопрос" class="ques_end" type="button">
        </div>
        <div class="ques_end_add">
            <input name="end_test" value="Создать тест" class="ques_end" type="submit">
        </div>
        </form>
    </section>
</body>

<script src="js/test_qq.js"></script>

</html>