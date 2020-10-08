
<?php
include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
$link = content();
include_once 'inc/is_admin_login.php';
//判断id参数是否有误
if(!isset($_GET['id']) || !is_numeric($_GET['id']) ){
    skip('son.module.php','error','这条信息不存在！');
}
$query = "select * from bbs_son_module where id = {$_GET['id']}";
$result = execute($link,$query);
//判断DB记录是否存在
if (!mysqli_num_rows($result)){
    skip('son.module.php','error','这条信息不存在！');
}
$data = mysqli_fetch_assoc($result);
//执行更新
if (isset($_POST['submit'])){
    //验证数据
    $flag = 'update';
    include 'inc/check.son.module.inc.php';

    $query = "update bbs_son_module set father_module_id = {$_POST['father_module_id']},module_name = '{$_POST['module_name']}',
    member_id = {$_POST['member_id']},info = '{$_POST['info']}' where id = {$_GET['id']} " ;

    execute($link,$query);
    // 更新 影响行数
    if (mysqli_affected_rows($link) == 1){
        skip('son.module.php','ok','修改成功！');
    }else{
        skip('son.module.php','error','修改失败，请重试！');
    }
}
$Title['title'] = '子板块修改页面';
?>
<?php include_once 'inc/header.inc.php';?>
<div id="main">
    <div class="title">修改父板块-<?php echo $data['module_name']?></div>
    <form method="post" >
        <table class="au">

            <td>所属父板块</td>
            <td>
                <select name="father_module_id">
                    <option value="0">===请选择父版块===</option>
                    <?php
                    $query = "select * from bbs_father_module ";
                    $result = execute($link,$query);
                    while ($data_father = mysqli_fetch_assoc($result)){
                        if($data['father_module_id'] == $data_father['id']){
                        echo  "<option selected='selected' value='{$data_father['id']}'>{$data_father['module_name']}</option>";
                        }else{
                        echo  "<option value='{$data_father['id']}'>{$data_father['module_name']}</option>";
                        }
                    }
                    ?>
                </select>
            </td>
            <tr>
                <td>版块名称</td>
                <td><input type="text" name="module_name" value="<?php echo $data['module_name']?>"/></td>
                <td>
                    板块名不能为空，最大不能超过50个字符！
                </td>
            </tr>
            <tr>
                <td>版块简介</td>
                <td><textarea  name="info"><?php echo $data['info']?></textarea></td>
                <td>
                    板块简介不能为空，最大不能超255个字符！
                </td>
            </tr>
            <tr>
                <td>版主</td>
                <td>
                    <select name="member_id">
                        <option value="0">===请选择一个会员作为版主===</option>
                    </select>
                </td>
                <td>
                    请选择一个会员作为版主！
                </td>
            </tr>
            <tr>
                <td>排序</td>
                <td><input type="text" name="sort" value="<?php echo $data['sort']?>"/></td>
                <td>
                    填写一个数字即可！
                </td>
            </tr>
        </table>
        <input style="margin-top: 20px;cursor: pointer" class="btn" type="submit" name="submit" value="修改" />
    </form>
</div>

<?php include_once 'inc/footer.inc.php';?>


