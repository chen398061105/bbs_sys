<?php
include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
$link = content();
include_once 'inc/is_admin_login.php';

$Title['title'] = '账号列表页';
?>
<?php include 'inc/header.inc.php' ?><!-- 共通的头部-->

<div id="main" ">
<div class="title">账号列表</div>
<form method="post">
    <table class="list">
        <tr>
            <th>管理员名称</th>
            <th>创建时间</th>
            <th>等级</th>
            <th>操作</th>
        </tr>
        <?php
        $query = 'select * from bbs_manage';
        $result = execute($link, $query);
        while ($data = mysqli_fetch_assoc($result)) {
            //中转跳转页面
            $url = urldecode("manage.del.php?id={$data['id']}");
            $return_url = urldecode($_SERVER['REQUEST_URI']);
            $msg = urldecode("你真的要删除账户[{$data['name']}]吗？");
            $del_url = "confirm.php?url={$url}&return_url={$return_url}&msg={$msg}";
            ?>
            <tr>
                <td><?php echo $data['name'] ?></td>
                <td><?php echo $data['create_time'] ?></td>
                <td><?php echo ($data['level']==1)?'普通管理员':'超级管理员'?></td>
<!--                <td><a href="">[编辑]</a>&nbsp;&nbsp;<a-->
                           <td><a href="<?php echo $del_url?>">[删除]</a></td>
            </tr>
        <?php } ?>
    </table>
<!--    <input style="margin-top: 20px;cursor: pointer" class="btn" type="submit" name="submit" value="修改排序"/>-->
</form>
</div>


<?php include 'inc/footer.inc.php' ?><!-- 共通的底部-->