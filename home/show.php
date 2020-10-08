<?php
include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
include_once '../inc/page.php';
$link = content();
$member_id = is_login($link);

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    skip('index.php', 'error', '帖子ID参数不合法！');
}
//需要做防注入措施
$query1 = "select bc.id,bc.module_id,bc.title,bc.content,bc.time,bc.member_id ,bc.times ,bs.name,bs.photo
from bbs_content bc,bbs_member bs where bc.id = {$_GET['id']} and bc.member_id = bs.id";
$result_content = execute($link, $query1);
$data_content = mysqli_fetch_assoc($result_content);

if (mysqli_num_rows($result_content) != 1) {
    skip('index.php', 'error', '帖子不存在！');
}
//阅读量+1处理
$data_content['times'] = $data_content['times'] + 1;
$query = "update bbs_content set times = times+1 where id = {$_GET['id']}";
execute($link, $query);

//适当转义html代码，以及换行
$data_content['title'] = nl2br(htmlspecialchars($data_content['title']));
$data_content['content'] = nl2br(htmlspecialchars($data_content['content']));

//子版块信息
$query = "select * from bbs_son_module where id ={$data_content['module_id']}";
$result_son = execute($link, $query);
$data_son = mysqli_fetch_assoc($result_son);

//父版块信息
$query = "select * from bbs_father_module where id ={$data_son['father_module_id']}";
$result_father = execute($link, $query);
$data_father = mysqli_fetch_assoc($result_father);


$title['title'] = '帖子详细页';
include_once './inc/header.inc.php';
?>
<div id="position" class="auto">
    <a href="index.php">首页</a> &gt; <a
            href="./list_father.php?id=<?php echo $data_father['id'] ?>"><?php echo $data_father['module_name'] ?></a>
    &gt;
    <a href="./list_son.php?id=<?php echo $data_son['id'] ?>"><?php echo $data_son['module_name'] ?></a>
    &gt; <?php echo $data_content['title'] ?>
</div>
<div id="main" class="auto">
    <div class="wrap1">
        <div class="pages">
            <?php
            //分页
            $query = "select count(*) from bbs_replay where content_id = {$_GET['id']} ";
            $count_replay = num($link, $query);
            $page = page($count_replay, 3);
            echo $page['html'];
            ?>
        </div>
        <a class="btn reply" href="./replay.php?id=<?php echo $_GET['id'] ?>"></a>
        <div style="clear:both;"></div>
    </div>
    <!--    楼主页 第二页开始不显示 开始 -->
    <?php if (isset($_GET['page']) && $_GET['page'] == 1) { ?>
        <div class="wrapContent">
            <div class="left">
                <div class="face">
                    <a target="_blank" href="">
                        <img src="<?php
                        if ($data_content['photo'] != '') {
                            echo $data_content['photo'];
                        } else {
                            echo "style/2374101_middle.jpg";
                        }
                        ?>">
                    </a>
                </div>
                <div class="name">
                    <a href=""><?php echo $data_content['name'] ?></a>
                </div>
            </div>
            <div class="right">
                <div class="title">
                    <h2><?php echo $data_content['title'] ?></h2>
                    <?php
                    $query = "select count(*) from bbs_replay where content_id = {$data_content['id']} ";
                    $count = num($link, $query);
                    ?>
                    <span>阅读：<?php echo $data_content['times'] ?>&nbsp;|&nbsp;回复：<?php echo $count ?></span>
                    <div style="clear:both;"></div>
                </div>
                <div class="pubdate">
                    <span class="date">发布于：<?php echo $data_content['time'] ?> </span>
                    <span class="floor" style="color:red;font-size:14px;font-weight:bold;">楼主</span>
                </div>
                <div class="content">
                    <?php echo $data_content['content'] ?>
                </div>
            </div>
            <div style="clear:both;"></div>
        </div>
    <?php } ?>
    <!--    楼主页 第二页开始不显示 结束 -->
    <?php
    $query = "select br.member_id,bm.name,bm.photo ,br.time,br.id ,br.content ,br.quote_id
              from bbs_replay br,bbs_member bm where br.member_id = bm.id and br.content_id = {$_GET['id']} order by id asc {$page['limit']}";
    $result_replay = execute($link, $query);
    if (mysqli_num_rows($result_replay) == 0) {
        echo "<h1 style='color: red ;text-align: center;font-size: 20px'>空贴：帖子尚无回复内容！请点击回复按钮</h1>";
        exit;
    }
    if (isset($_GET['page'])) {
        $num = ($_GET['page'] - 1) * 3 + 1;//楼层，当前页的前页乘以每页显示数 +1
    }
    while ($data_replay = mysqli_fetch_assoc($result_replay)) {
        $data_replay['content'] = nl2br(htmlspecialchars($data_replay['content']));//这里已经转义了，回复发帖是不需要再转义
        ?>
        <div class="wrapContent">
            <div class="left">
                <div class="face">
                    <a target="_blank" href="">
                        <img src="<?php
                        if ($data_replay['photo'] != '') {
                            echo $data_replay['photo'];
                        } else {
                            echo "style/2374101_middle.jpg";
                        }
                        ?>">
                    </a>
                </div>
                <div class="name">
                    <a href=""><?php echo $data_replay['name']; ?></a>
                </div>
            </div>
            <div class="right">

                <div class="pubdate">
                    <span class="date">回复时间：<?php echo $data_replay['time']; ?></span>
                    <!--                    引用回复需要带当前id和引用的id过去-->
                    <span class="floor"><?php echo $num++ ?>楼&nbsp;|&nbsp;
                        <a target="_blank"
                           href="./quote.php?id=<?php echo $_GET['id'] ?>&replay_id=<?php echo $data_replay['id'] ?>">引用</a></span>
                </div>
                <div class="content">
                    <?php
                    //DB quote_id 不为 0时候则有引用
                    if ($data_replay['quote_id']) {
                        $query = "select count(*) from bbs_replay where content_id ={$_GET['id']} and id <={$data_replay['quote_id']}";
                        $result = execute($link, $query);
                        $floor = num($link, $query);
                        //引用回复
                        $query = "select bm.name ,br.content from bbs_member bm,bbs_replay br 
                            where br.member_id = bm.id and br.id = {$data_replay['quote_id']} ";
                        $result_quote = execute($link, $query);
                        //帖子被删除情况，或者过期时候追加判断？
//                        if (mysqli_num_rows($result_quote) != 1) {
//                            skip($_SERVER['HTTP_REFERER'], 'error', '引用帖子不存在！');
//                        }
                        $data_quote = mysqli_fetch_assoc($result_quote);
                        ?>
                        <div class="quote">
                            <h2>引用 <?php echo $floor ?>楼 <?php echo $data_quote['name'] ?> 发表的: </h2>
                            <?php echo nl2br(htmlspecialchars($data_quote['content'])) ?>
                        </div>
                    <?php } ?>
                    <?php echo $data_replay['content']; ?>
                </div>
            </div>
            <div style="clear:both;"></div>
        </div>
    <?php } ?>

    <div class="wrap1">
        <div class="pages">
            <?php echo $page['html']; ?>
        </div>
        <a class="btn reply" href="./replay.php?id=<?php echo $_GET['id'] ?>"></a>
        <div style="clear:both;"></div>
    </div>
</div>
<?php
include_once './inc/footer.inc.php'; ?>
