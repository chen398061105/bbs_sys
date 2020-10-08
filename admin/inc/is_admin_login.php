<?php
if (!is_admin_login($link)) {
    header('Location:admin.login.php');
    exit();
}
if (basename($_SERVER['SCRIPT_NAME']) == "manage.add.php" || basename($_SERVER['SCRIPT_NAME']) == "manage.del.php") {
    if ($_SESSION['manage']['level'] != 0) {
        if (!isset($_SERVER['HTTP_REFERER'])) {
            $_SERVER['HTTP_REFERER'] = 'index.php';
        }
        skip($_SERVER['HTTP_REFERER'], 'error', '权限不足，无法操作！');
    }
}