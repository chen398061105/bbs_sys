<?php
if (empty($_POST['name'])) {
    skip('register.php', 'error', '用户名不得为空!');
}
if (mb_strlen($_POST['name']) > 32) {
    skip('register.php', 'error', '用户名长度过长!');
}
if (mb_strlen($_POST['pwd']) > 32 || mb_strlen($_POST['pwd']) < 6) {
    skip('register.php', 'error', '密码长度不符合要求!');
}
if ($_POST['confirm_pwd'] != $_POST['pwd']) {
    skip('register.php', 'error', '密码输入不一致!');
}
if (strtolower($_POST['code']) != strtolower($_SESSION['code'])){
    skip('register.php', 'error', '验证码输入有错!');
}

$_POST = escape($link, $_POST);
$query = "select * from bbs_member where name = '{$_POST['name']}'";
$result = execute($link, $query);
if (mysqli_num_rows($result)){
    skip('register.php', 'error', '已经存在的用户名!');
}
