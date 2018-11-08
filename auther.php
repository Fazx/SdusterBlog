<?php
	session_start();
    if(!isset($_GET['autherid']) || !$_GET['autherid'] || !is_numeric($_GET['autherid'])){
        header("Location:index.php");
    }else{
        $_GET['autherid'] = intval($_GET['autherid']);
    }
    # 连接数据库
                        if(!(isset($mysqli) && $mysqli -> connect_errno)){
                                require './includes/connect.php';
                        }
                    # 判断作者是否存在
                    $sql_statement = "SELECT user_id FROM users WHERE user_id = '" . $_GET['autherid'] ."'" ;
                    $result = $mysqli -> prepare($sql_statement);
                    $result -> execute();
                    $result -> store_result();
                    if(!($result -> num_rows == 1)){
                        # 不存在则跳转首页 
                        $result -> close();
                        header("refresh:3;url=./index.php");
                        echo '该作者不存在！<br>三秒后自动跳转首页~~~';
                        die();
                    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>首页 - SdustBlog</title>

    <!-- meta -->
    <meta charset="UTF-8">
    <meta http-equiv="content-language" content="zh-CN" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="msvalidate.01" content="26321DE756A81E2A83BB30B252FB5A80" />
    <meta name="description" content="首页 - SdustBlog - Linux - 信息安全　- 计算机网络　- 计算机　">
    <link rel="shortcut icon" href="./images/favicon.ico">

    <!-- css -->
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/pace.css">
    <link rel="stylesheet" href="./css/custom.css">
    <link rel="stylesheet" href="./css/pagination.css">
    <!-- js -->
    <script src="./js/jquery-2.1.3.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/pace.min.js"></script>
    <script src="./js/modernizr.custom.js"></script>
    <script src="./js/script.js"></script>
 
</head>

<body>

<?php require './includes/header.php'; ?>
<div class="content-body">
    <div class="container">
        <div class="row">
            <main class="col-md-8">

            	<?php
            		# 如果是访客的话需要重新连接数据库
            		if(!(isset($mysqli) && $mysqli -> connect_errno)){
            			require './includes/connect.php';
            		}
            		# 数据库查询文章列表
            		$query = "SELECT user_id, user_name, article_id, article_title, article_post_datetime, article_category_id, category_name, article_excerpt, article_click FROM users, articles, categories WHERE user_id='".$_GET["autherid"]."' AND article_user_id=user_id AND article_category_id=category_id ORDER BY article_post_datetime DESC";
            		$result = $mysqli -> prepare($query);
            		$result -> execute();
            		$result -> bind_result($userid, $username, $articleid, $articletitle, $articlepostdatetime, $articlecategoryid, $categoryname, $articleexcerpt, $articleclick);
            		while($result -> fetch()){
            			$flag = 1; # 判断是否有文章，后续如果添加分页功能的话可去掉
                        require './includes/articleheader.php'; 
                        $articleexcerpt = strip_tags($articleexcerpt);
            			print<<<EOT
                    <div class="entry-content clearfix">
                        <p> $articleexcerpt &nbsp...</p>
                        <div class="read-more cl-effect-14">
                            <a href="./detail.php?articleid=$articleid" class="more-link"> 继续阅读 <span class="meta-nav">→</span></a>
                        </div>
                    </div>
                </article>
EOT;
            		}
            		$result -> close();
                    if(!isset($flag)){
                        echo '<div class="no-post"> 该用户暂时还没有发布文章</div>';
                    }
            	?>

  
            </main>
            <?php  require './includes/pageright.php'; ?>
            <!-- 页脚添加在这里-->

        </div>
    </div>
</div>
<?php  require './includes/mobile.php'; ?>
<script src="./js/script.js"></script>
</body>
</html>
