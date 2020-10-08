
<?php
include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
$link = content();
include_once 'inc/is_admin_login.php';
$query = "select * from bbs_father_module where id = {$_GET['id']}";
$result = execute($link,$query);
//判断id参数是否有误
if(!isset($_GET['id']) || !is_numeric($_GET['id']) ){
    skip('father.module.php','error','这条信息不存在！');
}
//判断DB记录是否存在
if (!mysqli_num_rows($result)){
    skip('father.module.php','error','这条信息不存在！');
}
$data = mysqli_fetch_assoc($result);
//执行更新
if (isset($_POST['submit'])){
    //验证数据
    $flag = 'update';
    include 'inc/check.father.module.inc.php';

    $query = "update bbs_father_module set module_name = '{$_POST['module_name']}',sort = {$_POST['sort']} where id = {$_GET['id']}" ;
    execute($link,$query);
    // 更新 影响行数
    if (mysqli_affected_rows($link) == 1){
        skip('father.module.php','ok','修改成功！');
    }else{
        skip('father.module.php','error','修改失败，请重试！');
    }
}
$Title['title'] = '父板块修改页面';
?>
<?php include_once 'inc/header.inc.php';?>
<div id="main">
    <div class="title">修改父板块-<?php echo $data['module_name']?></div>
    <form method="post" >
        <table class="au">
            <tr>
                <td>版块名称</td>
                <td><input type="text" name="module_name" value="<?php echo $data['module_name']?>"/></td>
                <td>
                    板块名不能为空，最大不能超过50个字符！
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


