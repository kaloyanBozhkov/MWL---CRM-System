<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$host = 'localhost'; 
$userid = 'SECRETUSERID';
$pass = 'SECRETPASSWORD';
$link = mysqli_connect($host, $userid, $pass) or die(mysqli_error($link));
mysqli_set_charset($link,'utf8');
mysqli_select_db($link,"svetkkjb_mwl") or die ("ERROR ".mysqli_error($link));
?>