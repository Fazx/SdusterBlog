<?php
    session_start();
    if(isset($_GET['userid']) && is_numeric($_GET['userid']) && isset($_SESSION["isLogin"]) && isset($_SESSION["usertype"]) && $_SESSION["usertype"] == 1){
    	# 如果未连接数据库，则连接数据
    	if(!(isset($mysqli) && $mysqli -> connect_errno)){
    		require 'connect.php';
    	}

    	# 查询用户
    	$sql_statement = "SELECT user_name FROM users WHERE user_type='0' AND user_lock='0' AND user_id='" . $_GET['userid'] ."'";
		$result = $mysqli -> prepare($sql_statement);
		$result -> execute();
		$result -> bind_result($user_name);
		$result -> store_result();
		if($result -> num_rows == 1){
			while($result -> fetch()){
				$username = $user_name;
			}
			$result -> close();

			# 修改数据库
			 $sql_statement = "UPDATE users SET user_lock='1' WHERE user_id= '" . $_GET['userid'] ."'";
			 $result = $mysqli -> prepare($sql_statement);
			 $result -> execute();
			 $result -> close();
			 header("refresh:3;url=../manageuser.php"); 
			 echo '用户: <b>'.$username.'</b>成功被封禁<br>三秒后自动跳转管理页面~~~';
		}else{
			header("refresh:3;url=../manageuser.php"); 
			echo '该用户已被封禁或该用户不存在<br>三秒后自动跳转管理页面~~~';
		}
    }else{
    	header("refresh:3;url=../index.php"); 
		echo '您不是管理员或者您未登录或输入参数有误<br>三秒后自动跳转首页~~~';
    }
?>

