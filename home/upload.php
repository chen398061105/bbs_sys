<?php
include_once '../inc/config.php';
include_once '../inc/mysqli.inc.php';
include_once '../inc/tool.inc.php';
include_once '../inc/page.php';
include_once '../inc/photo_upload.php';

$link = content();
$member_id = is_login($link);
if (!$member_id) {
    skip('login.php', 'error', '登陆之后才能修改头像！');
}

if (isset($_POST['submit'])) {
    //保存路径
    $save_path = 'uploads/' .date('Y-m-d');
    echo $save_path;
    $upload = upload($save_path, '8m', 'photo');

    if ($upload['return']) {
        $query = "update bbs_member set photo = '{$upload['save_path']}' where id = {$member_id}";
        execute($link, $query);
        if (mysqli_affected_rows($link) == 1) {
            skip("member.php?id={$member_id}", 'ok', '上传成功！');
        } else {
            skip("member.php?id={$member_id}", 'ok', '上传成功！');
        }
    } else {
        skip('upload.php', 'error', $upload['err']);
    }
}
//查找图像
$query = "select photo from bbs_member where id = {$member_id}";
$result = execute($link,$query);
$data = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8"/>
    <title>上传中心</title>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <style type="text/css">
        body {
            font-size: 12px;
            font-family: 微软雅黑;
        }

        h2 {
            padding: 0 0 10px 0;
            border-bottom: 1px solid #e3e3e3;
            color: #444;
        }

        .submit {
            background-color: #3b7dc3;
            color: #fff;
            padding: 5px 22px;
            border-radius: 2px;
            border: 0px;
            cursor: pointer;
            font-size: 14px;
        }

        #main {
            width: 80%;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div id="main">
    <h2>更改头像</h2>
    <div>
        <h3>原头像：</h3>
        <img src="<?php
        if ($data['photo'] != ''){
            echo SUB_URL.$data['photo'];
        }else{
            echo "style/photo.jpg";
        }


        ?>"/>
    </div>
    <div style="margin:15px 0 0 0;">
        <form method="post" enctype="multipart/form-data">
            <input style="cursor:pointer;" width="100" name="photo" type="file"/><br/><br/>
            <input class="submit" type="submit" name="submit" value="上传"/>
        </form>
    </div>
</div>
</body>
</html>
