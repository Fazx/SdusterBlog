<section class="comment-area" id="comment-area">
        <hr>
        <?php 
            if(isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == 1){
              print <<<EOF
        <h3>发表评论</h3>
        <form action="./includes/comment.php" method="post" class="comment-form">
          <div class="row">
            <div class="col-md-12">
              <label for="commentdetails"></label>
              <input type="text" name="details" id="commentdetails" />
              <input type="hidden" name="articleid" value="$articleid" />
              <button type="submit" name="submit" value="发表" class="comment-btn">发表</button>
            </div>
          </div>
        </form>
EOF;
            }else{
              echo '<h3>登录后发表评论</h3>';
            }
        ?>
        <div class="comment-list-panel">
            <h3>评论列表</h3>
            <ul class="comment-list list-unstyled">
              <?php

                  if(!(isset($mysqli) && $mysqli -> connect_errno)){
                    require './includes/connect.php';
                  }
                  # 数据库查询评论列表
                  $query = "SELECT comment_user_id, user_name, comment_details, comment_post_datetime FROM users, comments WHERE comment_user_id=user_id AND comment_article_id='$articleid' ORDER BY comment_post_datetime DESC";
                  $result = $mysqli -> prepare($query);
                  $result -> execute();
                  $result -> bind_result($commentuserid, $commentusername, $commentdetails, $commentpostdatetime);
                  while($result -> fetch()){
                    $flag = 1; # 判断是否有评论
                    print<<<EOF
                    <li class="comment-item">
                        <span class="nickname">$commentusername</span>
                        <time class="submit-date"
                              datetime="$commentpostdatetime">$commentpostdatetime</time>
                        <div class="text">
                            $commentdetails
                        </div>
                    </li>
EOF;
                  }
                  $result -> close();
                  if(!isset($flag)){
                    echo '暂无评论';
                  }
                ?>
            </ul>
        </div>
</section>

