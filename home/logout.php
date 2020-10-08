<?php
include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
$link = content();
$member_id = is_login($link);
if (!$member_id) {
    skip('index.php', 'error', '你没有登陆不需要退出！');
}
setcookie('bbs[name]', '', time() - 3600);
setcookie('bbs[pwd]', '', time() - 3600);

skip('index.php', 'ok', '退出成功！');