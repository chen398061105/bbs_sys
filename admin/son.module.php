<?php
include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
$link = content();
include_once 'inc/is_admin_login.php';
if (isset($_POST['submit'])) {
    foreach ($_POST['sort'] as $key => $value) {
        if (!is_numeric($key) || !is_numeric($value)) {
            skip('son.module.php', 'error', '输入内容不合法！');
        }
        $query[] = "update bbs_son_module set sort = {$value} where id = {$key}";
    }

    $result = execute_multi($link, $query, $error);
    if ($result) {
        skip('son.module.php', 'ok', '修改成功！');
    } else {
        skip('son.module.php', 'error', '修改失败！' . $error);
    }
}

$Title['title'] = '子板块列表页';
?>
<?php include 'inc/header.inc.php' ?><!-- 共通的头部-->

<div id="main" ">
<form method="post">
    <div class="title"><?php echo $Title['title'] ?></div>
    <table class="list">
        <tr>
            <th>排序</th>
            <th>版块名称</th>
            <th>所属父版块</th>
            <th>版主</th>
            <th>操作</th>
        </tr>
        <?php
        $query = 'select bsm.id,bsm.module_name,bsm.sort sort ,bsf.module_name father_module_name,bsm.member_id from bbs_son_module bsm,bbs_father_module bsf 
                  where bsm.father_module_id = bsf.id order by bsf.id';
        $result = execute($link, $query);
        while ($data = mysqli_fetch_assoc($result)) {
            //中转跳转页面
            $url = urldecode("son.module.del.php?id={$data['id']}");
            $return_url = urldecode($_SERVER['REQUEST_URI']);
            $msg = urldecode("你真的要删除子板块[{$data['module_name']}]吗？");
            $del_url = "confirm.php?url={$url}&return_url={$return_url}&msg={$msg}";
            $html = <<<A
       <tr>
            <td><input class="sort" type="text" name="sort[{$data['id']}]" value="{$data['sort']}"/></td>
            <td>{$data['module_name']}[Id:{$data['id']}]</td>
            <td>{$data['father_module_name']}</td>
            <td>{$data['member_id']}</td>
            <td><a href="inc/filedownload.php?id={$data['id']}">[文件下载]</a>&nbsp;&nbsp;<a href="son.module.update.php?id={$data['id']}">[编辑]</a>&nbsp;&nbsp;<a href="{$del_url}">[删除]</a></td>
        </tr>
A;
            echo $html;
        }

        ?>
    </table>
    <input style="margin-top: 20px;cursor: pointer" class="btn" type="submit" name="submit" value="修改排序"/>
</form>
</div>

<?php include 'inc/footer.inc.php' ?><!-- 共通的底部-->


