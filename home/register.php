<?php
include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';

$link = content();

if ($member_id = is_login($link)) {
    skip('index.php', 'error', '已经登录了不能再注册！');
}

if (isset($_POST['submit'])) {
    include '../inc/check_register.php';
    $query = " insert into bbs_member(name,pwd,register_time)
        values('{$_POST['name']}',md5('{$_POST['pwd']}'),now())";
    execute($link, $query);
    if (mysqli_affected_rows($link) == 1) {
        //建议不要使用sha1和md5 尽量使用哈希加密 password_hash
        setcookie('bbs[name]', $_POST['name'], time() + 3600);
        setcookie('bbs[pwd]', sha1(md5($_POST['pwd'])), time() + 3600);
        skip('index.php', 'ok', '注册成功！');
    } else {
        skip('register.php', 'error', '注册失败！');
    }
}
$title['title'] = "注册页面";
include_once './inc/header.inc.php';
?>

    <div id="register" class="auto">
        <h2>注册页面</h2>
        <form method="post">
            <label>用户名：<input type="text" name="name"/><span>*用户名不得为空，长度不得超过32字符</span></label>
            <label>密码：<input type="password" name="pwd"/><span>*密码长度在6到32位之间</span></label>
            <label>确认密码：<input type="password" name="confirm_pwd"/><span>*请再次输入密码</span></label>
            <label>验证码：<input name="code" type="text"/><span>*请输入下方验证码</span></label>
            <img class="vcode" src="<?php echo dirname($_SERVER['SCRIPT_NAME']) . '/show_code.php ' ?>"
                 onclick="this.src+='?'"/>
            <div style="clear:both;"></div>
            <input class="btn" type="submit" name="submit" value="确定注册"/>
        </form>
    </div>
<?php
include_once './inc/footer.inc.php';