<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/10/1
 * Time: 17:25
 */
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
$member_id=is_login($link);
if($member_id){
    skip('index.php','error','你已经登录，请不要重复注册！');
}
if(isset($_POST['submit'])){
    include 'inc/check_register.inc.php';
    $query="insert into sk_member(name,pw,register_time) values('{$_POST['name']}',md5('{$_POST['pw']}'),now())";
    execute($link,$query);
    if(mysqli_affected_rows($link)==1){
        setcookie('sk[name]',$_POST['name']);
        setcookie('sk[pw]',sha1(md5($_POST['pw'])));
        skip('index.php','ok','注册成功！');
    }else{
        skip('register.php','eror','注册失败,请重试！');
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <title></title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link rel="stylesheet" type="text/css" href="style/public.css" />
    <link rel="stylesheet" type="text/css" href="style/register.css" />
</head>
<body>
<div class="header_wrap">
    <div id="header" class="auto">
        <div class="logo">sifangku</div>
        <div class="nav">
            <a class="hover">首页</a>
        </div>
        <div class="serarch">
            <form>
                <input class="keyword" type="text" name="keyword" placeholder="搜索其实很简单" />
                <input class="submit" type="submit" name="submit" value="" />
            </form>
        </div>
        <div class="login">
            <a>登录</a>&nbsp;
            <a>注册</a>
        </div>
    </div>
</div>
<div style="margin-top:55px;"></div>
<div id="register" class="auto">
    <h2>欢迎注册成为 sk会员</h2>
    <form method="post">
        <label>用户名：<input type="text" name="name"  /><span>*用户名不得为空，并且长度不得超过32个字符</span></label>
        <label>密码：<input type="password" name="pw"  /><span>*密码不得少于6位</span></label>
        <label>确认密码：<input type="password" name="confirm_pw"  /><span>*请输入与上面一致</span></label>
        <label>验证码：<input name="vcode" name="vocode" type="text"  /><span>*请输入下方验证码</span></label>
        <img class="vcode" src="show_code.php" />
        <div style="clear:both;"></div>
        <input class="btn" name="submit" type="submit" value="确定注册" />
    </form>
</div>
<div id="footer" class="auto">
    <div class="bottom">
        <a>私房库</a>
    </div>
    <div class="copyright">Powered by sifangku ©2015 sifangku.com</div>
</div>
</body>
</html>