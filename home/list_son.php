<?php
include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
include_once '../inc/page.php';
$link = content();
$member_id = is_login($link);
$admin_id = is_admin_login($link);
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    skip('index.php', 'error', '子版块ID参数不合法！');
}
$query1 = "select * from bbs_son_module where id = {$_GET['id']}";
$result_son = execute($link, $query1);
if (mysqli_num_rows($result_son) != 1) {
    skip('index.php', 'error', '子版块不存在！');
}
$data_son = mysqli_fetch_assoc($result_son);

$query2 = "select * from bbs_father_module where id = {$data_son['father_module_id']} ";
$result_father = execute($link, $query2);
$data_father = mysqli_fetch_assoc($result_father);

//查找版主
$query = "select * from bbs_member where id = {$data_son['member_id']} ";
$result_member = execute($link, $query);

//发帖数计算
$query3 = "select count(*) from bbs_content where module_id ={$_GET['id']}";
$count_all = num($link, $query3);
$query4 = "select count(*) from bbs_content where module_id ={$_GET['id']} and time > CURDATE()";
$count_today = num($link, $query4);

?>
<?php
$title['title'] = '子版块首页';
include_once './inc/header.inc.php'; ?>
<div id="position" class="auto">
    <a href="index.php">首页</a> &gt;
    <a href="list_father.php?id=<?php echo $data_father['id'] ?>"><?php echo $data_father['module_name'] ?></a> &gt;
    <?php echo $data_son['module_name'] ?></a>
</div>
<div id="main" class="auto">
    <div id="left">
        <div class="box_wrap">
            <h3><?php echo $data_son['module_name'] ?></h3>
            <div class="num">
                今日：<span><?php echo $count_today ?></span>&nbsp;&nbsp;&nbsp;
                总帖：<span><?php echo $count_all ?></span>
            </div>
            <div class="moderator">版主：<span>
                    <?php
                    if (mysqli_num_rows($result_member) == 0) {
                        echo '暂无版主';
                    } else {
                        $data = mysqli_fetch_assoc($result_member);
                        echo $data['name'];
                    }

                    ?>
                </span></div>
            <div class="notice">简介:<?php echo $data_son['info'] ?></div>
            <div class="pages_wrap">
                <a class="btn publish" href="./publish.php?son_pub=<?php echo $_GET['id'] ?>" target="_blank"></a>
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
                    from bbs_content ,bbs_member where bbs_content.module_id ={$_GET['id']}
                    and bbs_member.id = bbs_content.member_id {$page['limit']}";

            $result_content = execute($link, $query);
            while ($data_content = mysqli_fetch_assoc($result_content)) {
                $data_content['title'] = htmlspecialchars($data_content['title'] );
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
                    <div class="titleWrap"><h2><a target="_blank" href="show.php?id=<?php echo $data_content['id'] ?>"><?php echo  $data_content['title']?></a></h2></div>
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
            <a class="btn publish" href="./publish.php?son_pub=<?php echo $_GET['id'] ?>" target="_blank"></a>
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
