<?php

include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
include_once '../inc/page.php';
$link = content();
$member_id = is_login($link);
if (!$member_id) {
    skip('login.php', 'error', '登陆之后才能回复！');
}
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    skip('index.php', 'error', 'ID参数不合法！');
}
//表单验证
if (isset($_POST['submit'])){
    include '../inc/check_replay.php';
    escape($link,$_POST);
    $query = "insert into bbs_replay(content_id,content,time,member_id)
              values ( {$_GET['id']},'{$_POST['content']}',now(),{$member_id})";
    execute($link,$query);
    if (mysqli_affected_rows($link) == 1){
        skip("show.php?id={$_GET['id']}", 'ok', '回复成功！');
    }else{
        skip($_SERVER['REQUEST_URI'], 'error', '回复失败！');
    }

}
//查询是否存在DB
$query = "select bc.id,bc.title ,bm.name from bbs_content bc,bbs_member bm where bc.id = {$_GET['id']} and bm.id =bc.member_id";
$result_content = execute($link,$query);
if (mysqli_num_rows($result_content) !=1){
    skip('index.php', 'error', '查无此贴');
}
$result_data = mysqli_fetch_assoc($result_content);
//适当转义html代码，以及换行
$result_data['title'] = nl2br(htmlspecialchars($result_data['title']));


$title['title'] = '回复页面';
include_once './inc/header.inc.php';
?>
<div id="position" class="auto">
    <a href="index.php">首页</a> &gt;回复帖子
</div>
<div id="publish">
    <div>回复：由 [<?php echo $result_data['name'] ?>] 发布的 [<?php echo $result_data['title'] ?>]</div>
    <form method="post">
        <textarea name="content" class="content"></textarea>
        <input class="reply" type="submit" name="submit" value="" />
        <div style="clear:both;"></div>
    </form>
</div>

<?php
include_once './inc/footer.inc.php'; ?>

