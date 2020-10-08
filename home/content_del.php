<?php
include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';

$link = content();
$member_id = is_login($link);
$admin_id = is_admin_login($link);
if (!$member_id && !$admin_id) {
    skip('login.php', 'error', '登陆之后才能操作！');
}
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    skip('index.php', 'error', '帖子ID参数不合法！');
}
//是否属于自己发的贴
$query = "select member_id from bbs_content where id = {$_GET['id']} ";
$result_content = execute($link, $query);

if (mysqli_num_rows($result_content) == 1) {
    $data_content = mysqli_fetch_assoc($result_content);
    //获取到member_id和$data_content['id']
    if (check_perm($member_id, $data_content['member_id'],$admin_id)) {
        $query = "delete from bbs_content where id ={$_GET['id']} ";
        execute($link, $query);
        if (mysqli_affected_rows($link) == 1) {
            skip("member.php?id={$member_id}", 'ok', '删除成功！');
        } else {
            skip("member.php?id={$member_id}", 'error', '删除失败！');
        }
    } else {
        skip('index.php', 'error', '您无权删除他人的帖子！');
    }
} else {
    skip('index.php', 'error', '帖子不存在！');
}


$title['title'] = '删除操作页';
include_once './inc/header.inc.php'; ?>

<?php
include_once './inc/footer.inc.php'; ?>