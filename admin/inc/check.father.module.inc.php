<?php
//插入数据的验证,非空
if(empty($_POST['module_name']) ){
    skip('father.module.add.php','error','版块名不能为空！');
}
//长度，包括中文
if(mb_strlen($_POST['module_name'],'utf-8') > 50 ){
    skip('father.module.add.php','error','版块名长度太长！');
}

if(!is_numeric($_POST['sort']) ){
    skip('father.module.add.php','error','排序只能是数字！');
}
//重要，入库前转义,后续需要追加xss攻击 过滤功能 暂时只有sql内部过滤功能
$_POST = escape($link,$_POST);
//数据是否重复判断
switch ($flag){
    case 'add':
        $query = "select * from  bbs_father_module where module_name = '{$_POST['module_name']}'";
        break;
    case 'update';
        $query = "select * from  bbs_father_module where module_name = '{$_POST['module_name']}' and id != {$_GET['id']}";
        break;
    default:
        skip('father.module.php','error','flag参数错误！');
}
$result = execute($link,$query);
if(mysqli_num_rows($result)){
    skip('father.module.php','error','已经存在的板块名无法操作！');
}