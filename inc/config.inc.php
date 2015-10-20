<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/9/8
 * Time: 23:22
 */
//宏定义数据库设置
date_default_timezone_set('Asia/Shanghai');//设置时区
session_start();
define("DB_HOST",'localhost');
define("DB_DATABASE",'skbbs');
define("DB_USER",'root');
define("DB_PASS",'');
define("DB_PORT",'3306');
//项目（程序），在服务器上的绝对路径
define('SA_PATH',dirname(dirname(__FILE__)));
//项目在web根目录下面的位置（哪个目录里面）
define('SUB_URL',str_replace($_SERVER['DOCUMENT_ROOT'],'',str_replace('\\','/',SA_PATH)).'/');
if(!file_exists(SA_PATH.'/inc/install.lock')){
    header('Location:'.SUB_URL.'install.php');
}
?>