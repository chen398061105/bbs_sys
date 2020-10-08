<?php
//页面跳转
function skip($url, $icon, $msg)
{
    $html = <<<A
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<meta http-equiv="refresh" content="3;URL={$url}"/>
<title>正在跳转中</title>
<link rel="stylesheet" type="text/css" href="style/remind.css" />
</head>
<body>
<div class="notice"><span class="pic {$icon}"></span> {$msg}<a href="{$url}"> 3秒后自动跳转...</a></div>
</body>
</html>

A;
    echo $html;
    exit;
}

//前台登录验证
function is_login($link)
{
    if (isset($_COOKIE['bbs']['name']) && isset($_COOKIE['bbs']['pwd'])) {
        $query = "select * from bbs_member where name='{$_COOKIE['bbs']['name']}' and sha1(pwd)='{$_COOKIE['bbs']['pwd']}'";
        $result = execute($link, $query);
        if (mysqli_num_rows($result) == 1) {
            $data = mysqli_fetch_assoc($result);
            return $data['id'];
        } else {
            return false;
        }
    } else {
        return false;
    }
}

//后台登录验证
function is_admin_login($link)
{
    if (isset($_SESSION['manage']['name']) && isset($_SESSION['manage']['pwd'])) {
        $query = "select * from bbs_manage where name='{$_SESSION['manage']['name']}' and sha1(pwd)='{$_SESSION['manage']['pwd']}'";
        $result = execute($link, $query);
        if (mysqli_num_rows($result) == 1) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

//登录时候的账户和发帖的账户比较
function check_perm($member_id, $content_member_id,$admin_id)
{
    if ($member_id == $content_member_id ||$admin_id) {
        return true;
    } else {
        return false;
    }

}

?>
