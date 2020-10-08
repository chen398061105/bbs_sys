
<?php
include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
$link = content();
include_once 'inc/is_admin_login.php';
if (isset($_POST['submit'])){
    $flag = 'add';
    include 'inc/check.son.module.inc.php';

    //插入数据
    $query = "insert into bbs_son_module(father_module_id,module_name,info,member_id,sort) 
              values ({$_POST['father_module_id']},'{$_POST['module_name']}','{$_POST['info']}',{$_POST['member_id']},{$_POST['sort']})";
    execute($link,$query);
    if (mysqli_affected_rows($link)==1){
        skip('son.module.php','ok','添加成功！');
    }else{
        skip('son.module.add.php','error','添加失败！');

    }
}
$Title['title'] = '子板块添加页';
?>
<?php include_once 'inc/header.inc.php';?>
<div id="main">
    <div class="title">添加子板块</div>
    <form method="post" >
        <table class="au">
            <tr>
                <td>所属父板块</td>
                <td>
                    <select name="father_module_id">
                        <option value="0">===请选择父版块===</option>
                        <?php
                        $query = "select * from bbs_father_module ";
                        $result = execute($link,$query);
                        while ($data = mysqli_fetch_assoc($result)){
                            echo  "<option value='{$data['id']}'>{$data['module_name']}</option>";
                        }
                        ?>
                    </select>
                </td>
                <td>
                    父版块必须选择！
                </td>
            </tr>
            <tr>
                <td>版块名称</td>
                <td><input type="text" name="module_name"/></td>
                <td>
                    板块名不能为空，最大不能超过50个字符！
                </td>
            </tr>
            <tr>
                <td>板块简介</td>
                <td><textarea name="info"></textarea></td>
                <td>
                    板块简介，最大不能超过255个字符！
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


