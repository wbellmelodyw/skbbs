<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/9/8
 * Time: 23:23
 */
//数据库连接
function connect($host=DB_HOST,$db=DB_DATABASE,$user=DB_USER,$pass=DB_PASS,$port=DB_PORT)
{
    $link=@mysqli_connect($host,$user,$pass,$db,$port);
    if(mysqli_connect_errno()){//连接正确返回0，错误返回非0
        exit(mysqli_connect_error());
    }
    mysqli_set_charset($link,'utf8');
    return $link;
}

////执行一条SQL语句,返回结果集对象或者返回布尔值
function execute($link,$query){
    $result=mysqli_query($link,$query);
    if(mysqli_errno($link)){
        exit(mysqli_error($link));
    }
    return $result;
}
//执行一条SQL语句，只会返回布尔值
function execute_boolean($link,$query){
    $bool=mysqli_real_query($link,$query);
    if(mysqli_errno($link)){
        exit(mysqli_error($link));
    }
    return $bool;
}
//执行多条SQL语句
function execute_multi($link,$sql_arr,&$error){

    $sql=implode(';',$sql_arr).';'; //将数组以;为间隔组成String语句
    if(mysqli_multi_query($link,$sql)){
        $data=array();
        $i=0;
        do {
            if($result=mysqli_store_result($link)){//返回首个结果集的结果
                $data[$i]=mysqli_fetch_all($result); //将fetch_all存储在数组中
                mysqli_free_result($result); //释放当前结果集内存
            }else{
                $data[$i]=null; //结果集执行失败为null
            }
            $i++;
            if(!mysqli_more_results($link)) break; //如果没有结果集，退出当前循环
            }while(mysqli_next_result($link)); //指针指向下一个语句
        if($i==count($sql_arr)){
            return $data;
        }else{
            $error="sql语句执行失败：<br />&nbsp;数组下标为{$i}的语句:{$sql[$i]}执行错误<br />&nbsp;错误原因：".mysqli_error($link);
            return false;
        }
    }else{
        $error='执行失败！请检查首条语句是否正确！<br />可能的错误原因：'.mysqli_error($link);
        return false;
    }
}
//获取记录数
function num($link,$sql_count){
    $result=execute($link,$sql_count);
    $count=mysqli_fetch_row($result); //将结果集那一行按照数组返回 【0】开始
    return $count[0];
}

//数据入库之前进行转义，确保，数据能够顺利的入库
function escape($link,$data){
    if(is_string($data)){
        return mysqli_real_escape_string($link,$data);//对特殊符号进行转义

    }
    else if(is_array($data)){
        foreach($data as $key=>$val){
            $data[$key]=escape($link,$val);
        }
    }
    return $data;
}
//关闭数据库连接
function close($link){
    mysqli_close($link);
}
?>
