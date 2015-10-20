<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/10/2
 * Time: 22:03
 */
$query="select * from sk_info where id=1";
$result_info=execute($link, $query);
$data_info=mysqli_fetch_assoc($result_info);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <title><?php echo $template['title'] ?></title>
    <meta name="keywords" content="<?php echo $data_info['keyword']?>" />
    <meta name="description" content="<?php echo $data_info['description']?>" />
    <?php
    foreach ($template['css'] as $val){
        echo "<link rel='stylesheet' type='text/css' href='{$val}' />";
    }
    ?>
</head>
<body>
<div class="header_wrap">
    <div id="header" class="auto">
        <div class="logo">skku</div>
        <div class="nav">
            <a href="index.php" class="hover">首页</a>
        </div>
        <div class="serarch">
            <form action="search.php" method="get">
                <input class="keyword" type="text" name="keyword" value="<?php if(isset($_GET['keyword']))echo $_GET['keyword']?>"  placeholder="搜索其实很简单" />
                <input class="submit" type="submit"  value="" />
            </form>
        </div>
        <div class="login">
            <?php
            if(isset($member_id) && $member_id){
                $str=<<<A
					<a href="member.php?id={$member_id}">您好！{$_COOKIE['sk']['name']}</a> <span style="color:#fff;">|</span> <a href="logout.php">退出</a>
A;
                echo $str;
            }else{
                $str=<<<A
					<a href="login.php">登录</a>&nbsp;
					<a href="register.php">注册</a>
A;
                echo $str;
            }
            ?>
        </div>
    </div>
</div>
<div style="margin-top:55px;"></div>