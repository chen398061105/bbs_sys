
<?php
include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
$link = content();
include_once 'inc/is_admin_login.php';
if (isset($_POST['submit'])){
    $flag = 'add';
    include 'inc/check.father.module.inc.php';

    //插入数据
    $query = "insert into bbs_father_module(module_name,sort) values ('{$_POST['module_name']}',{$_POST['sort']})";
    execute($link,$query);
    if (mysqli_affected_rows($link)==1){
        skip('father.module.php','ok','添加成功！');
    }else{
        skip('father.module.add.php','error','添加失败！');

    }
}
$Title['title'] = '父板块添加页';
?>
<?php include_once 'inc/header.inc.php';?>
<div id="main">
    <div class="title">添加父板块</div>
    <form method="post" >
        <table class="au">
            <tr>
                <td>版块名称</td>
                <td><input type="text" name="module_name"/></td>
                <td>
                    板块名不能为空，最大不能超过50个字符！
                </td>
            </tr>
            <tr>
                <td>排序</td>
                <td><input type="text" name="sort" value="0"/></td>
                <td>
                    填写一个数字即可！
                </td>
            </tr>
        </table>
        <input style="margin-top: 20px;cursor: pointer" class="btn" type="submit" name="submit" value="添加" />
    </form>
</div>

<?php include_once 'inc/footer.inc.php';?>


