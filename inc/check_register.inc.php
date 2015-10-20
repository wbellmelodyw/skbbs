<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/10/1
 * Time: 17:27
 */
if(empty($_POST['name'])){
    skip('register.php', 'error', '用户名不得为空！');
}
if(mb_strlen($_POST['name'])>32){
    skip('register.php', 'error', '用户名长度不要超过32个字符！');
}
if(mb_strlen($_POST['pw'])<6){
    skip('register.php', 'error','密码不得少于6位！');
}
if($_POST['pw']!=$_POST['confirm_pw']){
    skip('register.php', 'error','两次密码输入不一致！');
}
if(strtolower($_POST['vcode'])!=strtolower($_SESSION['vcode'])){
    skip('register.php', 'error','验证码输入错误！');
}
$_POST=escape($link,$_POST);
$query="select * from sk_member where name='{$_POST['name']}'";
$result=execute($link, $query);
if(mysqli_num_rows($result)){
    skip('register.php', 'error', '这个用户名已经被别人注册了！');
}
?>