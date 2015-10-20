<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/9/15
 * Time: 21:15
 */
//
/*var_dump($_SERVER);
$url=$_SERVER['SCRIPT_NAME'];
$url_arr=explode('/',$url);
print_r($url_arr);
$i=sizeof($url_arr);
echo $i;
echo "<br/>";
echo $url_arr[$i-1];   等于basename函数 返回当前页面根文件*/

include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
//var_dump($_POST);exit();
$link=connect();
include_once 'inc/is_manage_login.inc.php';//验证管理员是否登录
if(isset($_POST['submit'])){

    if(empty($_POST['module_name'])){
        skip('father_module_add.php','error','版块名称不得为空！');
    }
    if(mb_strlen($_POST['module_name'])>66){
        skip('father_module_add.php','error','版块名称不得多余66个字符！');//字节大于66strlen是字符
    }
    if(!is_numeric($_POST['sort'])){
        skip('father_module_add.php','error','排序只能是数字！');
    }
    $_POST=escape($link,$_POST);//将' "这些特殊符号进行转义
    $query="select * from sk_father_module where module_name='{$_POST['module_name']}'";
    $result=execute($link,$query);
    if(mysqli_num_rows($result)){//结果集有行数
        skip('father_module_add.php','error','这个版块已经有了！');
    }
    $query="insert into sk_father_module(module_name,sort) values('{$_POST['module_name']}',{$_POST['sort']})";
    execute($link,$query);
    if(mysqli_affected_rows($link)==1){
        skip('father_module.php','ok','恭喜你，添加成功！');
    }else{
        skip('faher_module_add.php','error','对不起，添加失败，请重试！');
    }
}
$template['title']='父版块添加页';
$template['css']=array('style/public.css','style/father_module_add.css');//在 include 'inc/header.inc.php之前
?>
<?php include 'inc/header.inc.php'?>
<div id="main">
    <div class="title" style="margin-bottom:20px;">添加父板块</div>
    <form method="post">
        <table class="au">
            <tr>
                <td>版块名称</td>
                <td><input name="module_name" type="text" /></td>
                <td>
                    版块名称不得为空，最大不得超过66个字符
                </td>
            </tr>
            <tr>
                <td>排序</td>
                <td><input name="sort" type="text" /></td>
                <td>
                    填写一个数字即可
                </td>
            </tr>
        </table>
        <input style="margin-top:20px;cursor:pointer;" class="btn" type="submit" name="submit" value="添加" />
    </form>
</div>
<?php include 'inc/footer.inc.php'?>