<?php

if (mb_strlen($_POST['content']) < 10 || mb_strlen($_POST['content']) > 300  ) {
    skip($_SERVER['REQUEST_URI'], 'error', '内容在10到300个字之间');
}
//$_POST['content'] = nl2br(htmlspecialchars($_POST['content']));



