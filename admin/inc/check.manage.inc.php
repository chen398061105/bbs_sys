<?php
//插入数据的验证,非空
if (empty($_POST['name'])) {
    skip('manage.add.php', 'error', '管理员名称不能为空！');
}
//长度，包括中文
if (mb_strlen($_POST['name'], 'utf-8') > 32) {
    skip('manage.add.php', 'error', '管理员名称长度太长！');
}

if (mb_strlen($_POST['pwd'], 'utf-8') > 32 || mb_strlen($_POST['pwd'], 'utf-8') < 6) {
    skip('manage.add.php', 'error', '管理员名称长度太长！');
}
//重要，入库前转义,后续需要追加xss攻击 过滤功能 暂时只有sql内部过滤功能
$_POST = escape($link, $_POST);
//数据是否重复判断
switch ($flag) {
    case 'add':
        $query = "select * from  bbs_manage where name = '{$_POST['name']}'";
        break;
    case 'update';
        $query = "select * from  bbs_father_module where module_name = '{$_POST['module_name']}' and id != {$_GET['id']}";
        break;
    default:
        skip('manage.add.php', 'error', 'flag参数错误！');
}
$result = execute($link, $query);
if (mysqli_num_rows($result)) {
    skip('manage.add.php', 'error', '已经存在管理员名称！');
}

if (!isset($_POST['level'])) {
    // 1 普通管理员  0 超级管理员
    $_POST['level'] == 1;
} elseif ($_POST['level'] == '0') {
    $_POST['level'] = 0;
} elseif ($_POST['level'] == '1') {
    $_POST['level'] = 1;
} else {
    $_POST['level'] = 1;
}