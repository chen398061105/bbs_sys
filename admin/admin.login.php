<?php
include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
$link = content();
if($admin_id = is_admin_login($link)){
    skip('index.php','ok','您已经登录，请不要重复登录！');
}
if (isset($_POST['submit'])) {
    include_once './inc/check_admin_login.php';
    //数据库交互
    $_POST = escape($link, $_POST);
    $query = "select * from bbs_manage where name = '{$_POST['name']}' and pwd =md5('{$_POST['pwd']}')";
    $result = execute($link, $query);
    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $_SESSION['manage']['name'] = $data['name'];
        $_SESSION['manage']['pwd'] = sha1($data['pwd']);
        $_SESSION['manage']['id'] = $data['id'];
        $_SESSION['manage']['level'] = $data['level'];

        skip('index.php', 'ok', '登录成功！' . $_POST['name']);
    } else {
        skip('admin.login.php', 'error', '密码或者账户错误！');
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8"/>
    <title>后台登陆页面</title>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <style type="text/css">
        body {
            background: #f7f7f7;
            font-size: 14px;
        }

        #main {
            width: 360px;
            height: 320px;
            background: #fff;
            border: 1px solid #ddd;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-left: -180px;
            margin-top: -160px;
        }

        #main .title {
            height: 48px;
            line-height: 48px;
            color: #333;
            font-size: 16px;
            font-weight: bold;
            text-indent: 30px;
            border-bottom: 1px dashed #eee;
        }

        #main form {
            width: 300px;
            margin: 20px 0 0 40px;
        }

        #main form label {
            margin: 10px 0 0 0;
            display: block;
        }

        #main form label input.text {
            width: 200px;
            height: 25px;
        }

        #main form label .vcode {
            display: block;
            margin: 0 0 0 56px;
        }

        #main form label input.submit {
            width: 200px;
            display: block;
            height: 35px;
            cursor: pointer;
            margin: 0 0 0 56px;
        }
    </style>
</head>
<body>
<div id="main">
    <div class="title">管理登录</div>
    <form method="post">
        <label>用户名：<input class="text" type="text" name="name"/></label>
        <label>密　码：<input class="text" type="password" name="pwd"/></label>
        <label>验证码：<input class="text" type="text" name="code"/></label>
        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <img class="code" src="../home/show_code.php" onclick="this.src+='?'"/></label>
        <label><input class="submit" type="submit" name="submit" value="登录"/></label>
    </form>
</div>
</body>
</html>