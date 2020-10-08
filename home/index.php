<?php
include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
$link = content();

$member_id = is_login($link);
?>
<?php
$title['title'] = '首页';
include_once './inc/header.inc.php'; ?>

    <div style="margin-top:55px;"></div>
    <div id="hot" class="auto">
        <div class="title">热门动态</div>
        <ul class="newlist">
            <!-- 20条 -->
            <li><a href="#">[BBS]</a> <a href="#">初次安装数据需要从后台登陆 添加</a></li>

        </ul>
        <div style="clear:both;"></div>
    </div>
<?php
$query = "select * from bbs_father_module order by sort desc ";
$result_father = execute($link, $query);
while ($data_father = mysqli_fetch_assoc($result_father)) { ?>
    <div class="box auto">
        <div class="title">
           <a href="list_father.php?id=<?php echo $data_father['id'] ?>"><?php echo $data_father['module_name'] ?></a>
        </div>
        <div class="classList">
            <?php
            $query = "select * from bbs_son_module where father_module_id = {$data_father['id']}";
            $result_son = execute($link, $query);
            if (mysqli_num_rows($result_son)) {
                while ($data_son = mysqli_fetch_assoc($result_son)) {
                    $query = "select count(*) from bbs_content where module_id ={$data_son['id']} and time >CURDATE()";
                    $count = num($link, $query);
                    $query_all = "select count(*) from bbs_content where module_id ={$data_son['id']} ";
                    $count_all = num($link, $query_all);

                    $html = <<<A
            <div class="childBox new">
                <h2><a href="./list_son.php?id={$data_son['id']}">{$data_son['module_name']}</a> <span>(今日{$count})</span></h2> 帖子：{$count_all}<br />
            </div>
A;
                    echo $html;
                }
            } else {
                echo '<div style="padding: 10px 0">暂无子版块</div>';
            }
            ?>
            <div style="clear:both;"></div>
        </div>
    </div>
<?php } ?>
<?php
include_once './inc/footer.inc.php'; ?>