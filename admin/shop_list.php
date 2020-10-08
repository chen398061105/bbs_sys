<?php
include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';

$link = content();
include_once '../admin/inc/is_admin_login.php';

if (isset($_POST['submit'])){
    $_POST = escape($link,$_POST);
//    var_dump($_POST);exit;
    foreach($_POST['status'] as $key=>$value){
        if (!is_numeric($value) || !in_array($value,array(0,1,2)) ){
            skip('shop_list.php','error','输入内容不合法！');
        }
        $query[] = "update shop_list set status = {$value} where id = {$key}";
    }
    $result = execute_multi($link,$query,$error);
    if ($result){
        skip('shop_list.php','ok','修改成功！');
    }else{
        skip('shop_list.php','error','修改失败！'.$error);
    }
}
$Title['title'] = '商品列表页';
?>
<?php include 'inc/header.inc.php' ?><!-- 共通的头部-->
<div id="main" ">
<div class="title">商品列表</div>
<br>
<div class="search">
    <form action="admin.search.php" method="post">
    请输入搜索关键字: <input type="search" name="keyword" placeholder="模糊检索商品名" value=""/>
        <input name="search" type="submit"  value="检索"/>
    </form>
</div>
<form method="post">
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
        $query = 'select * from shop_list';
        $result = execute($link, $query);
        $id = 1;
        while ($data = mysqli_fetch_assoc($result)) {
            //中转跳转页面
            $url = urldecode("shop_del.php?id={$data['id']}");
            $return_url = urldecode($_SERVER['REQUEST_URI']);
            $msg = urldecode("你真的要删除该商品[{$data['name']}]吗？");
            $del_url = "confirm.php?url={$url}&return_url={$return_url}&msg={$msg}";
            ?>
            <tr>
                <td><?php echo $id++; ?></td>
                <td><?php echo $data['name']; ?></td>
                <td><?php echo $data['jan']; ?></td>
                <td>
                    <?php
                    if ($data['status'] == '0') {
                        echo '准备完了['.$data['status'].']';
                    } elseif ($data['status'] == '1') {
                        echo '准备中['.$data['status'].']';
                    } else {
                        echo '未准备['.$data['status'].']';
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
    <input style="margin-top: 20px;cursor: pointer" class="btn" type="submit" name="submit" value="批量修改状态"/>
    <div><br>
    <p style="color: red">*状态码[0]==准备完了,[1]==准备中,[2]==未准备</p>
    </div>
</form>
</div>


<?php include 'inc/footer.inc.php' ?><!-- 共通的底部-->