
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <title><?php echo $Title['title'] ;?></title>
    <meta name="keywords" content="后台界面" />
    <meta name="description" content="后台界面" />
    <link rel="stylesheet" type="text/css" href="style/public.css" />
</head>
<body>
<div id="top">
    <div class="logo">
管理中心
    </div>
    <ul class="nav">
        <li><a href="" >导航1</a></li>
        <li><a href="" >导航2</a></li>
        <li><a href="" >导航3</a></li>
    </ul>
    <div class="login_info">
        <a target="_blank " href="../home/index.php" style="color:#fff;">网站首页</a>&nbsp;|&nbsp;
        管理员：<a target="_blank" href=# ><?php echo $_SESSION['manage']['name']?> </a><a href="../admin/admin.logout.php">[注销]</a>
    </div>
</div>
<div id="sidebar">
    <ul>
        <li>
            <div class="small_title">系统</div>
            <ul class="child">
                <li><a <?php if (basename($_SERVER['SCRIPT_NAME']) == "index.php"){ echo 'class="current"';} ?> href="index.php">系统信息</a></li>
                <li><a <?php if (basename($_SERVER['SCRIPT_NAME']) == "manage.show.php"){ echo 'class="current"';} ?> href="manage.show.php">管理员列表</a></li>
                <li><a <?php if (basename($_SERVER['SCRIPT_NAME']) == "manage.add.php"){ echo 'class="current"';} ?> href="manage.add.php">添加管理员</a></li>
                <li><a <?php if (basename($_SERVER['SCRIPT_NAME']) == "web.set.php"){ echo 'class="current"';} ?> href="web.set.php">站点设置</a></li>
            </ul>
        </li>
        <li><!--  class="current" -->
            <div class="small_title">内容管理</div>
            <ul class="child">
                <li><a <?php if (basename($_SERVER['SCRIPT_NAME']) == "father.module.php"){ echo 'class="current"';} ?> href="father.module.php">父板块列表</a></li>
                <li><a <?php if (basename($_SERVER['SCRIPT_NAME']) == "father.module.add.php"){ echo 'class="current"';} ?>href="father.module.add.php">添加父板块</a></li>
                <?php
                  if (basename($_SERVER['SCRIPT_NAME']) == 'father.module.update.php'){
                      echo '<li><a class="current">编辑父板块</a></li>';
                  }
                ?>
                <li><a <?php if (basename($_SERVER['SCRIPT_NAME']) == "son.module.php"){ echo 'class="current"';} ?> href="son.module.php">子板块列表</a></li>
                <li><a <?php if (basename($_SERVER['SCRIPT_NAME']) == "son.module.add.php"){ echo 'class="current"';} ?>href="son.module.add.php">添加子板块</a></li>
                <?php
                if (basename($_SERVER['SCRIPT_NAME']) == 'son.module.update.php'){
                    echo '<li><a class="current">编辑子板块</a></li>';
                }
                ?>
                <li><a target="_blank" href="../home/index.php">帖子管理</a></li>
            </ul>
        </li>
        <li><!--  class="current" -->
            <div class="small_title">商品管理</div>
            <ul class="child">
                <li><a <?php if (basename($_SERVER['SCRIPT_NAME']) == "shop_list.php"){ echo 'class="current"';} ?> href="shop_list.php">商品列表</a></li>
                <li><a <?php if (basename($_SERVER['SCRIPT_NAME']) == "shop_add.php"){ echo 'class="current"';} ?>href="shop_add.php">添加商品</a></li>
                <?php
                if (basename($_SERVER['SCRIPT_NAME']) == 'shop_update.php'){
                    echo '<li><a class="current">编辑商品</a></li>';
                }
                ?>
            </ul>
        </li>
        <li>
            <div class="small_title">用户管理</div>
            <ul class="child">
                <li><a href="#">用户列表未做</a></li>
            </ul>
        </li>
    </ul>
</div>


