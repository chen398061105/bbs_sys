<?php
include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
$link = content();
$member_id = is_login($link);
if (!$member_id) {
    skip('login.php', 'error', '登陆之后才能发帖！');
}

if (isset($_POST['submit'])) {
    include '../inc/check_publish.php';
    $query = "insert into bbs_content(module_id,title,content,time,member_id)
 values ({$_POST['module_id']},'{$_POST['title']}','{$_POST['content']}',now(),$member_id )";
    execute($link, $query);
    if (mysqli_affected_rows($link) == 1) {
        skip('publish.php', 'ok', '发布成功！');
    } else {
        skip('publish.php', 'error', '发布失败！');
    }
}
?>
<?php
$title['title'] = '帖子发布页';
include_once './inc/header.inc.php'; ?>
    <div id="position" class="auto">
        <a href="index.php">首页</a> &gt; 发布帖子
    </div>
    <div id="publish">
        <form method="post">
            <select name="module_id">
                <option value='-1'>===请选择一个版块===</option>
                <?php
                //父版块过来时候默认选择只有父版块内容
                if (isset($_GET['fat_pub']) && is_numeric($_GET['fat_pub'])) {
                    $where = "where id = {$_GET['fat_pub']} ";
                }
                $query = "select * from bbs_father_module {$where} order by sort desc ";
                $result_father = execute($link, $query);
                while ($data_father = mysqli_fetch_assoc($result_father)) {
                    echo "<optgroup label='{$data_father['module_name']}'>";
                    $query = "select * from bbs_son_module where father_module_id = {$data_father['id']} order by sort desc ";
                    $result_son = execute($link, $query);
                    while ($data_son = mysqli_fetch_assoc($result_son)) {
                        if (isset($_GET['son_pub']) && $_GET['son_pub'] == $data_son['id']) {//子版块过来默认选择判断
                            echo "<option selected value='{$data_son['id']}'>{$data_son['module_name']}</option>";
                        } else {
                            echo "<option value='{$data_son['id']}'>{$data_son['module_name']}</option>";
                        }
                    }
                }
                echo "</optgroup>";
                ?>
            </select>
            <input class="title" placeholder="请输入标题" name="title" type="text"/>
            <textarea name="content" class="content"></textarea>
            <input class="publish" type="submit" name="submit" value="发布"/>
            <div style="clear:both;"></div>
        </form>
    </div>
<?php
include_once './inc/footer.inc.php'; ?>