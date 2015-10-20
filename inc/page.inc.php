<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/10/7
 * Time: 21:05
 */
/*
调用：$page=page(100,10,9);
返回值：array('limit','html')
$count：帖子总数
$page_size：每页显示的帖子数
$num_btn：要展示的页码按钮数目
$page：分页的get参数，默认page
*/
function page($count,$page_size,$num_btn=10,$page='page'){
    if(!isset($_GET[$page]) || !is_numeric($_GET[$page]) || $_GET[$page]<1){
        $_GET[$page]=1;
    }
    if($count==0){//如果没有记录则直接返回空的字符串
        $data=array(
            'limit'=>'',
            'html'=>''
        );
        return $data;
    }

    //总页数
    $page_num_all=ceil($count/$page_size);//向上取整
    if($_GET[$page]>$page_num_all){
        $_GET[$page]=$page_num_all;
    }
    $start=($_GET[$page]-1)*$page_size;
    if($start<0)
    {
        $start=0;
    }
    $limit="limit {$start},{$page_size}";

    $current_url=$_SERVER['REQUEST_URI'];//获取当前url地址
    $arr_current=parse_url($current_url);//将当前url拆分到数组里面
    $current_path=$arr_current['path'];//将文件路径部分保存起来
    $url='';

    if(isset($arr_current['query'])){
        parse_str($arr_current['query'],$arr_query);
       // var_dump( $arr_query);
        unset($arr_query[$page]);
        if(empty($arr_query)){
            $url="{$current_path}?{$page}=";
        }else{
            $other=http_build_query($arr_query);
            $url="{$current_path}?{$other}&{$page}=";
        }
    }else{
        $url="{$current_path}?{$page}=";
    }
    $html=array();
    if($num_btn>=$page_num_all){//当显示按钮数大于所需显示的帖子页数，直接有多少页显示多少页就好
        //把所有的页码按钮全部显示
        for($i=1;$i<=$page_num_all;$i++){//这边的$page_num_all是限制循环次数以控制显示按钮数目的变量,$i是记录页码号
            if($_GET[$page]==$i){
                $html[$i]="<span>{$i}</span>";
            }else{
                $html[$i]="<a href='{$url}{$i}'>{$i}</a>";
            }
        }
    }else{//当帖子页数大于当前按钮个数的情况
        $num_left=floor(($num_btn-1)/2);//向下取整
        $start=$_GET[$page]-$num_left;
        $end=$start+($num_btn-1);
        if($start<1){
            $start=1;
        }
        if($end>$page_num_all){
            $start=$page_num_all-($num_btn-1);
        }
        for($i=0;$i<$num_btn;$i++){
            if($_GET[$page]==$start){
                $html[$start]="<span>{$start}</span>";
            }else{
                $html[$start]="<a href='{$url}{$start}'>{$start}</a>";
            }
            $start++;
        }
        //如果按钮数目大于等于3的时候做省略号效果
        if(count($html)>=3){
            reset($html);//指针指向数组头
            $key_first=key($html);//返回指针key值
            end($html);//指针指向数组尾
            $key_end=key($html);
            if($key_first!=1){
                array_shift($html);
                array_unshift($html,"<a href='{$url}=1'>1...</a>");
            }
            if($key_end!=$page_num_all){
                array_pop($html);
                array_push($html,"<a href='{$url}{$page_num_all}'>...{$page_num_all}</a>");
            }
        }
    }
    if($_GET[$page]!=1){
        $prev=$_GET[$page]-1;
        array_unshift($html,"<a href='{$url}{$prev}'>« 上一页</a>");
    }
    if($_GET[$page]!=$page_num_all){
        $next=$_GET[$page]+1;
        array_push($html,"<a href='{$url}{$next}'>下一页 »</a>");
    }
    $html=implode(' ',$html);//将数组组成' '分隔的字符串
    $data=array(
        'limit'=>$limit,
        'html'=>$html
    );
    return $data;
}
?>