<?php
	session_start();
    
	# 如果未带参数跳转则返回首页 
	if(!isset($_GET['articleid']) || !$_GET['articleid'] || !is_numeric($_GET['articleid'])){
		header("Location:index.php");
	}

	# 为了SEO 优化，所以提前连接数据库，提取数据
	# 如果未连接数据库，则连接数据
	if(!(isset($mysqli) && $mysqli -> connect_errno)){
		require './includes/connect.php';
	}
            # 判断文章是否存在
    $sql_statement = "SELECT article_id FROM articles WHERE article_id = '" . $_GET['articleid'] ."'" ;
    $result = $mysqli -> prepare($sql_statement);
    $result -> execute();
    $result -> store_result();
    if($result -> num_rows == 1){
        # 文章存在则浏览数加一
        $result -> close();
        $sql_statement = "UPDATE articles SET article_click=article_click+'1' WHERE article_id = '" . $_GET['articleid'] ."'";
        $result = $mysqli -> prepare($sql_statement);
        $result -> execute();
        $result -> close();
    }else{
        # 不存在则跳转首页 
        $result -> close();
        header("refresh:3;url=./index.php"); 
        echo '该文章不存在！<br>三秒后自动跳转首页~~~';
        die();
    }

	$query = "SELECT user_id, user_name, article_id, article_title, article_post_datetime, article_category_id, category_name, article_excerpt, article_click, article_details FROM users, articles, categories WHERE article_id='".$_GET["articleid"]."' AND article_user_id=user_id AND article_category_id=category_id";
	$result = $mysqli -> prepare($query);
	$result -> execute();
	$result -> bind_result($user_id, $user_name, $article_id, $article_title, $article_post_datetime, $article_category_id, $category_name, $article_excerpt, $article_click, $article_details);
	while($result -> fetch()){
		$userid = $user_id;
		$username = $user_name;
		$articleid = $article_id;
		$articletitle = $article_title;
		$articlepostdatetime = $article_post_datetime;
		$articlecategoryid = $article_category_id;
		$categoryname = $category_name;
		$articleexcerpt = $article_excerpt;
		$articleclick = $article_click;
		$articledetails = $article_details;
	}
	$result ->close();

?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $articletitle; ?> - SdustBlog</title>

    <!-- meta -->
    <meta charset="UTF-8">
    <meta http-equiv="content-language" content="zh-CN" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="msvalidate.01" content="26321DE756A81E2A83BB30B252FB5A80" />
    <meta name="description" content="<?php echo $articleexcerpt; ?>">  
    <link rel="shortcut icon" href="./images/favicon.ico">
    <!-- css -->
   
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/custom.css">
    <!-- js -->
<script src="./js/jquery-2.1.3.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/modernizr.custom.js"></script>
    <script src="./js/script.js"></script>



    <link rel="stylesheet" href="./editormd/examples/css/style.css" />
    <link rel="stylesheet" href="./editormd/css/editormd.preview.css" />
    <link rel="shortcut icon" href="./images/favicon.ico">
    <style>            
        .editormd-html-preview {
            width: 90%;
            margin: 0 auto;
        }
    </style>
 
</head>

<body>

<?php require './includes/header.php'; ?>

<div class="content-body">
    <div class="container">
        <div class="row">
            <main class="col-md-8">

            	<?php
            		require './includes/articleheader.php';
                ?>
                <div id="editormd-view">
                    <textarea id="append" style="display:none;">  
<?php echo $articledetails; ?>                 
</textarea>          
                </div>
                <div class="widget-tag-cloud">
                    <ul>
                        <?php
                            if(isset($_SESSION["userid"]) && $_SESSION["userid"] == $userid || (isset($_SESSION["usertype"]) && $_SESSION["usertype"] == 1)){
                                echo '<li><a href="./delete.php?articleid='.$articleid.'">删除</a></li>';
                            }
                        ?>
                    </ul>
                </div>
                </article>
                <?php  require './includes/articletail.php'; ?>
  
            </main>
            <?php  require './includes/pageright.php'; ?>
            
        </div>
    </div>
</div>
        <script src="./editormd/examples/js/jquery.min.js"></script>
        <script src="./editormd/lib/marked.min.js"></script>
        <script src="./editormd/lib/prettify.min.js"></script>
        
        <script src="./editormd/lib/raphael.min.js"></script>
        <script src="./editormd/lib/underscore.min.js"></script>
        <script src="./editormd/lib/sequence-diagram.min.js"></script>
        <script src="./editormd/lib/flowchart.min.js"></script>
        <script src="./editormd/lib/jquery.flowchart.min.js"></script>

        <script src="./editormd/editormd.js"></script>
        <script type="text/javascript">
            $(function() {
                var EditormdView;
      
                EditormdView = editormd.markdownToHTML("editormd-view", {
                    htmlDecode      : "style,script,iframe",  // you can filter tags decode
                    emoji           : true,
                    taskList        : true,
                    tex             : true,  // 默认不解析
                    flowChart       : true,  // 默认不解析
                    sequenceDiagram : true,  // 默认不解析
                });
            });
        </script>
<?php  require './includes/mobile.php'; ?>
<script src="./js/script.js"></script>

</body>
</html>

