
<?php
include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
$link = content();
include_once 'inc/is_admin_login.php';
if (isset($_POST['submit'])){
//    $flag = 'add';
//    include 'inc/check.son.module.inc.php';
//暂时不做验证操作
    //插入数据
    $query = "insert into shop_list(name,jan,status) 
              values ( '{$_POST['name']}','{$_POST['jan']}',{$_POST['status']} )";
    execute($link,$query);
    if (mysqli_affected_rows($link)==1){
        skip('shop_list.php','ok','添加成功！');
    }else{
        skip('shop_add.php','error','添加失败！');

    }
}
$Title['title'] = '商品添加页';
?>
<?php include_once 'inc/header.inc.php';?>
<div id="main">
    <div class="title">商品添加</div>
    <form method="post" >
        <table class="au">
            <tr>
                <td>商品名</td>
                <td><input type="text" name="name"/></td>
                <td>
                    商品名不能为空，最大不能超过32个字符！
                </td>
            </tr>
            <tr>
                <td>JAN码</td>
                <td><input type="text" name="jan"/></td>
                <td>
                    JAN码不能为空，最大不能超过15个字符！
                </td>
            </tr>
            <tr>
                <td>商品名信息</td>
                <td><textarea name="info">暂无该表</textarea></td>
                <td style="color: red">
                    应该单独做一个表记载商品详细信息用！未做
                </td>
            </tr>
            <tr>
                <td>状态</td>
                <td><select name="status">
                        <option >==请选择状态===</option>
                        <?php
                        $query = "select status from shop_list order by id desc ";
                        $result = execute($link,$query);
                        while ($data =mysqli_fetch_assoc($result)){
                            echo "<option value='{$data['status']}'>{$data['status']}</option>";
                        }
                        ?>
                    </select>
                <td>
                    商品状态码:[0]准备完了 | [1]==准备中 | [2]==未准备
                </td>
            </tr>
        </table>
        <input style="margin-top: 20px;cursor: pointer" class="btn" type="submit" name="submit" value="添加" />
    </form>
</div>

<?php include_once 'inc/footer.inc.php';?>


