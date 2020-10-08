<?php
include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';

$link = content();
include_once '../admin/inc/is_admin_login.php';
if (empty($_POST['keyword'])) {
    $_POST['keyword'] = '';
}
if (isset($_POST['search'])) {
    $_POST = escape($link, $_POST);
    $_POST['keyword'] = trim($_POST['keyword']);
    $query = "select count(*) from shop_list where name  like '%{$_POST['keyword']}%'";
    $count_all = num($link, $query);
}

$Title['title'] = '商品检索';
?>
<?php include 'inc/header.inc.php' ?><!-- 共通的头部-->
<div id="main" ">
<div class="title">检索结果</div>
<br>
<div class="search">
    <form action="admin.search.php" method="post">
        请输入搜索关键字: <input type="search" name="keyword" placeholder="模糊检索商品名" value="<?php
        if (isset($_POST['keyword'])) {
            echo $_POST['keyword'];
        }
        ?>"/>
        <input name="search" type="submit" value="检索"/>
    </form>
</div>
<h3>共有 <?php echo $count_all ?> 条符合结果</h3>
<table class="list">
    <tr>
        <th>NO</th>
        <th>商品名</th>
        <th>商品条纹码</th>
        <th>状态</th>
        <th>状态码</th>
        <th>操作</th>
    </tr>
    <?php
    $query = "select * from shop_list where name like '%{$_POST['keyword']}%'";
    $result = execute($link, $query);
    $id = 1;
    while ($data = mysqli_fetch_assoc($result)) {
        $data['name_color'] = str_replace($_POST['keyword'],"<span style='color:red;'>{$_POST['keyword']}</span>",$data['name']);
        //中转跳转页面
        $url = urldecode("shop_del.php?id={$data['id']}");
        $return_url = urldecode($_SERVER['REQUEST_URI']);
        $msg = urldecode("你真的要删除该商品[{$data['name']}]吗？");
        $del_url = "confirm.php?url={$url}&return_url={$return_url}&msg={$msg}";
        ?>
        <tr>
            <td><?php echo $id++; ?></td>
<!--            <td>--><?php //echo $data['name']; ?><!--</td>-->
            <td><?php echo $data['name_color']; ?></td>

            <td><?php echo $data['jan']; ?></td>
            <td>
                <?php
                if ($data['status'] == '0') {
                    echo '准备完了[' . $data['status'] . ']';
                } elseif ($data['status'] == '1') {
                    echo '准备中[' . $data['status'] . ']';
                } else {
                    echo '未准备[' . $data['status'] . ']';
                }
                ?>
            </td>
            <td><input class="sort" type="text" name="status[<?php echo $data['id'] ?>]"
                       value="<?php echo $data['status'] ?>"/></td>
            <td><a href="goods_info.php">[商品详情]</a>&nbsp;&nbsp;<a href="shop_update.php?id=<?php echo $data['id']; ?>">[编辑]</a>&nbsp;&nbsp;<a
                        href="<?php echo $del_url; ?>">[删除]</a></td>
        </tr>
    <?php } ?>
</table>
<div><br>
    <p style="color: red">*状态码[0]==准备完了,[1]==准备中,[2]==未准备</p>
</div>
</div>


<?php include 'inc/footer.inc.php' ?><!-- 共通的底部-->