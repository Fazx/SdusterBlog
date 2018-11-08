<?php
    # 判断是否需要重新连接数据库
    if(!(isset($mysqli) && $mysqli -> connect_errno)){
        require 'connect.php';
    }

    # 页面左侧最新文章栏
    echo '<aside class="col-md-4">';
    echo '<div class="widget widget-recent-posts">';
    echo '<h3 class="widget-title">最新文章</h3>';
    echo '<ul>';

    $query = "SELECT article_id, article_title FROM articles ORDER BY article_post_datetime DESC LIMIT 5";
    $result = $mysqli -> prepare($query);
    $result -> execute();
    $result -> bind_result($articleid, $articletitle);
    while($result -> fetch()){
        $flag = 1; # 判断是否有文章，后续如果添加分页功能的话可去掉
        echo '<li>';
        echo '<a href="./detail.php?articleid='.$articleid.'">'.$articletitle.'</a>';
        echo '</li>';
    }
    if(!isset($flag)){
        echo '暂无文章';
    }
    $result -> close();

    echo '</ul>';
    echo '</div>';


    # 左侧分类栏
    echo '<div class="widget widget-category">';
    echo '<h3 class="widget-title">分类</h3>';
    echo '<ul>';

    $query = "SELECT category_id, category_name, COUNT(*) AS article_num FROM articles, categories WHERE article_category_id=category_id GROUP BY category_id";
    $result = $mysqli -> prepare($query);
    $result -> execute();
    $result -> bind_result($categoryid, $categoryname, $articlenum);
    while($result -> fetch()){
        $flag = 1; # 判断是否有分类
        echo '<li>';
        echo '<a href="./category.php?categoryid='.$categoryid.'">'.$categoryname;
        echo '<span class="post-count">( '.$articlenum.' )</span>';
        echo '</a>';
        echo '</li>';
    }
    if(!isset($flag)){
        echo '暂无分类';
    }
    $result -> close();


    echo '</ul>';
    echo '</div>';
    echo '</aside>';

?>
