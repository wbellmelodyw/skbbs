<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/10/1
 * Time: 20:39
 */
session_start();
include_once 'inc/vcode.inc.php';
$_SESSION['vcode']=vcode(100,40,30,4);
?>