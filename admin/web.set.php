<?php
include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
$link = content();
include_once 'inc/is_admin_login.php';
//默认信息
$query = "select * from bbs_web_set where id = 1";
$result_info = execute($link, $query);
$data_info = mysqli_fetch_assoc($result_info);

if (isset($_POST['submit'])) {
    $_POST = escape($link, $_POST);
    //可以适当设置权限才能设置
    $query = "update bbs_web_set set title = '{$_POST['title']}',keyword = '{$_POST['keyword']}',description = '{$_POST['description']}'";
    execute($link, $query);
    if (mysqli_affected_rows($link) == 1) {
        skip('web.set.php', 'ok', '设置成功！');
    } else {
        skip('web.set.php', 'error', '设置失败！');
    }

}
$Title['title'] = '站点设置';
?>
<?php include_once 'inc/header.inc.php'; ?>
<div id="main">
    <div class="title">站点设置</div>
    <form method="post">
        <table class="au">
            <tr>
                <td>网站标题</td>
                <td><input type="text" name="title" value="<?php echo $data_info['title'] ?>"/></td>
                <td>
                    就是前台页面的标题
                </td>
            </tr>
            <tr>
                <td>关键字</td>
                <td><input type="text" name="keyword" value="<?php echo $data_info['keyword'] ?>"/></td>
                <td>
                    关键字
                </td>
            </tr>
            <tr>
                <td>描述</td>
                <td><textarea name="description"><?php echo $data_info['description'] ?></textarea></td>
                <td>
                    网站描述
                </td>
            </tr>

        </table>
        <input style="margin-top: 20px;cursor: pointer" class="btn" type="submit" name="submit" value="设置"/>
    </form>
</div>

<?php include_once 'inc/footer.inc.php'; ?>


