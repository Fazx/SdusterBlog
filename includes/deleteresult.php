<?php
    session_start();
    if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] && isset($_GET['articleid']) && is_numeric($_GET['articleid'])){
    	# 如果未连接数据库，则连接数据
    	if(!(isset($mysqli) && $mysqli -> connect_errno)){
    		require './connect.php';
    	}
    	$sql_statement = "SELECT article_user_id FROM articles WHERE article_id='" . $_GET['articleid'] ."'";
		$result = $mysqli -> prepare($sql_statement);
		$result -> execute();
		$result -> bind_result($article_user_id);
		$result -> store_result();

		# 判断是否有待查询文章
		if($result -> num_rows == 1){
			while($result -> fetch()){
				$articleuserid = $article_user_id;
			}
			$result -> close();
			if($_SESSION["userid"] == $articleuserid || $_SESSION["usertype"] == 1){
				$sql_statement = "DELETE FROM articles WHERE article_id='" . $_GET['articleid'] ."'";
				$result = $mysqli -> prepare($sql_statement);
				$result -> execute();
				$result -> store_result();
				# 判断是否成功删除文章
				if($result -> affected_rows == 1){
					$result -> close();
					header("refresh:3;url=../index.php"); 
					echo '删除成功 <br>三秒后自动跳转首页~~~';
				}
				else{
					header("refresh:3;url=../index.php"); 
					echo '删除失败 <br>三秒后自动跳转首页~~~';
				}
			}
			else{
				header("refresh:3;url=../index.php"); 
				echo '删除失败，您没有权限 <br>三秒后自动跳转首页~~~';
			}
		}else{
			header("refresh:3;url=../index.php"); 
			echo '删除失败，文章不存在或您没有权限 <br>三秒后自动跳转首页~~~';
		}
	}else{
		header("refresh:3;url=../index.php"); 
		echo '删除失败，参数不足 <br>三秒后自动跳转首页~~~';

	}

?>

