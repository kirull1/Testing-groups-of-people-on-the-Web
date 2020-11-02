let id = 2;
let id_ques = 1;
function getdetails(obj) {
    id -= 1;
    $('#myTable' + obj.id).on('click', 'input[type="button"]', function() { 
    $(this).closest('tr').remove(); 
    })
}
function delittes(obj) {
    id += 1;
    $('#myTable' + obj.id).append('<tr><td><input name="' + id + '" type="text" class="fname" /></td><td><input class="type_del" id="'+obj.id+'" type="button" value="Del" onClick="getdetails(this)" /></td></tr>');
}
function delittques(obj){
    id_ques -= 1;
    $('.questions' + obj.id).on('click', 'input[type="button"]', function() { 
    $(this).closest('div').remove(); 
    })
}
$('.ques_end_block input[type="button"]').click(function() {
id += 1;
id_ques += 1;
$('#ques_sect').append('<div class="ques_answ questions'+id_ques+'"><h2>'+id_ques+'.</h2><input name="title_ques_'+id_ques+'" type="text" class="fname" /><input onClick="delittques(this)" id="'+id_ques+'" class="type del_bot" type="button" value="×"><table id="myTable'+id_ques+'"> <tr><td><input name="'+id+'" type="text" class="fname" /></td><td><input class="type_del" id="'+id_ques+'" type="button" value="Del" onClick="getdetails(this)" /></td></tr></table><p class="input_add"><input onClick="delittes(this)" id="'+id_ques+'" class="type" type="button" value="Добавить"></p><input class="true_answ" name="true'+id_ques+'" type="text"> <span> - Номер правильного варианта</span></div>');
});