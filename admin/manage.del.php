<?php
include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
$link = content();
include_once 'inc/is_admin_login.php';
if (!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skip("manage.show.php", "error", "删除失败！请重试。");
}
$query = "select level from bbs_manage where id = {$_GET['id']}";
$result = execute($link,$query);
if (mysqli_num_rows($result)){
  $data = mysqli_fetch_assoc($result);
  if ($data['level'] == 0){
      skip("manage.show.php", "error", "超级管理用户不能被删除！");
  }
}
$query = "delete from bbs_manage where id = {$_GET['id']}";
//echo $query;

execute($link, $query);
if (mysqli_affected_rows($link) == 1) {
    skip("manage.show.php", "ok", "恭喜您，删除成功！");
}else{
    skip("manage.show.php", "error", "删除失败！请重试。");
}

?>