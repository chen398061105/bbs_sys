
<?php
include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
$link = content();
include_once 'inc/is_admin_login.php';
if (isset($_POST['submit'])){
    $flag = 'add';
    include 'inc/check.manage.inc.php';
    //插入数据

    $_POST = escape($link,$_POST);
    $query = "insert into bbs_manage(name,pwd,create_time,level) 
              values ('{$_POST['name']}',md5('{$_POST['pwd']}'),now(),{$_POST['level']} )";
    execute($link,$query);
    if (mysqli_affected_rows($link)==1){
        skip('manage.show.php','ok','添加成功！');
    }else{
        skip('manage.show.php','error','添加失败！');

    }
}
$Title['title'] = '管理员添加';
?>
<?php include_once 'inc/header.inc.php';?>
<div id="main">
    <div class="title">添加管理员</div>
    <form method="post" >
        <table class="au">
            <tr>
                <td>管理员名称</td>
                <td><input type="text" name="name"/></td>
                <td>
                    管理员名称不能为空，最大不能超过32个字符！
                </td>
            </tr>
            <tr>
                <td>密码</td>
                <td><input type="text" name="pwd" /></td>
                <td>
                    密码不能为空，最大不能超过32个字符！
                </td>
            </tr>
            <tr>
                <td>等级</td>
                <td>
                    <select name="level">
                        <option value="1" selected>普通管理员</option>
                        <option value="0" >超级管理员</option>
                    </select>
                </td>
                <td>
                    等级默认普通管理员！不具备后台管理员权限！
                </td>
            </tr>
        </table>
        <input style="margin-top: 20px;cursor: pointer" class="btn" type="submit" name="submit" value="添加" />
    </form>
</div>

<?php include_once 'inc/footer.inc.php';?>


