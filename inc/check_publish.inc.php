<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/10/4
 * Time: 21:22
 */
if(empty($_POST['module_id']) || !is_numeric($_POST['module_id'])){
    skip('publish.php', 'error', '所属版块id不合法！');
}
$query="select * from sk_son_module where id={$_POST['module_id']}";
$result=execute($link, $query);
if(mysqli_num_rows($result)!=1){
    skip('publish.php', 'error', '所属版块不存在！');
}
if(empty($_POST['title'])){
    skip('publish.php', 'error', '标题不得为空！');
}
if(mb_strlen($_POST['title'])>255){
    skip('publish.php', 'error', '标题不得超过255个字符！');
}
?>