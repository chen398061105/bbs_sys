<?php
$query = "select * from bbs_web_set where id = 1";
$result_info = execute($link, $query);
$data_info = mysqli_fetch_assoc($result_info);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8"/>
    <title><?php echo $title['title'] ?>-<?php echo $data_info['title']?></title>
    <meta name="description" content="<?php echo $data_info['description']?>"/>
    <meta name="keywords" content="<?php echo $data_info['keyword']?>"/>
    <meta name="description" content=""/>
    <link rel="stylesheet" type="text/css" href="style/public.css"/>
    <link rel="stylesheet" type="text/css" href="style/register.css"/>
    <link rel="stylesheet" type="text/css" href="style/publish.css"/>
    <link rel="stylesheet" type="text/css" href="style/index.css"/>
    <link rel="stylesheet" type="text/css" href="style/list.css"/>
    <link rel="stylesheet" type="text/css" href="style/show.css"/>
    <link rel="stylesheet" type="text/css" href="style/member.css"/>
</head>
<body>
<div class="header_wrap">
    <div id="header" class="auto">
        <div class="logo">BBS</div>
        <div class="nav">
            <a class="hover" href="./index.php">首页</a>
        </div>
        <div class="serarch">
            <form method="post" action="search.php">
                <input class="keyword" type="text" name="keyword" value="<?php
                if (isset($_POST['keyword'])){echo trim($_POST['keyword']);}
                 ?>" placeholder="搜索其实很简单"/>
                <input class="submit" type="submit" name="submit" value=""/>
            </form>
        </div>
        <div class="login">
            <?php
            if (isset($member_id) && $member_id == true) {
                $str = <<<A
<a target="_blank" href="./member.php?id={$member_id}">欢迎登录！[{$_COOKIE['bbs']['name']}]</a> <span style="color: white">|</span>
<a href="./logout.php">注销</a>
A;
                echo $str;
            } else {
                $str = <<<A
<a href="./login.php">登录</a>
<a href="./register.php">注册</a>
A;
                echo $str;
            };
            ?>
        </div>
    </div>
</div>
<div style="margin-top:55px;"></div>