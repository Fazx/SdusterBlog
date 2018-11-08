<?php
    session_start();
    if(!(isset($_SESSION["isLogin"]) && isset($_SESSION["usertype"]) && $_SESSION["usertype"] == 1)){
    	header("refresh:3;url=./index.php"); 
		echo '您不是管理员或者您未登录 <br>三秒后自动跳转首页~~~';
		die();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>管理用户</title>
    </head>
    <body>
<style type="text/css">
    .fr {
        float: right;
        display: inline;
    }

    .main {
        height: 95px;
    }

    .content {
        width: 100%;
        background-color: #E0ECFF;
    }
</style>
<div class="content">
    <div class="fr">
        <h2 style="margin-right:10px">您好管理员</h2>
    </div>
    <div class="main">
        <h1> Sduster blog 管理系统 </h1>
    </div>
</div>


<?php
    if(isset($_SESSION["isLogin"]) && isset($_SESSION["usertype"]) && $_SESSION["usertype"] == 1){
    	# 如果未连接数据库，则连接数据
    	if(!(isset($mysqli) && $mysqli -> connect_errno)){
    		require './includes/connect.php';
    	}
    	# 查询被锁定用户数目
    	$sql_statement = "SELECT COUNT(*) AS lock_num FROM  users WHERE user_type='0' AND user_lock='1'";
		$result = $mysqli -> prepare($sql_statement);
		$result -> execute();
		$result -> bind_result($lock_num);
		$result -> store_result();
		while($result -> fetch()){
			$locknum = $lock_num;
		}
		$result -> close();
		# 查询未被锁定用户数目
		$sql_statement = "SELECT COUNT(*) AS notlock_num FROM  users WHERE user_type='0' AND user_lock='0'";
		$result = $mysqli -> prepare($sql_statement);
		$result -> execute();
		$result -> bind_result($notlock_num);
		$result -> store_result();
		while($result -> fetch()){
			$notlocknum = $notlock_num;
		}
		$result -> close();

		# 显示被锁定的用户 
		if(isset($locknum) && $locknum != 0){

			print<<<EOT
			<p>封禁用户数量为<b>$locknum</b></p>
			<table>
			    <thead>
			        <tr>
			            <td width="70" >用户ID</td>
			            <td width="90" >用户名</td>
			            <td width="40" >性别</td>
			            <td width="110" >注册时间</td>
			            <td width="85" >状态</td>
			            <td >操作</td>
			            </tr>	
			    </thead>
			    <tbody>
EOT;
			$sql_statement = "SELECT user_id, user_name, user_sex, user_register_datetime FROM  users WHERE user_type='0' AND user_lock='1'";
			$result = $mysqli -> prepare($sql_statement);
			$result -> execute();
			$result -> bind_result($user_id, $user_name, $user_sex, $user_register_datetime);
			$result -> store_result();
			while($result -> fetch()){
				echo '<tr>';
				echo '<td>'.$user_id.'</td>';
				echo '<td>'.$user_name.'</td>';
				echo '<td>'.$user_sex.'</td>';
				echo '<td>'.$user_register_datetime.'</td>';
				echo '<td>已封禁</td>';
				echo '<td>';
				echo '<a href="./includes/restore.php?userid='.$user_id.'">解除禁用</a>';
				echo '</td>';
				echo '</tr>';

			}
			echo '</tbody>';
			echo '</table>';
			$result -> close();

		}else{
			echo '<p>没有被封禁用户</p>';
		}


		# 显示未被封禁用户
    	print<<<EOT
			<p>正常用户数量为<b>$notlocknum</b></p>
			<table>
			    <thead>
			        <tr>
			            <td width="70" >用户ID</td>
			            <td width="90" >用户名</td>
			            <td width="40" >性别</td>
			            <td width="110" >注册时间</td>
			            <td width="85" >状态</td>
			            <td >操作</td>
			            </tr>	
			    </thead>
			    <tbody>
EOT;
			$sql_statement = "SELECT user_id, user_name, user_sex, user_register_datetime FROM  users WHERE user_type='0' AND user_lock='0'";
			$result = $mysqli -> prepare($sql_statement);
			$result -> execute();
			$result -> bind_result($user_id, $user_name, $user_sex, $user_register_datetime);
			$result -> store_result();
			while($result -> fetch()){
				echo '<tr>';
				echo '<td>'.$user_id.'</td>';
				echo '<td>'.$user_name.'</td>';
				echo '<td>'.$user_sex.'</td>';
				echo '<td>'.$user_register_datetime.'</td>';
				echo '<td>正常</td>';
				echo '<td>';
				echo '<a href="./includes/ban.php?userid='.$user_id.'">封禁用户</a>';
				echo '</td>';
				echo '</tr>';

			}
			echo '</tbody>';
			echo '</table>';
			$result -> close();
    }else{
    	header("refresh:3;url=./index.php"); 
		echo '您不是管理员或者您未登录 <br>三秒后自动跳转首页~~~';
		die();
    }
?>
       
    </body>
</html>

