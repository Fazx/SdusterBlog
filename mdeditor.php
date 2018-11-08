<?php
    session_start();
    # 判断用户是否登录
    if(!(isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == 1)){
        header("Location:login.php");
    }

    # 到这里用户肯定登录了，如果用户发表文章，则判断文章标题、文章内容是否为空
    if(isset($_POST['submit']) && $_POST['submit'] != '' && isset($_POST['articletitle']) && $_POST['articletitle'] != '' && isset($_POST['articledetails']) && $_POST['articledetails'] != ''&& isset($_POST['articlecategoryid']) && $_POST['articlecategoryid'] != ''){
        # 验证数据库是否连接成功
        if(!(isset($mysqli) && $mysqli -> connect_errno)){
            require './includes/connect.php';
        }
        # 处理数据 防注入攻击
        $userid = $_SESSION['userid'];
        $articletitle = $_POST['articletitle'];
        $articledetails = $_POST['articledetails'];
        $articletitle = htmlspecialchars(addslashes($articletitle),ENT_QUOTES,'UTF-8');
        $articledetails = htmlspecialchars(addslashes($articledetails),ENT_QUOTES,'UTF-8');
        $articlecategoryid = $_POST['articlecategoryid'];
        $articleexcerpt = $_POST['articleexcerpt'];

        $sql_statement = "INSERT INTO articles (article_user_id, article_title, article_details, article_category_id, article_post_datetime, article_modify_datetime,article_excerpt
) VALUES ('$userid','$articletitle','$articledetails', '$articlecategoryid', now(), now(),'$articleexcerpt')";


        $result = $mysqli -> prepare($sql_statement);
        $result -> execute();
        if($mysqli -> affected_rows == 1){
            $result ->close();
            header("refresh:3;url=./index.php"); 
            echo '发表成功<br>三秒后自动跳转~~~';
            die();
        }else{
            $result ->close();
            header("refresh:3;url=./index.php"); 
            echo '发表失败<br>三秒后自动跳转~~~';
            die();
        }

    }
    if(isset($_POST['submit']) && $_POST['submit'] != '' && (!isset($_POST['articletitle']) || $_POST['articletitle'] == '')){
        echo '<font color="red">文章标题是必填项</font><br>';
    }
    if(isset($_POST['submit']) && $_POST['submit'] != '' && (!isset($_POST['articledetails']) || $_POST['articledetails'] == '')){
        echo '<font color="red">文章内容是必填项</font><br>';
    }
    if(isset($_POST['submit']) && $_POST['submit'] != '' && (!isset($_POST['articlecategoryid']) || $_POST['articlecategoryid'] == '')){
        echo '<font color="red">文章类别是必填项</font><br>';
    }
    if(isset($_POST['submit']) && $_POST['submit'] != '' && (!isset($_POST['articleexcerpt']) || $_POST['articleexcerpt'] == '')){
        echo '<font color="red">文章摘要是必填项</font><br>';
    }


?>
<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8" />
        <title>写文章 - <?php echo $_SESSION['username'];?> </title>
        <link rel="stylesheet" href="./editormd/examples/css/style.css" />
        <link rel="stylesheet" href="./editormd/css/editormd.css" />
        <link rel="shortcut icon" href="./images/favicon.ico">
    </head>

    <body>

        <form action="mdeditor.php" method="post">
                <br>
                <br>
                <h2>文章名称：</h2><input type="text" name="articletitle" style="width:200px; height:40px;">
                <br>
                <br>
                  <select name="articlecategoryid">
                    <option value="">请选择文章的类别</option>
                    <?php
                        # 从数据中选择可选文章类别
                        if(!(isset($mysqli) && $mysqli -> connect_errno)){
                            require './includes/connect.php';
                        }

                        $query = "SELECT category_id, category_name FROM  categories";
                        $result = $mysqli -> prepare($query);
                        $result -> execute();
                        $result -> bind_result($categoryid, $categoryname);
                        while($result -> fetch()){
                            echo '<option value="'.$categoryid.'">'.$categoryname.'</option>';
                        }
                    ?>
                </select>
                <br>
                <br>
                <h2>文章摘要：</h2>
                <br>
                <textarea name="articleexcerpt" style="width:1135px; height:130px;"></textarea>
                <br>
                <input type="submit" name="submit" value="发表" style="width:90px; height:30px;">
        <div id="layout">
            <div id="editormd">
                <textarea style="display:none;" name="articledetails">


</textarea>
            </div>
        </div>

        </form>



        <script src="./editormd/examples/js/jquery.min.js"></script>
        <script src="./editormd/editormd.min.js"></script>
        <script type="text/javascript">
            var Editor;

            $(function() {
                Editor = editormd("editormd", {
                    width   : "90%",
                    height  : 640,
                    syncScrolling : "single",
                    path    : "./editormd/lib/"
                });
                
                /*
                // or
                testEditor = editormd({
                    id      : "test-editormd",
                    width   : "90%",
                    height  : 640,
                    path    : "../lib/"
                });
                */
            });
        </script>
    </body>
</html>