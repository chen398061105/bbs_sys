<?php
session_start();
header('Content-type:text/html;charset:utf-8');
define('HOST','localhost');
define('USER','root');
define('PWD','lp881208');
define('DATABASE','bbs');
define('PORT','3306');
//项目在服务器上的绝对路径
define('SERVER_PATH',dirname(dirname(__FILE__)));

//项目在web上的的绝对路径
define('SUB_URL',str_replace($_SERVER['DOCUMENT_ROOT'],'',str_replace('\\','/',SERVER_PATH)).'/home/');
