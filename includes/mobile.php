<!-- Mobile Menu -->
<div class="overlay overlay-hugeinc">
    <button type="button" class="overlay-close"><span class="ion-ios-close-empty"></span></button>
    <nav>
        <ul>
            <li><a href="./index.php">首页</a></li>
            <?php
            if(isset($_SESSION['isLogin']) && $_SESSION['isLogin'] === 1){
            	echo '<li><a href="#">'.$_SESSION['username'].'</a></li>';
            	echo  '<li><a href="./addarticle.php">发表博客</a></li>';
            	echo '<li><a href="./managearticle.php">管理博客</a></li>';
            	echo '<li><a href="./logout.php">注销</a></li>';
            }else{
            	echo '<li>游客您好</li>';
            	echo '<li><a href="./register.php">注册</a></li>';
            	echo '<li"><a href="./login.php">登录</a></li>';
            }
            ?>
        </ul>
    </nav>
</div>