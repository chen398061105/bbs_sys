<?php
include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
$link = content();
include_once 'inc/is_admin_login.php';
$query_f = "delete from bbs_father_module where id = {$_GET['id']}";
$query_s = "select * from bbs_son_module where father_module_id = {$_GET['id']}";
//echo $query;
if (!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skip("father.module.php", "error", "删除失败！请重试。");
}
//父版块下面有子版块时候不能删除
$result = execute($link, $query_s);
if(mysqli_num_rows($result)){//1代表成功 检索到数据
    skip('son.module.php','error','所属父版存有子版块，请先删除子板块！');
}

execute($link, $query_f);
if (mysqli_affected_rows($link) == 1) {
    skip("father.module.php", "ok", "恭喜您，删除成功！");
}else{
    skip("father.module.php", "error", "删除失败！请重试。");
}

?>