<?php
  /** 
    file:login.php 提供用户登录表单和处理用户登录
  */
  session_start();
  # 包含连接数据库文件 
  require './includes/connect.php';
  #防注入函数
  function blacklist($id)
	{
	if(preg_match("/ |\*|\+|;|,|=|select|from|or|is|union|like|where|for|and|file|`|".urldecode('%09')."|".urldecode("%0a")."|".urldecode("%0b")."|".urldecode('%0c')."|".urldecode('%0d')."|".urldecode('%a0')."|".urldecode('%20')."/i", $id))
	    return True;
	else
	    return False;
	}
  # 判断是否提交表单
  if(isset($_POST['submit'])){
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['verify'])){
      if($_POST['verify'] == $_SESSION['vcode']){

        # 判断注入
        if(blacklist($_POST['username'])|| blacklist($_POST['password'])){
        echo "<script>alert('pissoff！')</script>";
        header('refresh:1;url=./login.php');
        die();
        }

        # 进行查询，查询之前需要对数据检查，后续添加
        $sql_statement = "SELECT user_name,user_pass FROM users WHERE user_name = '" . $_POST['username'] ."'" . "AND user_pass = '" . md5($_POST['password']) ."' AND user_lock='0'";
        $result = $mysqli -> prepare($sql_statement);
        $result -> execute();
        $result -> store_result();
        # 判断返回结果
        if($result -> num_rows == 1){
          $result -> close();

          # 判断是否为管理员，查询用户 id
          $query = "SELECT user_id, user_type FROM users WHERE user_name = '" . $_POST['username'] ."'";
          $result = $mysqli -> prepare($query);
          $result -> execute();
          $result -> bind_result($id, $type);
          while($result -> fetch()){
            $userid = $id;
            $usertype = $type;
          }
          $result -> close();
          
          # 给 _SESSION 赋值
          $_SESSION["username"] = $_POST["username"];
          $_SESSION["isLogin"] = 1;
          $_SESSION["usertype"] = $usertype;
          $_SESSION["userid"] = $id;
          header("Location:index.php");
        }else{
          $result ->close();
          #echo '<font color="red">用户名或密码或验证码错误</font>';
          echo "<script>alert('用户名或密码或验证码错误或用户已被封禁')</script>";
        }
      }else{
      #$str = $_SESSION['vcode'];
      echo "<script>alert('验证码错误')</script>";
    }
  }else{
    echo "<script>alert('用户名或密码或验证码是必填项')</script>";
  }
}
  # 只有登录失败才关闭数据库的连接，成功则不关闭
  $mysqli -> close();
?>


<!DOCTYPE html>
<html>
<head lang="en">
  <meta charset="UTF-8">
  <title>登录</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="format-detection" content="telephone=no">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="stylesheet" href="./css/style.css"/>
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
  <style>
    .header {
      text-align: center;
    }
    .header h1 {
      font-size: 200%;
      color: #333;
      margin-top: 30px;
    }
    .header p {
      font-size: 14px;
    }
  </style>
</head>
<!-- background="./images/login.jpg" style=" background-repeat:no-repeat ; background-size:100% 100%; background-attachment: fixed;" -->
<body>
<?php require './includes/header.php'; ?>
<div class="header">
  <div class="am-g">
    <h1>Sduster Blog 系统</h1>
  </div>
  <hr />
</div>
<div class="am-g">
  <div class="am-u-lg-6 am-u-md-8 am-u-sm-centered">
    <h2>登录</h2>
    <p style='text-align:center;color:#1C86EE;font-size:20px;'>

</p>
    <form action="login.php" method="post" class="am-form">
      <label for="uname">用户名:</label>
      <input type="text" name="username" id="username" value="">
      <br>
      <label for="password">密码:</label>
      <input type="password" name="password" id="password" value="" >
      <br>
      <label for="password">验证码(点击图片刷新):</label>
      <input type="text" name="verify" />
      <img  src="verify.php" id = "refresh" title="刷新验证码" align="absmiddle" onclick="document.getElementById('refresh').src='verify.php' ">

      <br/>
      <div class="am-cf">
        <input type="submit" name="submit" value="登 录" class="am-btn am-btn-primary am-btn-sm am-fl">

      </div>
    </form>
    <hr>
    <p>© Sduster Blog 系统</p>
  </div>
</div>
<?php  require './includes/mobile.php'; ?>
<script src="./js/script.js"></script>
</body>
</html>

<?php
/*

<html>
	<head>
	<title>Sduster Blog 系统登录</title>

	<!-- meta -->
	<meta charset="UTF-8">
    <meta http-equiv="content-language" content="zh-CN" />

    <!-- css -->
    <link rel="stylesheet" type="text/css" href="./css/login.css">

    </head>
    <body>
    	<div class="bd">
    		<p>欢迎光临Sduster Blog 系统，Session ID:<?php echo session_id(); ?> </p>
    		<form action="login.php" method="post">
    			用户名：<input type="text" name="username"><br>
    			密&nbsp;&nbsp;&nbsp;&nbsp;码：<input type="password" name="password"><br>
    			<input type="submit" name="submit" value="登录">
    		</form>
    	</div>
    </body>
</html>

*/
?>
