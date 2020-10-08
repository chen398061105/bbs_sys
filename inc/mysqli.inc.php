<?php
//数据库连接
function content($host = HOST, $user = USER, $pwd = PWD, $database = DATABASE, $port = PORT)
{
    $link = mysqli_connect($host, $user, $pwd, $database, $port);
    if (mysqli_connect_error()) {
        exit(mysqli_connect_error());
    }
    mysqli_set_charset($link, 'utf8');
    return $link;
}

//执行一条sql语句，返回结果集或对象或则布尔
function execute($link, $query)
{
    $result = mysqli_query($link, $query);
    if (mysqli_errno($link)) {
        exit(mysqli_error($link));
    }
    return $result;

}

//执行一条sql语句，返回布尔
function execute_bool($link, $query)
{
    $bool = mysqli_query($link, $query);
    if (mysqli_errno($link)) {
        exit(mysqli_error($link));
    }
    return $bool;
}

//执行多sql语句
function execute_multi($link, $arr_sqls, &$error)
{
    $sqls = implode(';', $arr_sqls) . ';';
    if (mysqli_multi_query($link, $sqls)) {
        $data = array();
        $i = 0;//计数
        do {
            if ($result = mysqli_store_result($link)) {
                $data[$i] = mysqli_fetch_all($result);
                mysqli_free_result($result);
            } else {
                $data[$i] = null;
            }
            $i++;
            if (!mysqli_more_results($link)) break;
        } while (mysqli_next_result($link));
        if ($i == count($arr_sqls)) {
            return $data;
        } else {
            $error = "sql执行失败：<br/>&nbsp;数组下标为{$i}的语句{$arr_sqls[$i]}执行错误<br/>&nbsp;错误原因：" . mysqli_error($link);
        }

    } else {
        $error = '执行失败，请检查首条语句是否正确！<br/>错误原因：' . mysqli_error($link);
        return false;
    }
}

//获取记录数
function num($link, $sql_count)
{
    $result = execute($link, $sql_count);
    $count = mysqli_fetch_row($result);
    return $count[0];
}
//数据入库前转义字符
function  escape($link,$data){
    if (is_string($data)){
        return mysqli_real_escape_string($link,$data);
    }
    //数组
    if (is_array($data)){
        foreach ($data as $key=>$value){
            $data[$key]=escape($link,$value);
        }
    }
    return $data;
}
//关闭数据库 向函数传值的时候就是传变量本身， 对象传递时候 函数里面和外面都有效
//如果link是变量，不是对象 影响范围就在函数里面
function close($link){
    mysqli_close($link);
}
