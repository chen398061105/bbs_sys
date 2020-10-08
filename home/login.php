<?php
include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
$link = content();
if ($member_id = is_login($link)) {
    skip('index.php', 'error', '请不要重复登录！');
}

if (isset($_POST['submit'])) {
    include_once '../inc/check_login.php';
    //数据库交互
    $_POST = escape($link, $_POST);
    $query = "select * from bbs_member where name = '{$_POST['name']}' and pwd =md5('{$_POST['pwd']}')";
    $result = execute($link, $query);
    if (mysqli_num_rows($result) == 1) {
        setcookie('bbs[name]', $_POST['name'], time() + $_POST['time']);
        setcookie('bbs[pwd]', sha1(md5($_POST['pwd'])),time() + $_POST['time']);

        skip('index.php', 'ok', '登录成功！' . $_POST['name']);
    } else {
        skip('login.php', 'error', '登录失败！');
    }
}
$title['title'] = "登陆页面";
?>
<?php include_once './inc/header.inc.php'; ?>
    <div id="register" class="auto">
        <h2>欢迎登陆</h2>
        <form method="post">
            <label>用户名：<input type="text" name="name"/><span></span></label>
            <label>密码：<input type="password" name="pwd"/><span></span></label>
            <label>验证码：<input name="code" type="text"/><span>*请输入下方验证码</span></label>
            <img class="vcode" src="<?php echo dirname($_SERVER['SCRIPT_NAME']) . '/show_code.php ' ?>"
                 onclick="this.src+='?'"/>
            <label>自动登录：
                <select style="width:236px;height:25px;" name="time">
                    <option value="3600">1小时内</option>
                    <option value="86400">1天内</option>
                    <option value="259200">3天内</option>
                    <option value="2592000">30天内</option>
                </select>
                <span>*公共电脑上请勿长期自动登录</span>
            </label>
            <div style="clear:both;"></div>
            <input class="btn" type="submit" name="submit" value="登陆"/>
        </form>
    </div>
<?php
include_once './inc/footer.inc.php';