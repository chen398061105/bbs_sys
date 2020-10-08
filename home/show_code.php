<?php
session_start();
include_once '../inc/check_vcode.php';
$_SESSION['code'] = code();
