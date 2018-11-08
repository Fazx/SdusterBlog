<?php  
    session_start(); 
    if(!(isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == 1)){
      header("refresh:3;url=./login.php"); 
      echo '登录后才能修改密码 <br>三秒后自动跳转登录页面~~~';
      die();
    }
    #防注入函数
    function blacklist($id)
    {
    if(preg_match("/ |\*|\+|;|select|from|union|like|where|for|and|file|".urldecode('%09')."|".urldecode("%0a")."|".urldecode("%0b")."|".urldecode('%0c')."|".urldecode('%0d')."|".urldecode('%a0')."|".urldecode('%20')."/i", $id))
        return True;
    else
        return False;
    }
    if(isset($_POST['submit']) && $_POST['submit'] != '' && isset($_POST['oldpassword']) && $_POST['oldpassword'] != '' && isset($_POST['newpassword']) && $_POST['newpassword'] != '' && isset($_POST['assertpassword']) && $_POST['assertpassword'] != '' && $_POST['newpassword'] == $_POST['assertpassword']){

        # 验证数据库是否连接成功
        if(!(isset($mysqli) && $mysqli -> connect_errno)){
            require './includes/connect.php';
        }

        # 处理数据 防注入攻击
        $userid = $_SESSION['userid'];
        $oldpassword = $_POST['oldpassword'];
        $newpassword = $_POST['newpassword'];
        $assertpassword = $_POST['assertpassword'];

        #判断注入
        if(blacklist($oldpassword) || blacklist($newpassword) || blacklist($assertpassword)){
          echo "<script>alert('包含非法字符！')</script>";
          header('refresh:1;url=./changepwd.php');
          die();
        }


        $sql_statement = "SELECT user_name FROM users WHERE user_id = '" . $userid ."'" . "AND user_pass = '" . md5($oldpassword) ."' AND user_lock='0'";
        $result = $mysqli -> prepare($sql_statement);
        $result -> execute();
        $result -> store_result();
        # 判断返回结果
        if($result -> num_rows == 1){
          $result -> close();
          $sql_statement = "UPDATE users SET user_pass = md5('$newpassword') WHERE user_id = '$userid'";
          $result = $mysqli -> prepare($sql_statement);
          $result -> execute();
          $result -> close();
          header("refresh:3;url=./login.php"); 
          echo '</b>成功修改密码<br>三秒后自动跳转登录页面~~~';
          die();
        }else{
          header("refresh:3;url=./changepwd.php"); 
          echo '旧密码错误 <br>三秒后自动跳转修改密码页面~~~';
          $_POST['submit'] = '';
          die();
        }


    }
    if(isset($_POST['submit']) && $_POST['submit'] != '' && (!isset($_POST['oldpassword']) || $_POST['oldpassword'] == '')){
        echo '<font color="red">原密码是必填项</font><br>';
    }
    if(isset($_POST['submit']) && $_POST['submit'] != '' && (!isset($_POST['newpassword']) || $_POST['newpassword'] == '')){
        echo '<font color="red">新密码是必填项</font><br>';
    }
    if(isset($_POST['submit']) && $_POST['submit'] != '' && (!isset($_POST['assertpassword']) || $_POST['assertpassword'] == '')){
        echo '<font color="red">重复密码是必填项</font><br>';
    }
    if(isset($_POST['submit']) && $_POST['submit'] != '' && ($_POST['assertpassword'] != $_POST['newpassword'])){
        echo '<font color="red">两次密码输入不一致</font><br>';
    }

?> 

<!DOCTYPE html> 
<html> 
<head> 
<meta charset="UTF-8"> 
<title>修改密码 - <?php echo $_SESSION['username']; ?> </title> 
<style type="text/css"> 
  form{ 
    text-align: center; 
  } 
</style> 
</head> 
<body> 
  <form action="changepwd.php" method="post"> 
      旧密码<input type="password" name="oldpassword"><br> 新密码<input 
      type="password" name="newpassword"><br> 确认新密码<input 
      type="password" name="assertpassword" ><br> <input 
      type="submit" name="submit" value="修改密码"> 
  </form> 
</body> 
</html>
