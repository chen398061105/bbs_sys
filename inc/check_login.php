<?php
if (empty($_POST['name'])) {
    skip('login.php', 'error', '用户名不得为空!');
}
if (mb_strlen($_POST['name']) > 32) {
    skip('login.php', 'error', '用户名长度过长!');
}
if (mb_strlen($_POST['pwd']) > 32 || mb_strlen($_POST['pwd']) < 6) {
    skip('login.php', 'error', '密码输入有误!');
}

if (strtolower($_POST['code']) != strtolower($_SESSION['code'])){
    skip('login.php', 'error', '验证码输入有错!');
}
if (empty($_POST['time']) || is_numeric($_POST['time']) || $_POST['time'] >2592000  )  {
    $_POST['time'] = 2592000;
}


