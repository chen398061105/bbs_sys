<?php
function upload($save_path, $file_size, $key_name, $type = array('jpg', 'jpeg', 'gif', 'png'))
{
    //获取配置文件的上传大小
    $phpini = ini_get("upload_max_filesize");//服务器默认最大值
    $phpini_unit = strtoupper(substr($phpini, -1));//M
    $phpini_num = substr($phpini, 0, -1);//数字
    $phpini_multiple = get_info($phpini_unit);
    $phpini_bytes = $phpini_multiple * $phpini_num;

    //获取上传文件的大小
    $upload_unit = strtoupper(substr($file_size, -1));//上传文件大小的单位
    $upload_num = substr($file_size, 0, -1);//数字
    $upload_multiple = get_info($upload_unit);
    $upload_bytes = $upload_multiple * $upload_num;

    //配置文件的大小和上传的大小对比
    if ($upload_bytes > $phpini_bytes) {
        $data['err'] = "上传文件大于{$phpini},请重新上传！";
        $data['return'] = false;
        return $data;
    }
    //上传文件各种状态值
    $msgs = array(
        1 => "上传文件超过配置文件指定值大小",
        2 => "上传文件超过表单指定值大小",
        3 => "部分上传成功",
        4 => "上传失败",
        6 => "找不到临时文件",
        7 => "文件写入失败"
    );
    if (!isset($_FILES[$key_name]['error'])) {
        $data['err'] = '原因不明导致，上传失败，请重试！';
        $data['return'] = false;
        return $data;
    }

//    所有失败的情况
    if ($_FILES[$key_name]['error'] != 0) {
        $data['err'] = $msgs[$_FILES[$key_name]['error']];
        $data['return'] = false;
        return $data;
    }
    //上传成功判断
    if ($_FILES[$key_name]['size'] > $upload_bytes) {
        $data['err'] = '上传文件大小超过设定大小，上传失败，请重试！';
        $data['return'] = false;
        return $data;
    }
    if (!is_uploaded_file($_FILES[$key_name]['tmp_name'])) {
        $data['err'] = '上传渠道有问题，上传失败，请重试！';
        $data['return'] = false;
        return $data;
    }
    //获取文件后缀名
    $arr_filename = (pathinfo($_FILES[$key_name]['name']));
    if (!isset($arr_filename['extension'])) {
        $arr_filename['extension'] = '';
    }
    if (!in_array($arr_filename['extension'], $type)) {
        $data['err'] = '上传文件后缀名必须是[' . implode(',', $type) . "]中的一个！";
        $data['return'] = false;
        return $data;
    }

    //判断是否存在文件目录
    if (!file_exists($save_path)) {
        //如果不存在则创建读写权限的可多级的目录
        if (!mkdir($save_path, 0777, true)) {
            $data['err'] = '文件保存目录创建失败，请检查权限！';
            $data['return'] = false;
            return $data;
        }
    }

    //移动文件，重命名
    $new_filename = date('YmdHis') . "_" . str_replace('.', '', uniqid(mt_rand(10000, 99999), true));

    if ($arr_filename['extension'] != '') {
        $new_filename .= "." . $arr_filename['extension'];
    }
    //保存
    $save_path = rtrim($save_path, '/') . '/';
    if (!move_uploaded_file($_FILES[$key_name]['tmp_name'], $save_path . $new_filename)) {
        $data['err'] = '临时文件保存失败，请检查权限';
        $data['return'] = false;
        return $data;
    }
    //保存路径，保存到数据时候用
    $data['save_path']=$save_path.$new_filename;
    $data['filename']=$new_filename;
    $data['return'] = true;
    return $data;
}

function get_info($unit)
{
    switch ($unit) {
        case "K":
            $multiple = 1024;
            return $multiple;
        case "M":
            $multiple = 1024 * 1024;
            return $multiple;
        case "G":
            $multiple = pow(1024, 3);
            return $multiple;
        default:
            return false;
    }
}

?>

