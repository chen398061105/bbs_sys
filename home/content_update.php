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
$query = "select * from bbs_content where id = {$_GET['id']} ";
$result_content = execute($link, $query);

if (mysqli_num_rows($result_content) == 1) {
    $data_content = mysqli_fetch_assoc($result_content);
    $data_content['title'] = htmlspecialchars($data_content['title']);
    $data_content['content'] = nl2br(htmlspecialchars($data_content['content']));

    //获取到member_id和$data_content['id']
    if (check_perm($member_id, $data_content['member_id'],$admin_id)) {
        if (isset($_POST['submit'])) {
            include '../inc/check_publish.php';
            $query = "update bbs_content set module_id ={$_POST['module_id']},title ='{$_POST['title']}',content ='{$_POST['content']}' where id = {$_GET['id']} ";
            execute($link,$query);
            if (mysqli_affected_rows($link) ==1){
                skip("member.php?id={$member_id}", 'ok', '编辑成功！');
            }else{
                skip("member.php?id={$member_id}", 'error', '编辑失败！');
            }
        }
    } else {
        skip('index.php', 'error', '您无权编辑他人的帖子！');
    }
} else {
    skip('index.php', 'error', '帖子不存在！');
}


$title['title'] = '编辑操作页';
include_once './inc/header.inc.php'; ?>
    <div id="position" class="auto">
        <a href="index.php">首页</a> &gt; 修改帖子
    </div>
    <div id="publish">
        <form method="post">
            <select name="module_id">
<!--                <option value='-1'>===请选择一个版块===</option>-->
                <?php
                $query = "select * from bbs_father_module  order by sort desc ";
                $result_father = execute($link, $query);

                while ($data_father = mysqli_fetch_assoc($result_father)) {
                    echo "<optgroup label='{$data_father['module_name']}'>";
                    $query = "select * from bbs_son_module where father_module_id = {$data_father['id']} order by sort desc ";
                    $result_son = execute($link, $query);
                    while ($data_son = mysqli_fetch_assoc($result_son)) {
                        if ($data_content['module_id'] == $data_son['id']) {//子版块过来默认选择判断
                            echo "<option selected value='{$data_son['id']}'>{$data_son['module_name']}</option>";
                        } else {
                            echo "<option value='{$data_son['id']}'>{$data_son['module_name']}</option>";
                        }
                    }
                }
                echo "</optgroup>";
                ?>
            </select>
            <input class="title" placeholder="请输入标题" name="title" type="text" value="<?php echo  $data_content['title']?>"/>
            <textarea name="content" class="content"><?php echo  $data_content['content']?></textarea>
            <input style="margin-top: 20px;cursor: pointer;background: lightskyblue" class="btn" type="submit" name="submit" value="修改" />
            <div style="clear:both;"></div>
        </form>
    </div>
<?php
include_once './inc/footer.inc.php'; ?>