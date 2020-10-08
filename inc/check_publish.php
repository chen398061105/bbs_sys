<?php
if (empty($_POST['module_id']) || !is_numeric($_POST['module_id'])) {
    skip('publish.php', 'error', '所属板块ID不合法!');
}
$query = "select * from bbs_son_module where id = {$_POST['module_id']} ";
$result = execute($link,$query);
if (mysqli_num_rows($result) !=1){
    skip('publish.php', 'error', '请选择一个所属板块!');
}

if (empty($_POST['title']) || mb_strlen($_POST['title'],'utf-8') > 100) {
    skip('publish.php', 'error', '标题不合法!');
}


