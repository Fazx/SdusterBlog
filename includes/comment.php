<?php
    session_start();
    # 判断用户是否登录
    if(!(isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == 1)){
        header("Location:index.php");
        die();
    }

    # 到这里用户肯定登录了，则判断评论内容是否为空
    if(isset($_POST['submit']) && $_POST['submit'] != '' && isset($_POST['details']) && $_POST['details'] != '' && isset($_POST['articleid']) && is_numeric($_POST['articleid'])){

        # 验证数据库是否连接成功
        if(!(isset($mysqli) && $mysqli -> connect_errno)){
            require 'connect.php';
        }

        # 处理数据 防注入攻击
        $userid = $_SESSION['userid'];
        $articleid = $_POST['articleid'];
        $details = $_POST['details'];
        $details = htmlspecialchars(addslashes($details),ENT_QUOTES,'UTF-8');

        $sql_statement = "INSERT INTO comments (comment_user_id, comment_article_id, comment_details, comment_post_datetime ) VALUES ('$userid', '$articleid', '$details', now())";


        $result = $mysqli -> prepare($sql_statement);
        $result -> execute();
        $url = '../detail.php?articleid='.$_POST['articleid'];
        if($mysqli -> affected_rows == 1){
            $result ->close();
            header("refresh:3;url=$url"); 
            echo '评论成功<br>三秒后自动跳转~~~';
            die();
        }else{
            $result ->close();
            header("refresh:3;url=$url");
            echo '评论失败<br>三秒后自动跳转~~~';
            die();
        }

    }else{
        header("refresh:3;url=../index.php");
        echo '<font color="red">非法的操作</font><br>';
    }
    
?>

