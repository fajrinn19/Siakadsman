<?php
session_start();
$captcha_code = substr(strtoupper(md5(rand())), 0, 6);
$_SESSION['captcha_code'] = $captcha_code;
echo $captcha_code;
?>