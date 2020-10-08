<?php
include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
include_once '../inc/page.php';
$link = content();
$member_id = is_login($link);
$admin_id = is_admin_login($link);

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    skip('index.php', 'error', '会员ID参数不合法！');
}
//查找是否存在该会员
$query = "select * from bbs_member where id = {$_GET['id']}";
$result_member = execute($link, $query);
if (mysqli_num_rows($result_member) != 1) {
    skip('index.php', 'error', '该会员不存在！');
}
$data_member = mysqli_fetch_assoc($result_member);

$query3 = "select count(*) from bbs_content where member_id = {$_GET['id']}";
$count_all = num($link, $query3);

$title['title'] = '会员中心';
include_once './inc/header.inc.php';
?>
<div style="margin-top:55px;"></div>
<div id="position" class="auto">
    <a href="index.php">首页</a> &gt; <?php echo $data_member['name'] ?>
</div>
<div id="main" class="auto">
    <div id="left">
        <ul class="postsList">
            <?php
            $page = page($count_all, 10);
            $query = "select bbs_content.title,bbs_content.id,bbs_content.times,bbs_content.time,bbs_member.name,bbs_member.photo,bbs_content.member_id
                    from bbs_content ,bbs_member where bbs_content.member_id ={$_GET['id']}
                    and bbs_member.id = bbs_content.member_id {$page['limit']}";
            $result = execute($link, $query);

            while ($data_content = mysqli_fetch_assoc($result)) {
                $data_content['title'] = htmlspecialchars($data_content['title']);
                //最后回复时间检索语句
                $query2 = "select time from bbs_replay where content_id = {$data_content['id']} order by id desc limit 1";
                $result_replay = execute($link, $query2);
                if (mysqli_num_rows($result_replay) == 0) {
                    $last_time = "暂无回复";
                } else {
                    $data_replay = mysqli_fetch_assoc($result_replay);
                    @$last_time = $data_replay['time'];
                }
//                //检索回复次数
                $query = "select count(*) from bbs_replay where content_id = {$data_content['id']} ";
                $count = num($link, $query);
                ?>
                <li>
                    <div class="smallPic">
                        <img width="45" height="45" src="
                            <?php
                        if ($data_member['photo'] != '') {
                            echo SUB_URL.$data_member['photo'];
                        } else {
                            echo "style/photo.jpg";
                        }
                        ?>">
                    </div>
                    <div class="subject">
                        <div class="titleWrap"><h2><a target="_blank"
                                                      href="show.php?id=<?php echo $data_content['id'] ?>"><?php echo $data_content['title'] ?></a>
                            </h2></div>
                        <p>
                            <?php
                            if (check_perm($member_id, $data_content['member_id'],$admin_id)) {
                                $url = urldecode("content_del.php?id={$data_content['id']}");
                                $return_url = urldecode($_SERVER['REQUEST_URI']);
                                $msg = urldecode("你真的要删除帖子[{$data_content['title']}]吗？");
                                $del_url = "../inc/confirm.php?url={$url}&return_url={$return_url}&msg={$msg}";
                                $html = <<<A
                              <a target='_blank' href="./content_update.php?id={$data_content['id']}">编辑</a> | <a href=" {$del_url}">删除</a>
A;
                                echo $html;
                            } ?>
                            发布时间：<?php echo $data_content['time'] ?> 最后回复：<?php echo $last_time ?>
                        </p>
                    </div>
                    <div class="count">
                        <p>
                            回复<br/><span><?php echo $count ?></span>
                        </p>
                        <p>
                            浏览<br/><span><?php echo $data_content['times'] ?></span>
                        </p>
                    </div>
                    <div style="clear:both;"></div>
                </li>
            <?php } ?>
        </ul>
        <div class="pages">
            <?php
            echo $page['html'];
            ?>
        </div>
    </div>
    <div id="right">
        <div class="member_big">
            <dl>
                <dt>
                    <img width="180" height="180" src="
                    <?php
                    if ($data_member['photo'] != '') {
                        echo $data_member['photo'];
                    } else {
                        echo "style/photo.jpg";
                    }
                    ?>"/>
                </dt>
                <dd class="name">楼主：<?php echo $data_member['name'] ?></dd>
                <dd>帖子总计：<?php echo $count_all ?></dd>
                <?php
                if (check_perm($member_id, $data_member['id'],$admin_id)) {
//                    $url = urldecode("content_del.php?id={$data_content['id']}");
//                    $return_url = urldecode($_SERVER['REQUEST_URI']);
//                    $msg = urldecode("你真的要删除帖子[{$data_content['title']}]吗？");
//                    $del_url = "../inc/confirm.php?url={$url}&return_url={$return_url}&msg={$msg}";
                    $html = <<<A
                               <dd>操作：<a target="_blank" href="./upload.php">修改头像</a> | <a target="_blank" href="../inc/photo_upload.php">修改密码</a></dd>
A;
                    echo $html;
                } ?>

            </dl>
            <div style="clear:both;"></div>
        </div>
    </div>
    <div style="clear:both;"></div>
</div>

<?php
include_once './inc/footer.inc.php'; ?>
