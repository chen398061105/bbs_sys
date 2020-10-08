<?php

//插入数据的验证,非空
if(empty($_POST['module_name']) ){
    skip('son.module.add.php','error','版块名不能为空！');
}
//长度，包括中文
if(mb_strlen($_POST['module_name'],'utf-8') > 50 || mb_strlen($_POST['info'],'utf-8') > 255 ){
    skip('son.module.add.php','error','版块名长度太长！');
}

//长度，包括中文
if( mb_strlen($_POST['info'],'utf-8') > 255 ){
    skip('son.module.add.php','error','简介内容太长！');
}

if(!is_numeric($_POST['father_module_id']) || !is_numeric($_POST['sort'])){
    skip('son.module.add.php','error','内容错误！');
}
//数据是否存在判断
$query = "select * from  bbs_father_module where id = '{$_POST['father_module_id']}'";
$result = execute($link,$query);
if(mysqli_num_rows($result) == 0){
    skip('son.module.add.php','error','所属父版块不存在！');
}
//重要，入库前转义,后续需要追加xss攻击 过滤功能 暂时只有sql内部过滤功能
$_POST = escape($link,$_POST);

switch ($flag){
    case 'add':
        $query = "select * from  bbs_son_module where module_name = '{$_POST['module_name']}'";
        break;
    case 'update';
        $query = "select * from  bbs_son_module where module_name = '{$_POST['module_name']}' and id != {$_GET['id']}";
        break;
    default:
        skip('son.module.php','error','flag参数错误！');
}
$result = execute($link,$query);
if(mysqli_num_rows($result)){
    skip('son.module.add.php','error','已经存在的板块名无法操作！');
}