<?php
include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
$link = content();
include_once 'inc/is_admin_login.php';
//判断id参数是否有误
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    skip('shop_update.php', 'error', '这条id不存在！');
}
$query = "select * from shop_list where id = {$_GET['id']}";
$result = execute($link, $query);
//判断DB记录是否存在
if (!mysqli_num_rows($result)) {
    skip('shop_list.php', 'error', '这条信息不存在！');
}
$data = mysqli_fetch_assoc($result);
//执行更新
if (isset($_POST['submit'])) {
    //验证数据
//    $flag = 'update';
//    include 'inc/check.son.module.inc.php';

    $query = "update shop_list set name = {$_POST['name']},jan = '{$_POST['jan']}',status = '{$_POST['status']}' where id = {$_GET['id']} ";

    execute($link, $query);
    // 更新 影响行数
    if (mysqli_affected_rows($link) == 1) {
        skip('shop_list.php', 'ok', '修改成功！');
    } else {
        skip('shop_update.php', 'error', '修改失败，请重试！');
    }
}


$Title['title'] = '商品修改页';
?>
<?php include_once 'inc/header.inc.php'; ?>
<div id="main">
    <div class="title">商品修改</div>
    <form method="post">
        <table class="au">
            <tr>
                <td>商品名</td>
                <td><input type="text" name="name" value="<?php echo $data['name'] ?>"/></td>
                <td>
                    商品名不能为空，最大不能超过32个字符！
                </td>
            </tr>
            <tr>
                <td>JAN码</td>
                <td><input type="text" name="jan" value="<?php echo $data['jan'] ?>"/></td>
                <td>
                    JAN码不能为空，最大不能超过15个字符！
                </td>
            </tr>
            <tr>
                <td>商品名信息</td>
                <td><textarea name="info">暂无</textarea></td>
                <td style="color: red">
                    应该单独做一个表记载商品详细信息用！未做
                </td>
            </tr>
            <tr>
                <td>状态</td>
                <td><select name="status">
                        <!--                        <option >==请选择状态===</option>-->
                        <?php
                        $query = "select status from shop_list  order by id desc ";
                        $result = execute($link, $query);
                        while ($data = mysqli_fetch_assoc($result)) {
                            if ($data['id'] == $_GET['id']) {
                                echo "<option selected='selected' value='{$data['id']}'>{$data['status']}</option>";
                            } else {
                                echo "<option  value='{$data['id']}'>{$data['status']}</option>";
                            }
                        }
                        ?>
                    </select>
                <td>
                    商品状态码:[0]准备完了 | [1]==准备中 | [2]==未准备
                </td>
            </tr>
        </table>
        <input style="margin-top: 20px;cursor: pointer" class="btn" type="submit" name="submit" value="添加"/>
    </form>
</div>

<?php include_once 'inc/footer.inc.php'; ?>


