<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/9/14
 * Time: 23:04
 */
function skip($url,$pic,$message){//3秒后跳转到URL页面
    $html=<<<A
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<meta http-equiv="refresh" content="3;URL={$url}" />
<title>正在跳转中</title>
<link rel="stylesheet" type="text/css" href="style/remind.css" />
</head>
<body>
<div class="notice"><span class="pic {$pic}"></span> {$message} <a href="{$url}">3秒后自动跳转中!</a></div>
</body>
</html>
A;
    echo $html;
    exit();
}
//验证前台用户是否登录
function is_login($link){
    if(isset($_COOKIE['sk']['name']) && isset($_COOKIE['sk']['pw'])){
        $query="select * from sk_member where name='{$_COOKIE['sk']['name']}' and sha1(pw)='{$_COOKIE['sk']['pw']}'";
        $result=execute($link,$query);
        if(mysqli_num_rows($result)==1){
            $data=mysqli_fetch_assoc($result);
            return $data['id'];
        }else{
            return false;
        }
    }else{
        return false;
    }
}
function check_user($member_id,$content_member_id,$is_manage_login){
    if($member_id==$content_member_id || $is_manage_login){
        return true;
    }else{
        return false;
    }
}
//验证后台管理员是否登录
function is_manage_login($link){
    if(isset($_SESSION['manage']['name']) && isset($_SESSION['manage']['pw'])){
        $query="select * from sk_manage where name='{$_SESSION['manage']['name']}' and sha1(pw)='{$_SESSION['manage']['pw']}'";
        $result=execute($link,$query);
        if(mysqli_num_rows($result)==1){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}
?>