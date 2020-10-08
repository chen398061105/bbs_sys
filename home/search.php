<?php
include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
include_once '../inc/page.php';
$link = content();
$member_id = is_login($link);
$admin_id = is_admin_login($link);
if (empty($_POST['keyword'])){
//    $_POST['keyword']= '';
    skip('index.php','error','检索内容不可为空');
}
if (isset($_POST['submit'])){
    $_POST = escape($link,$_POST);
    $_POST['keyword'] = trim($_POST['keyword']);
    $query = "select count(*) from bbs_content where title like '%{$_POST['keyword']}%'";
    $count_all = num($link,$query);
}
$title['title'] = '搜索页';
include_once './inc/header.inc.php';
?>

<div id="position" class="auto">
    <a href="index.php">首页</a>>检索结果
</div>
<div id="main" class="auto">
    <div id="left">
        <div class="box_wrap">
            <h3>共有<?php echo  $count_all?>条帖子符合结果</h3>
            <div class="pages_wrap">
                <div class="pages">
                    <?php
                    $page = page($count_all, 5, 10, 'page');
                    echo $page['html'];
                    ?>
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>
        <div style="clear:both;"></div>
        <ul class="postsList">
            <?php
            $query = "select bbs_content.title,bbs_content.id,bbs_content.times,bbs_content.time,bbs_member.name,bbs_member.photo,bbs_content.member_id 
                    from bbs_content ,bbs_member where bbs_content.title like '%{$_POST['keyword']}%' 
                    and bbs_member.id = bbs_content.member_id {$page['limit']}";

            $result_content = execute($link, $query);
            while ($data_content = mysqli_fetch_assoc($result_content)) {
                $data_content['title'] = htmlspecialchars($data_content['title'] );
                $data_content['title_color'] = str_replace($_POST['keyword'],"<span style='color:red;'>{$_POST['keyword']}</span>",$data_content['title']);
                //最后回复时间检索语句
                $query = "select time from bbs_replay where content_id = {$data_content['id']} order by id  desc  limit 1";
                $result = execute($link,$query);
                if ( mysqli_num_rows($result) == 0 ){
                    $last_time =  "暂无回复";
                }else{
                    $data_last_time = mysqli_fetch_assoc($result);
                    $last_time = $data_last_time['time'];
                }

                //检索回复次数
                $query = "select count(*) from bbs_replay where content_id = {$data_content['id']} ";
                $count = num($link,$query);
                ?>
                <li>
                    <div class="smallPic">
                        <a target="_blank" href="./member.php?id=<?php echo $data_content['member_id']?>">
                            <img width="45" height="45" src="
                        <?php
                            if ($data_content['photo'] != '') {
                                echo SUB_URL.$data_content['photo'];
                            } else {
                                echo "style/photo.jpg";
                            }
                            ?>">
                        </a>
                    </div>
                    <div class="subject">
                        <div class="titleWrap"><h2><a target="_blank" href="show.php?id=<?php echo $data_content['id'] ?>"><?php echo  $data_content['title_color']?></a></h2></div>
                        <p>
                            楼主：<?php echo $data_content['name'] ?>&nbsp;<?php echo $data_content['time']?>&nbsp;&nbsp;&nbsp;&nbsp;最后回复：<?php echo $last_time?><br>
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
                            }

                            ?>
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
            <?php }?>
        </ul>
        <div class="pages_wrap">
            <div class="pages">
                <?php
                echo $page['html'];
                ?>
            </div>
            <div style="clear:both;"></div>
        </div>
    </div>
    <?php include_once './inc/side.php' ?>
    <div style="clear:both;"></div>
</div>

<?php
include_once './inc/footer.inc.php'; ?>
