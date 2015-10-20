<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/9/22
 * Time: 22:57
 */
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$template['title']='子版块修改页';
$template['css']=array('style/public.css');
$link=connect();
include_once 'inc/is_manage_login.inc.php';//验证管理员是否登录
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skip('son_module.php','error','id参数错误！');
}
$query="select * from sk_son_module where id={$_GET['id']}";
$result=execute($link,$query);
if(!mysqli_num_rows($result)){
    skip('son_module.php','error','这条子版块信息不存在！');
}
$data=mysqli_fetch_assoc($result);
if(isset($_POST['submit'])){
    //验证
    if(!is_numeric($_POST['father_module_id'])){
        skip("son_module_update.php?id={$_GET['id']}",'error','所属父版块不得为空！');
    }
    $query="select * from sk_father_module where id={$_POST['father_module_id']}";
    $result=execute($link,$query);
    if(mysqli_num_rows($result)==0){
        skip("son_module_update.php?id={$_GET['id']}",'error','所属父版块不存在！');
    }
    if(empty($_POST['module_name'])){
        skip("son_module_update.php?id={$_GET['id']}",'error','子版块名称不得为空！');
    }
    if(mb_strlen($_POST['module_name'])>66){
        skip("son_module_update.php?id={$_GET['id']}",'error','子版块名称不得多余66个字符！');
    }
    $_POST=escape($link,$_POST);
    $query="select * from sk_son_module where module_name='{$_POST['module_name']}' and id!={$_GET['id']}";
    $result=execute($link,$query);
    if(mysqli_num_rows($result)){
        skip("son_module_update.php?id={$_GET['id']}",'error','这个子版块已经有了！');
    }
    if(mb_strlen($_POST['info'])>255){
        skip("son_module_update.php?id={$_GET['id']}",'error','子版块简介不得多于255个字符！');
    }
    if(!is_numeric($_POST['sort'])){
        skip("son_module_update.php?id={$_GET['id']}",'error','排序只能是数字！');
    }
    $query="update sk_son_module set father_module_id={$_POST['father_module_id']},module_name='{$_POST['module_name']}',info='{$_POST['info']}',member_id={$_POST['member_id']},sort={$_POST['sort']} where id={$_GET['id']}";
    execute($link,$query);
    if(mysqli_affected_rows($link)==1){
        skip('son_module.php','ok','修改成功！');
    }else{
        skip("son_module_update.php?id={$_GET['id']}",'error','亲，没修改内容吧！');
    }
}
?>
<?php include 'inc/header.inc.php'?>
    <div id="main">
        <div class="title" style="margin-bottom:20px;">修改子版块 - <?php echo $data['module_name']?></div>
        <form method="post">
            <table class="au">
                <tr>
                    <td>所属父版块</td>
                    <td>
                        <select name="father_module_id">
                            <option value="0">======请选择一个父版块======</option>
                            <?php
                            $query="select * from sk_father_module";
                            $result_father=execute($link,$query);
                            while ($data_father=mysqli_fetch_assoc($result_father)){
                                if($data['father_module_id']==$data_father['id']){//当传递来的id等于父板块id就选当前父板块
                                    echo "<option selected='selected' value='{$data_father['id']}'>{$data_father['module_name']}</option>";
                                }else{
                                    echo "<option value='{$data_father['id']}'>{$data_father['module_name']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        必须选择一个所属的父版块
                    </td>
                </tr>
                <tr>
                    <td>版块名称</td>
                    <td><input name="module_name" value="<?php echo $data['module_name']?>" type="text" /></td>
                    <td>
                        版块名称不得为空，最大不得超过66个字符
                    </td>
                </tr>
                <tr>
                    <td>版块简介</td>
                    <td>
                        <textarea name="info"><?php echo $data['info']?></textarea>
                    </td>
                    <td>
                        简介不得多于255个字符
                    </td>
                </tr>
                <tr>
                    <td>版主</td>
                    <td>
                        <select name="member_id">
                            <option value="0">======请选择一个会员作为版主======</option>

                        </select>
                    </td>
                    <td>
                        你可以在这边选一个会员作为版主
                    </td>
                </tr>
                <tr>
                    <td>排序</td>
                    <td><input name="sort"  value="<?php echo $data['sort']?>" type="text" /></td>
                    <td>
                        填写一个数字即可
                    </td>
                </tr>
            </table>
            <input style="margin-top:20px;cursor:pointer;" class="btn" type="submit" name="submit" value="修改" />
        </form>
    </div>
<?php include 'inc/footer.inc.php'?>