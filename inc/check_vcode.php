<?php
function code(){
    //验证码
    header('Content-type:image/jpeg;charset=utf-8');
    $width = 120;
    $height = 40;
    $image = imagecreatetruecolor($width, $height);
//随机背景色
    $colorBg = imagecolorallocate($image, rand(200, 255), rand(200, 255), rand(200, 255));
    $color = imagecolorallocate($image, rand(10, 255), rand(10, 255), rand(10, 255));
//填充
    imagefill($image, 0, 0, $colorBg);
//画矩形
    imagerectangle($image, 0, 0, $width - 1, $height - 1, $colorBg);
//生成背景图随机点点
    for ($i = 0; $i < 100; $i++) {
        imagesetpixel($image, rand(0, $width - 1), rand(0, $height - 1), $color);
    }
//生产乱线
    for ($i = 0; $i < 4; $i++) {
        imageline($image, rand(0, $width / 2), rand(0, $height), rand($width / 2, $width), rand(0, $height), $color);
    }
//生成验证码字符串 不推荐
//imagestring($image,5,0,0,'abcd',$color);
//推荐
    $path = 'C:\xampp\htdocs\bilibiliphp\01day\font\VeraSeBd.ttf';
    $str = randCode();

    imagettftext($image,16,rand(-5,5),rand(5,15),rand(20,30),$color,$path,$str);
//输出图片格式
    imagejpeg($image);
//释放内存
    imagedestroy($image);
    return $str;
}

//生成验证码字符串
function randCode(){
    $str = substr(md5(uniqid(microtime(true),true)),0,5);
    return $str;
}
//生成验证码字符串
function randomkeys($length){
    $output='';
    for ($a = 0; $a<$length; $a++) {
        $output .= chr(mt_rand(33, 126));    //生成php随机数
    }
    return $output;
}