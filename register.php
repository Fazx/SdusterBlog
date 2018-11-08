<?php
    header('content-type:text/html;charset=utf-8');
	#包含connect文件
	require_once('./includes/connect.php');
	#防注入函数
  function blacklist($id)
  {
  if(preg_match("/ |\*|\+|;|,|=|select|from|or|is|union|like|where|for|and|file|`|".urldecode('%09')."|".urldecode("%0a")."|".urldecode("%0b")."|".urldecode('%0c')."|".urldecode('%0d')."|".urldecode('%a0')."|".urldecode('%20')."/i", $id))
      return True;
  else
      return False;
  }
	if(isset($_POST['submit']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])){
		
		$username = strtolower($_POST['username']);
		$email = $_POST['email'];
		$password = $_POST['password'];

    #判断注入
    if(blacklist($username) || blacklist($email) || blacklist($password)){
      echo "<script>alert('包含非法字符！')</script>";
      header('refresh:1;url=./register.php');
      die();
    }

		#正则校验
		if(!(strlen($password)>=6 && preg_match('/[0-9]/', $password) && preg_match('/[a-z]/', $password) && preg_match('/[A-Z]/', $password)))
		{
       echo "<script>alert('密码必须大于6位，包含大写字母，小写字母和数字')</script>";
       header('refresh:1;url=./register.php');
       die();
		}

    # 查询用户是否存在
    $sql_before = "SELECT user_name FROM users WHERE user_name = '$username'";
    $result = $mysqli -> prepare($sql_before);
    $result -> execute();
    $result -> store_result();
    # 判断返回结果
    if($result -> num_rows == 1){
      echo "<script>alert('用户名已存在！')</script>";
      header('refresh:1;url=./register.php');
      die();
    }

		#设置时间和时区
		date_default_timezone_set('PRC');
		$time = time();


    $sql_statement = "INSERT INTO users (user_name, user_pass, user_email, user_register_datetime) VALUES ('$username',md5('$password'),'$email', now())";
    $result = $mysqli -> prepare($sql_statement);
    $result -> execute();
    if($mysqli -> affected_rows == 1){
        echo '注册成功，正在加载，请稍等...<br>三秒后自动跳转~~~';
        header('refresh:3;url=./index.php');
        die();
    }else{
        echo '注册失败，正在加载，请稍等...<br>三秒后自动跳转~~~';
        header('refresh:3;url=./register.php');
        die();
      }

/*
		#数据库操作
		$mysqli -> set_charset('utf8'); # 设定字符集
		$sql = "INSERT INTO users (user_name, user_pass, user_email)VALUES(?,?,?)";
		$stmt = $mysqli->prepare($sql);
		$stmt->execute(array($username,$email,md5($password)));

		if($mysqli->query($sql) === True){
			echo "注册成功！";
			exit('<meta http-equiv="refresh" content="3;url=login.php"/>');
		}
		else{
			echo '注册失败。';
		}
    */
  }
?>

<!DOCTYPE html>
<html>
<head lang="en">
  <meta charset="UTF-8">
  <title>注册</title>
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
    <h2>注册</h2>
    <p style='text-align:center;color:#1C86EE;font-size:20px;'>

</p>
    <form method="post" class="am-form">
      <label for="uname">用户名:</label>
      <input type="text" name="username" id="username" value="">
      <br>
      <label for="uname">邮箱:</label>
      <input type="text" name="email" id="email" value="">
      <br>
      <label for="password">密码:</label>
      <input type="password" name="password" id="password" value="" placeholder="大于6位，包含大写字母，小写字母和数字" >

      <br />
      <div class="am-cf">
        <input type="submit" name="submit" value="注 册" class="am-btn am-btn-primary am-btn-sm am-fl">

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
