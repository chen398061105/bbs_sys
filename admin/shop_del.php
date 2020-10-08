<?php
include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
$link = content();

include_once 'inc/is_admin_login.php';
$query = "delete from shop_list where id = {$_GET['id']}";
//echo $query;
if (!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skip("shop_list.php", "error", "删除失败！请重试。");
}

execute($link, $query);
if (mysqli_affected_rows($link) == 1) {
    skip("shop_list.php", "ok", "恭喜您，删除成功！");
}else{
    skip("shop_list.php", "error", "删除失败！请重试。");
}

?>