<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/9/10
 * Time: 22:55
 */
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$link=connect();
include_once 'inc/is_manage_login.inc.php';//验证管理员是否登录
if(!isset($_GET['id'])||!is_numeric($_GET['id'])){ //如果不存在id或者不是数字和字符串数字视为id无效
    skip('father_module.php','error','无效id');
}
$query="select * from sk_son_module where father_module_id={$_GET['id']}";
$result=execute($link,$query);
if(mysqli_num_rows($result)){
    skip('father_module.php','error','该父版块下面存在子版块，请先将对应的子版块先删掉！');
}
$query="delete from sk_father_module where id={$_GET['id']}";
execute($link,$query);
if(mysqli_affected_rows($link)==1){
    skip('father_module.php','ok','删除成功');
}else{
    skip('ffather_module.php','error','删除失败');
}
?>