<?php 
session_start();
$_SESSION = array();
if(isset($_COOKIE[session_name()])){
    setcookie(session_name(),'', time()-42000, '/');
}
session_destroy();
echo '注销成功';
header('refresh:1;url=./index.php');
