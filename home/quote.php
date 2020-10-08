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

//查询是否存在DB
$query = "select bc.id,bc.title ,bm.name from bbs_content bc,bbs_member bm where bc.id = {$_GET['id']} and bm.id =bc.member_id";
$result_content = execute($link, $query);
if (mysqli_num_rows($result_content) != 1) {
    skip('index.php', 'error', '查无此贴');
}
$result_data = mysqli_fetch_assoc($result_content);
//适当转义html代码，以及换行
//$result_data['title'] = nl2br(htmlspecialchars($result_data['title']));

//计算楼数，引用验证
if (!isset($_GET['replay_id']) || !is_numeric($_GET['replay_id'])) {
    skip('index.php', 'error', '引用ID参数不合法！');
}
$query = "select br.content,bm.name from bbs_replay br,bbs_member bm where  br.id = {$_GET['replay_id']} and br.content_id ={$_GET['id']} and br.member_id = bm.id";
$result_replay = execute($link, $query);
if (mysqli_num_rows($result_replay) != 1) {
    skip('index.php', 'error', '查无此引用');
}
$data_replay = mysqli_fetch_assoc($result_replay);
$data_replay['content'] = nl2br(htmlspecialchars($data_replay['content']));

//表单验证
if (isset($_POST['submit'])) {
    include '../inc/check_replay.php';
    escape($link, $_POST);
    $query = "insert into bbs_replay(content_id,quote_id,content,time,member_id)
              values ( {$_GET['id']},{$_GET['replay_id']},'{$_POST['content']}',now(),{$member_id})";
    execute($link, $query);
    if (mysqli_affected_rows($link) == 1) {
        skip("show.php?id={$_GET['id']}", 'ok', '引用回复成功！');
    } else {
        skip($_SERVER['REQUEST_URI'], 'error', '引用回复失败！');
    }
}

//计算楼数，引用
$query = "select count(*) from bbs_replay where content_id ={$_GET['id']} and id <={$_GET['replay_id']}";
$result = execute($link, $query);
$floor = num($link, $query);

$title['title'] = '帖子引用页';
include_once './inc/header.inc.php';
?>
    <div id="publish">
        <div><?php echo $result_data['name'] ?>: <?php echo $result_data['title'] ?></div>
        <div class="quote">
            <p class="title">引用<?php echo $floor ?>楼 <?php echo $data_replay['name'] ?> 发表的: </p>
            <?php echo $data_replay['content'] ?>
        </div>
        <form method="post">
            <textarea name="content" class="content"></textarea>
            <input class="reply" type="submit" name="submit" value=""/>
            <div style="clear:both;"></div>
        </form>
    </div>

<?php include_once './inc/footer.inc.php'; ?>