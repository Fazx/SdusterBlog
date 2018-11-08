<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>删除文章</title>
    </head>
    <body>

<?php
    if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] == 1 && isset($_GET['articleid']) && is_numeric($_GET['articleid'])){
    	$sql_statement = "SELECT article_user_id, article_id, article_title, article_post_datetime, category_name, article_excerpt, article_click  FROM  articles, categories WHERE article_id='" . $_GET['articleid'] ."'". " AND category_id=article_category_id";
                if(!(isset($mysqli) && $mysqli->connect_errno)){
                      require './includes/connect.php';
                }
		$result = $mysqli -> prepare($sql_statement);
		$result -> execute();
		$result -> bind_result($article_user_id, $article_id, $article_title, $article_post_datetime, $category_name, $article_excerpt, $article_click);
		$result -> store_result();
		# 判断是否有待查询文章
		if($result -> num_rows == 1){
			while($result -> fetch()){
				$articleuserid = $article_user_id;
				$articleid = $article_id;
				$articletitle = $article_title;
				$articlepostdatetime = $article_post_datetime;
				$categoryname = $category_name;
				$articleexcerpt = $article_excerpt;
				$articleclick = $article_click;
			}
			if($_SESSION["userid"] == $articleuserid){
				echo '<table border="0" cellspacing="0" width="380"';
				echo '<tr><th>文章ID</th><th>文章标题</th><th>文章发表时间</th></tr>';
				echo '<tr align="center">';
				echo '<td>'.$articleid.'</td>';
				echo '<td>'.$articletitle.'</td>';
				echo '<td>'.$articlepostdatetime.'</td>';
				echo '</tr>';
                                echo '<a href="./includes/deleteresult.php?articleid='.$articleid.'">';
                                echo '<button>确认删除！</button>';
                                echo '</a>';
			}else if($_SESSION["userid"] != $articleuserid && $_SESSION["usertype"] == 1){
				echo "你正在以管理员身份进行删除操作，请谨慎处理";
				echo '<table border="0" cellspacing="0" width="380"';
				echo '<tr><th>文章作者ID</th><th>文章ID</th><th>文章标题</th><th>文章发表时间</th></tr>';
				echo '<tr align="center">';
				echo '<td>'.$_SESSION["username"].'</td>';
				echo '<td>'.$articleid.'</td>';
				echo '<td>'.$articletitle.'</td>';
				echo '<td>'.$articlepostdatetime.'</td>';
				echo '</tr>';
				echo '<a href="./includes/deleteresult.php?articleid='.$articleid.'">';
                                echo '<button>确认删除！</button>';
                                echo '</a>';
			}else{
				header("refresh:3;url=./index.php"); 
				echo '您没有权限！请注意您的行为！<br>三秒后自动跳转首页~~~';
			}
		}else{
			header("refresh:3;url=./index.php"); 
		    echo '该文章不存在！请注意您的行为！<br>三秒后自动跳转首页~~~';
		}
    }else{
    	header("refresh:3;url=./index.php"); 
		echo '您输入的参数不完整或不合法，请注意您的行为！ <br>三秒后自动跳转首页~~~';
    }
?>



       
    </body>
</html>
