<?php

//if(file_exists('./install.lock')){
//	header("Location:index.php");
//}
header('Content-type:text/html;charset=utf-8');
if(isset($_POST['submit'])){
	include './check_install.inc.php';
	$query=array();
	$query['bbs_content']="
		CREATE TABLE IF NOT EXISTS `bbs_content` (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `module_id` int(10) unsigned NOT NULL,
		  `title` varchar(255) NOT NULL,
		  `content` text NOT NULL,
		  `time` datetime NOT NULL,
		  `member_id` int(10) unsigned NOT NULL,
		  `times` int(10) unsigned NOT NULL DEFAULT '0',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
	";
	$query['bbs_father_module']="
		CREATE TABLE IF NOT EXISTS `bbs_father_module` (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `module_name` varchar(66) NOT NULL,
		  `sort` int(11) DEFAULT '0',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='父版块信息表' AUTO_INCREMENT=1;	
	";
	$query['bbs_web_set']="
		CREATE TABLE IF NOT EXISTS `bbs_web_set` (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `title` varchar(255) NOT NULL,
		  `keyword` varchar(255) NOT NULL,
		  `description` varchar(255) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
	";
	$query['bbs_manage']="
		CREATE TABLE IF NOT EXISTS `bbs_manage` (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `name` varchar(32) NOT NULL,
		  `pwd` varchar(32) NOT NULL,
		  `create_time` datetime NOT NULL,
		  `level` tinyint(4) NOT NULL DEFAULT '1',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;		
	";
	$query['bbs_member']="
		CREATE TABLE IF NOT EXISTS `bbs_member` (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `name` varchar(32) NOT NULL,
		  `pwd` varchar(32) NOT NULL,
		  `photo` varchar(255) NOT NULL,
		  `register_time` datetime NOT NULL,
		  `last_time` datetime NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8;
	";
	$query['bbs_replay']="
		CREATE TABLE IF NOT EXISTS `bbs_replay` (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `content_id` int(10) unsigned NOT NULL,
		  `quote_id` int(10) unsigned NOT NULL DEFAULT '0',
		  `content` text NOT NULL,
		  `time` datetime NOT NULL,
		  `member_id` int(10) unsigned NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
	";
	$query['bbs_son_module']="
		CREATE TABLE IF NOT EXISTS `bbs_son_module` (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `father_module_id` int(10) unsigned NOT NULL,
		  `module_name` varchar(66) NOT NULL,
		  `info` varchar(255) NOT NULL,
		  `member_id` int(10) unsigned NOT NULL DEFAULT '0',
		  `sort` int(10) unsigned NOT NULL DEFAULT '0',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
	";
    $query['shop_list']="
		CREATE TABLE IF NOT EXISTS `shop_list` (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `name` varchar(32) NOT NULL,
		  `jan` varchar(15) NOT NULL,
		  `status` tinyint(4) unsigned NOT NULL DEFAULT '2',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
	";
	foreach ($query as $key=>$val){
		mysqli_query($link,$val);
		if(mysqli_errno($link)){
			echo "数据表 {$key} 创建失败，请检查数据库账户是否有创建表的权限！<a href='install.php'>点击返回</a>";
			exit();
		}
	}
	$query_info_s="select * from bbs_web_set where id=1";
	$result=mysqli_query($link, $query_info_s);
	if(mysqli_num_rows($result) !=1){
		$query_info_i="INSERT INTO `bbs_web_set` (`id`, `title`, `keyword`, `description`) VALUES(1, 'bbsbbs', '测试', '测试');";
		mysqli_query($link,$query_info_i);
		if(mysqli_errno($link)){
			exit("数据库bbs_web_set写入数据失败请检查相应权限!<a href='install.php'>点击返回</a>");
		}
	}
	$query_manage_s="select * from bbs_manage where name='admin'";
	$result=mysqli_query($link, $query_manage_s);
	if(mysqli_num_rows($result)!=1){
		$query_manage_i="INSERT INTO `bbs_manage` (`name`, `pwd`, `create_time`, `level`) VALUES('admin',md5('{$_POST['manage_pwd']}'),now(), 0)";
		mysqli_query($link,$query_manage_i);
		if(mysqli_errno($link)){
			exit("管理员创建失败，请检查数据表bbs_manage是否具有写权限!<a href='install.php'>点击返回</a>");
		}
	}

	$filename='./config.php';
	$str_file=file_get_contents($filename);

	//替换配置文件的数据库信息
	$pattern="/'HOST',.*?\)/";
	if(preg_match($pattern,$str_file)){
		$_POST['db_host']=addslashes($_POST['db_host']);
		$str_file=preg_replace($pattern,"'HOST','{$_POST['db_host']}')", $str_file);
	}
	$pattern="/'USER',.*?\)/";
	if(preg_match($pattern,$str_file)){
		$_POST['db_user']=addslashes($_POST['db_user']);
		$str_file=preg_replace($pattern,"'USER','{$_POST['db_user']}')", $str_file);
	}
	$pattern="/'PWD',.*?\)/";
	if(preg_match($pattern,$str_file)){
		$_POST['db_pwd']=addslashes($_POST['db_pwd']);
		$str_file=preg_replace($pattern,"'PWD','{$_POST['db_pwd']}')", $str_file);
	}
	$pattern="/'DATABASE',.*?\)/";
	if(preg_match($pattern,$str_file)){
		$_POST['db_database']=addslashes($_POST['db_database']);
		$str_file=preg_replace($pattern,"'DATABASE','{$_POST['db_database']}')", $str_file);
	}
	$pattern="/\('PORT',.*?\)/";
	if(preg_match($pattern,$str_file)){
		$_POST['db_port']=addslashes($_POST['db_port']);
		$str_file=preg_replace($pattern,"('PORT',{$_POST['db_port']})", $str_file);
	}
	var_dump($str_file);

	if(!file_put_contents($filename, $str_file)){
		exit("配置文件写入失败，请检查config.inc.php文件的权限!<a href='install.php'>点击返回</a>");
	}

	if(!file_put_contents('install.lock',':))')){
		exit('文件install.lock创建失败，但是您的系统其实已经安装了，您可以手动建立install.lock文件!');
	}
	echo "<div style='font-size:16px;color:green;'>:)) 恭喜您,安装成功! <a href='../home/index.php'>访问首页</a> | <a href='../admin/admin.login.php'>访问后台</a></div>";
	exit();
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title>欢迎使用 本引导安装程序</title>
<meta name="keywords" content="欢迎使用本引导安装程序" />
<meta name="description" content="欢迎使用本引导安装程序" />
<style type="text/css">
body {
	background:#f7f7f7;
	font-size:14px;
}
#main {
	width:560px;
	height:490px;
	background:#fff;
	border:1px solid #ddd;
	position:absolute;
	top:50%;
	left:50%;
	margin-left:-280px;
	margin-top:-280px;
}
#main .title {
	height: 48px;
	line-height: 48px;
	color:#333;
	font-size:16px;
	font-weight:bold;
	text-indent:30px;
	border-bottom:1px dashed #eee;
}
#main form {
	width:400px;
	margin:20px 0 0 10px;
}
#main form label {
	margin:10px 0 0 0;
	display:block;
	text-align:right;
}
#main form label input.text {
	width:200px;
	height:25px;
}

#main form label input.submit {
	width:204px;
	display:block;
	height:35px;
	cursor:pointer;
	float:right;
}
</style>
</head>
<body>
	<div id="main">
		<div class="title">欢迎使用 本引导安装程序</div>
		<form method="post">
			<label>数据库地址：<input class="text" type="text" name="db_host" value="localhost" /></label>
			<label>端口：<input class="text" type="text" name="db_port" value="3306" /></label>
			<label>数据库用户名：<input class="text" type="text" name="db_user" /></label>
			<label>数据库密码：<input class="text" type="password" name="db_pwd" /></label>
			<label>数据库名称：<input class="text" type="text" name="db_database" /></label>
			<br /><br />
			<label>后台管理员名称：<input class="text" type="text" name="manage_name" readonly="readonly" value="admin" /></label>
			<label>密码：<input class="text" type="password" name="manage_pwd" /></label>
			<label>密码确认：<input class="text" type="password" name="manage_pw_confirm" /></label>
			<label><input class="submit" type="submit" name="submit" value="确定安装" /></label>
		</form>
	</div>
</body>
</html>