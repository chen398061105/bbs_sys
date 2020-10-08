<?php
header("Content-type:text/html;charset:utf-8");
/**
 * @param $count 总页数
 * @param $page_size 每页显示数量
 * @param $num_btn 显示的页码按钮数目
 * @param $page 分页参数 ?page=1
 */
function page($count, $page_size, $num_btn = 10, $page = 'page')
{
    if (!isset($_GET[$page]) || !is_numeric($_GET[$page]) || $_GET[$page] < 1) {
        $_GET[$page] = 1;
    }
    if ($count == 0) {
        $data = array(
            "limit" => '',
            "html" => ''
        );
        return $data;
    }

    //总分页数
    $page_nums = ceil($count / $page_size);
    if ($_GET[$page] > $page_nums) {
        $_GET[$page] = $page_nums;
    }
    //limit部分,当前页-1 乘以每页显示数量($_GET[$page]-1)*$page_size
    $start = ($_GET[$page] - 1) * $page_size;
    $limit = "limit {$start},{$page_size}";

    //构造url
    $arr_url = parse_url($_SERVER['REQUEST_URI']);//url和参数分开
    $url_path = $arr_url['path'];
//    $url = '';
    if (isset($arr_url['query'])) {
        parse_str($arr_url['query'], $arr_query);
        unset($arr_query[$page]);
        if (empty($arr_query)) {
            $url = "{$url_path}?{$page}=";
        } else {
            $other = http_build_query($arr_query);
            $url = "{$url_path}?{$other}&{$page}=";
        }
    } else {
        $url = "{$url_path}?{$page}=";
    }

    $html = array();
    if ($num_btn >= $page_nums) {
        //显示所有页码按钮
        for ($i = 1; $i <= $page_nums; $i++) {
            if ($_GET[$page] == $i) {
                $html[$i] = "<span style='color: white'>{$i}</span>";//当前页
            } else {
                $html[$i] = "<a href='{$url}{$i}'>{$i}</a>";//其他页
            }
        }
    } else {
        //左边按钮数目
        $num_left = floor(($num_btn - 1) / 2);
        $start = $_GET[$page] - $num_left;
        $end = $start + ($num_btn - 1);
//        echo "结束页" . $end . "</br>";
        //左边页
        if ($start < 1) {
            $start = 1;
        }
        if ($end > $page_nums) {
            $start = $page_nums - ($num_btn - 1);
        }
        for ($i = 0; $i < $num_btn; $i++) {
            if ($_GET[$page] == $start) {
                $html[$i] = "<span style='color: white'>{$start}</span>";
            } else {
                $html[$i] = "<a href='{$url}{$start}'>{$start}</a>";//其他页
            }
            $start++;
        }
    }
    //省略号效果 按钮数目大与3时候
    //当第一个按钮不是1的时候就替换...1 最后一个按钮同理
    if (count($html) >= 3) {
//        reset($html);
////        $key_first = key($html);
//
//        end($html);
//        $key_end = key($html);

//        if ($key_first !=1 ){
//            array_shift($html);
//            array_unshift($html, "<a href='page.php?page=1'>1...</a>");
//        }
        if ($_GET[$page] > 4) {
            array_shift($html);
            array_unshift($html, "<a href='{$url}1'>1...</a>");
        }

//        if ($key_end != $page_nums ){
//            array_pop($html);
//            array_push($html, "<a href='page.php?page={$page_nums}'>...{$page_nums}</a>");
//        }
        if ($page_nums - $_GET[$page] > 3) {
            array_pop($html);
            array_push($html, "<a href='{$url}{$page_nums}'>...{$page_nums}</a>");
        }
    }
    if ($_GET[$page] != 1) {
        $prev = $_GET[$page] - 1;
        array_unshift($html, "<a href='{$url}{$prev}'>« 上一页</a>");
    }
    if ($_GET[$page] != $page_nums) {
        $next = $_GET[$page] + 1;
        array_push($html, "<a href='{$url}{$next}'>下一页 »</a>");
    }

    $html = implode(" ", $html);


    //返回html代码和页数
    $data = array(
        "limit" => $limit,
        "html" => $html
    );

//    echo($data['html']);
    return $data;
}

//$page = page(100, 10, 8, 'page');
