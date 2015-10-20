<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/9/8
 * Time: 23:22
 */
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$link=connect();
include_once 'inc/is_manage_login.inc.php';//验证管理员是否登录
if(isset($_POST['submit'])){
    foreach($_POST['sort'] as $key=>$val){
        if(!is_numeric($key)||!is_numeric($val)){
            skip('father_module.php','error','排序参数错误！');
        }
        $query[]="update sk_father_module set sort={$val} where id={$key}";
    }
    //print_r($query);exit();
    if(execute_multi($link,$query,$error)){
        skip('father_module.php','ok','排序修改成功！');
    }else{
        skip('father_module.php','ok',$error);
    }

}
$template['css']=array('style/public.css','style/father_module.css');
?>
<?php include 'inc/header.inc.php'?>
    <div id="main">
        <div class="title">父版块列表</div>
        <form method="post">
        <table class="list">
            <tr>
                <th>排序</th>
                <th>版块名称</th>
                <th>操作</th>
            </tr>
            <?php
            $query="select * from sk_father_module";
            $result=execute($link,$query);
            while ($data=mysqli_fetch_assoc($result)){//将结果集转化为以列名为key值为value的数组

                $url=urlencode("father_module_delete.php?id={$data['id']}");//编码确认传递id的删除页,将除-_之外的转为%加两位16进制
                $return_url=urlencode($_SERVER['REQUEST_URI']);//解码当前页地址
                $message="确认删除{$data['module_name']}吗?";
                $confirm="confirm.php?url={$url}&return_url={$return_url}&message={$message}";
                $html=<<<A
			<tr>
				<td><input class="sort" type="text" name="sort[{$data['id']}]" value="{$data['sort']}" /></td>
				<td>{$data['module_name']}[id:{$data['id']}]</td>
				<td><a href="#">[访问]</a>&nbsp;&nbsp;<a href="father_module_update.php?id={$data['id']}">[编辑]</a>&nbsp;&nbsp;<a href="$confirm">[删除]</a></td>
			</tr>
A;
                echo $html;
            }
            ?>
        </table>
        <input style="margin-top:20px;cursor:pointer;" class="btn" type="submit" name="submit" value="排序" />
        </form>
    </div>
<?php include 'inc/footer.inc.php'?>