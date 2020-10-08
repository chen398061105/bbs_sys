<?php
include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
$link = content();
$admin_id = is_admin_login($link);
if (!$admin_id) {
   header('Location:admin.login.php');
}
session_unset();
session_destroy();
setcookie(session_name(), '', time() - 3600);

skip('admin.login.php', 'ok', '退出成功！');