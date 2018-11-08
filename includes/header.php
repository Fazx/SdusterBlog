<div class="container">
    <header id="site-header">
        <div class="row">
            <div class="col-md-4 col-sm-5 col-xs-8">
                <div class="logo">
                    <h1><a href="./index.php"><b>Sduster's</b> Blog</a></h1>
                </div>
            </div><!-- col-md-4 -->
            <div class="col-md-8 col-sm-7 col-xs-4">
                <nav class="main-nav" role="navigation">
                    <div class="navbar-header">
                        <button type="button" id="trigger-overlay" class="navbar-toggle">
                            <span class="ion-navicon"></span>
                        </button>
                    </div>

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">

                        	<?php

                        		if(isset($_SESSION['isLogin']) && $_SESSION['isLogin'] === 1){
                        			echo '<li class="cl-effect-11"><a href="#" data-hover="'.$_SESSION['username'].'">'.$_SESSION['username'].'</a></li>';
                        			echo  '<li class="cl-effect-11"><a href="./mdeditor.php" data-hover="发表博客">发表博客</a></li>';
                        			echo '<li class="cl-effect-11"><a href="./auther.php?autherid='.$_SESSION['userid'].'" data-hover="管理博客">管理博客</a></li>';
                                                echo '<li class="cl-effect-11"><a href="./changepwd.php" data-hover="修改密码">修改密码</a></li>';
                                    if($_SESSION['usertype'] == 1){
                                        echo  '<li class="cl-effect-11"><a href="./manageuser.php" data-hover="管理用户">管理用户</a></li>';
                                    }
                        			echo '<li class="cl-effect-11"><a href="./logout.php" data-hover="注销">注销</a></li>';
                        		}else{
                        			echo '<li class="cl-effect-11">游客您好</li>';
                        			echo '<li class="cl-effect-11"><a href="./register.php" data-hover="注册">注册</a></li>';
                        			echo '<li class="cl-effect-11"><a href="./login.php" data-hover="登录">登录</a></li>';
                        		}
                        	?>

                        </ul>
                    </div><!-- /.navbar-collapse -->
                </nav>
                <div id="header-search-box">
                    <a id="search-menu" href="#"><span id="search-icon" class="ion-ios-search-strong"></span></a>
                    <div id="search-form" class="search-form">
                        <form role="search" method="get" id="searchform" action="./search.php">
                            <input type="search" name="q" placeholder="搜索" required>
                            <button type="submit"><span class="ion-ios-search-strong"></span></button>
                        </form>
                    </div>
                </div>
            </div><!-- col-md-8 -->
        </div>
    </header>
</div>
