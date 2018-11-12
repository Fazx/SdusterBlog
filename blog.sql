-- MySQL dump 10.13  Distrib 5.7.23, for Linux (x86_64)
--
-- Host: localhost    Database: blog
-- ------------------------------------------------------
-- Server version	5.7.23-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articles` (
  `article_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `article_user_id` int(10) unsigned NOT NULL,
  `article_title` varchar(50) NOT NULL,
  `article_details` text NOT NULL,
  `article_post_datetime` datetime NOT NULL,
  `article_modify_datetime` datetime NOT NULL,
  `article_category_id` int(10) unsigned NOT NULL,
  `article_excerpt` varchar(70) NOT NULL,
  `article_click` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`article_id`),
  KEY `article_user_id` (`article_user_id`),
  KEY `article_category_id` (`article_category_id`),
  CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`article_user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`article_category_id`) REFERENCES `categories` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articles`
--

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` VALUES (1,1,'&lt;script&gt;alert(0)&lt;/script&gt;','\r\n\r\n&lt;script&gt;alert(0)&lt;/script&gt;','2018-11-01 21:52:58','2018-11-01 21:52:58',1,'<script>alert(0)</script>',5),(2,1,'服务端LAMP环境配置、运行与维护','\r\n- Ubuntu 16.04 LTS\r\n- Apache2\r\n- Mysql\r\n- php7.0\r\n\r\n## Ubuntu(Linux运维)\r\n\r\n查看已建立的网络连接以及对应进程\r\n\r\n`netstat -antulp | grep EST`\r\n\r\n**iptables**封杀某个IP或者ip段，如：123.4.5.6\r\n\r\n    iptables -I INPUT -s 123.4.5.6 -j DROP\r\n    iptables -I INPUT -s 123.4.5.1/24 -j DROP\r\n\r\n\r\n`find / *.php -perm 4777`　 //查找777的权限的php文件 \r\n\r\n`awk -F: &#039;{if($3==0)print $1}&#039; /etc/passwd`　　//查看root权限的账号\r\n\r\n查看页面访问排名前十的IP\r\n\r\n`cat /var/log/apache2/access.log  | cut -f1 -d &quot; &quot; | sort | uniq -c | sort -k 1 -r | head -10`\r\n\r\n\r\n![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwofqkyfwzj21f3072t9q.jpg)\r\n\r\n查看页面访问排名前十的URL\r\n\r\n`cat /var/log/apache2/access.log  | cut -f4 -d &quot; &quot; | sort | uniq -c | sort -k 1 -r | head -10`\r\n\r\n**备份Web目录:**\r\n\r\n`tar -zcvf web.tar.gz /var/www/html/`\r\n\r\n\r\n## Mysql\r\n\r\n`sudo apt-get install mysql-server`\r\n\r\n**关闭Mysql外联:**\r\n\r\n```\r\nUPDATE mysql.user SET HOST = &quot;localhost&quot; WHERE USER = &quot;root&quot;;\r\nFLUSH PRIVILEGES;\r\n```\r\n\r\n\r\n**备份mysql数据库:**\r\n\r\n```\r\n	mysqldump -u 用户名 -p 密码 数据库名 &gt; back.sql　　//备份指定数据库\r\n	mysqldump --all-databases &gt; back.sql　　　　//备份所有数据库\r\n```\r\n	\r\n**还原mysql数据库:**\r\n\r\n`mysql -u 用户名 -p 密码 数据库名 &lt; back.sql`\r\n\r\n避免使用弱密码登录。\r\n\r\n## Apache2\r\n\r\n`sudo apt-get install apache2`\r\n\r\n**关闭列目录：**\r\n\r\n配置`/etc/apache2/apache2.conf`\r\n\r\n```\r\n&lt;Directory /var/www/&gt;\r\n	Options Indexes FollowSymLinks\r\n	AllowOverride None\r\n	Require all granted\r\n&lt;/Directory&gt;\r\n```\r\n\r\n去除`Indexes`即关闭列目录。\r\n\r\n**要善于用Apache日志(/var/log/apache2/error.log)解决网站报错、发现用户恶意行为。**\r\n\r\n如图有人在恶意扫描我们的Web目录：\r\n\r\n![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwofksl4bbj21d308478b.jpg)\r\n\r\n## php7\r\n\r\n`sudo apt-get install php7.0`\r\n\r\n安装php7 module进行解析\r\n\r\n`sudo apt-get install libapache2-mod-php7.0`\r\n','2018-11-01 22:08:42','2018-11-01 22:08:42',1,'包含了\r\n\r\nLAMP环境搭建，Linux运维，Mysql数据库安全与Apache服务器安全的相关内容。',5),(3,1,'数据库的设计与操作','# 数据库的设计\r\n\r\n## 数据库的建立\r\n\r\n\r\n`CREATE DATABASE IF NOT EXISTS blog DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;`# 设置字符集，避免乱码\r\n\r\n\r\n\r\n## 表的建立\r\n\r\n### 用户表\r\n\r\n```\r\nCREATE TABLE users(\r\n	user_id INT(10) UNSIGNED AUTO_INCREMENT,\r\n	user_name VARCHAR(50) NOT NULL UNIQUE,              # user_name 不能重复\r\n	user_pass VARCHAR(50) NOT NULL,\r\n	user_email VARCHAR(50) NOT NULL UNIQUE,\r\n	user_telno VARCHAR(20) UNIQUE,\r\n	user_sex ENUM(&#039;男&#039;,&#039;女&#039;)  DEFAULT &#039;男&#039;,\r\n	user_birthday DATE NOT NULL DEFAULT &#039;0000-01-01&#039;,\r\n	user_register_datetime DATETIME NOT NULL,\r\n	user_image_url VARCHAR(255) NOT NULL DEFAULT &#039;&#039;,    # 用户头像地址 只有注册成功后才能设置\r\n	user_description VARCHAR(255) NOT NULL DEFAULT &#039;&#039;,  # 用户自我描述\r\n	user_type TINYINT(3) NOT NULL DEFAULT &#039;0&#039;,          # 0 为普通用户，1 为管理员\r\n	user_lock TINYINT(3) NOT NULL DEFAULT &#039;0&#039;,          # 用户违规，则锁定\r\n	PRIMARY KEY (user_id),\r\n	INDEX users_namepass(user_name, user_pass, user_lock)            # 建立索引，加快搜索速度\r\n)ENGINE=InnoDB DEFAULT CHARSET=utf8 ;                   # 设置引擎和字符集\r\n```\r\n\r\n### 文章类别表 系统默认 用户不能设置\r\n\r\n```\r\nCREATE TABLE categories(\r\n	category_id INT(10) UNSIGNED AUTO_INCREMENT,\r\n	category_name VARCHAR(50) NOT NULL, \r\n	PRIMARY KEY (category_id)\r\n)ENGINE=InnoDB DEFAULT CHARSET=utf8 ;\r\n```\r\n\r\n### 文章表\r\n\r\n```\r\nCREATE TABLE articles(\r\n	article_id INT(10) UNSIGNED AUTO_INCREMENT,\r\n	article_user_id INT(10) UNSIGNED NOT NULL,\r\n	article_title VARCHAR(50) NOT NULL,\r\n	article_details TEXT NOT NULL,\r\n	article_post_datetime DATETIME NOT NULL,\r\n	article_modify_datetime DATETIME NOT NULL,\r\n	article_category_id INT(10) UNSIGNED NOT NULL,\r\n	article_excerpt VARCHAR(70) NOT NULL,\r\n	article_click INT(10) NOT NULL DEFAULT &#039;0&#039;,\r\n	PRIMARY KEY (article_id),\r\n	FOREIGN KEY (article_user_id) REFERENCES users(user_id), # 外键 \r\n	FOREIGN KEY (article_category_id) REFERENCES categories(category_id) # 外键\r\n)ENGINE=InnoDB DEFAULT CHARSET=utf8;\r\n```\r\n\r\n### 评论功能数据库设计\r\n\r\n```\r\nCREATE TABLE comments(\r\n    comment_id INT(10) UNSIGNED AUTO_INCREMENT,\r\n	comment_user_id INT(10) UNSIGNED NOT NULL,\r\n	comment_article_id INT(10) UNSIGNED NOT NULL,\r\n	comment_details TEXT NOT NULL,\r\n	comment_post_datetime DATETIME NOT NULL,\r\n	PRIMARY KEY (comment_id),\r\n	FOREIGN KEY (comment_user_id) REFERENCES users(user_id), # 外键 \r\n	FOREIGN KEY (comment_article_id) REFERENCES articles(article_id) # 外键\r\n)ENGINE=InnoDB DEFAULT CHARSET=utf8;\r\n```\r\n\r\n文章与评论是一对多的关系。\r\n\r\n## 表中的插入数据范例\r\n\r\n### 用户表中插入数据\r\n\r\n```\r\nINSERT INTO users (user_name, user_pass, user_email, user_regiter_datetime) VALUES (&#039;zzz&#039;, &#039;zzz&#039;, &#039;196413@qq.com&#039;, now());\r\n\r\nnow() =&gt; YYYY-MM-DD HH:MM:SS\r\n\r\n```\r\n\r\n### 向类别表中插入数据\r\n\r\n`INSERT INTO categories (category_name) VALUES (&#039;程序人生&#039;);`\r\n\r\n### 向文章表中插入数据\r\n\r\n```\r\nINSERT INTO articles (article_user_id, article_title, article_details, article_post_datetime, article_modify_datetime, article_category_id, article_excerpt) VALUES (&#039;1&#039;, &#039;test&#039;, &#039;this is a test&#039;, now(), now(), &#039;1&#039;, &#039;this is an excerpt&#039;);\r\n\r\nALTER TABLE articles ADD article_click INT(10) NOT NULL DEFAULT &#039;0&#039; AFTER article_excerpt; # 修改文章表，添加属性 浏览数目(在article_excerpt之后添加)\r\n```\r\n\r\n\r\n修改详情：\r\n\r\n1 只有 InnoDB 引擎支持外键限制，而 MyISMA 引擎不能支持外键限制，因此将三个表的引擎换为 `InnoDB(ALTER TABLE users ENGINE=innodb;)`\r\n2 由于外键要求两表中的类型必须一致，因此将 `article_category_id INT(10) UNSIGNED NOT NULL` 和 `article_user_id INT(10) UNSIGNED NOT NULL` 添加 UNSIGNED 限定\r\n\r\n# 数据库的连接\r\n\r\nconnect.php组件，代码复用：\r\n\r\n```\r\n$mysqli = new mysqli(&quot;localhost&quot;, &quot;root&quot;, &quot;root&quot;, &quot;blog&quot;);\r\n	$mysqli -&gt; set_charset(&#039;utf8&#039;); # 设定字符集\r\n	if($mysqli -&gt; connect_errno){\r\n		die(&#039;连接失败：&#039;.$mysqli -&gt; connect_error);\r\n```\r\n\r\n# 数据库的插入\r\n\r\n\r\n- 在注册页面中(./register.php)有用户表的插入，其插入命令为\r\n\r\n```\r\nINSERT INTO users (user_name, user_pass, user_email, user_register_datetime) VALUES (&#039;$username&#039;,md5(&#039;$password&#039;),&#039;$email&#039;, now())&quot;;\r\n		$sql = &quot;INSERT INTO users (user_name, user_pass, user_email)VALUES(?,?,?)\r\n```\r\n\r\n- 在文章发表页面(./mdeditor.php)的文章表的插入，其插入命令为 \r\n\r\n```\r\nINSERT INTO articles (article_user_id, article_title, article_details, article_category_id, article_post_datetime, article_modify_datetime,article_excerpt\r\n) VALUES (&#039;$userid&#039;,&#039;$articletitle&#039;,&#039;$articledetails&#039;, &#039;$articlecategoryid&#039;, now(), now(),&#039;$articleexcerpt&#039;)\r\n```\r\n\r\n- 类别表的插入，类别表只有超级管理员(网站所有者)才能插入，命令为 `INSERT INTO categories (category_name) VALUES (&#039;category_name&#039;);`\r\n\r\n# 数据库的查询\r\n\r\n查询命令是最多的，有：\r\n\r\n- 首页(./index.php) 中 文章粗略的查询命令，按时间倒序排序：\r\n\r\n`$query = &quot;SELECT user_id, user_name, article_id, article_title, article_post_datetime, article_category_id, category_name, article_excerpt, article_click FROM users, articles, categories WHERE article_user_id=user_id AND article_category_id=category_id ORDER BY article_post_datetime DESC&quot;;`\r\n\r\n- ./detail.php 中，文章详细的查询...\r\n\r\n- ./delete.php 中，按照 联合 session 中user_id的查询\r\n\r\n`$sql_statement = &quot;SELECT article_user_id, article_id, article_title, article_post_datetime, category_name, article_excerpt, article_click  FROM  articles, categories WHERE article_id=&#039;&quot; . $_GET[&#039;articleid&#039;] .&quot;&#039;&quot;. &quot; AND category_id=article_category_id&quot;;`\r\n\r\n- ./auther.php、./category.php 中按作者、类别的查询...\r\n\r\n- ./login.php 中的查询...\r\n\r\n- ./mdeditor.php 中，查询文章类别...\r\n\r\n- ./search.php 中，模糊查询命令:\r\n\r\n`$query = &quot;SELECT user_id, user_name, article_id, article_title, article_post_datetime, article_category_id, category_name, article_excerpt, article_click FROM users, articles, categories WHERE article_user_id=user_id AND article_category_id=category_id AND (article_title LIKE &#039;%$q%&#039; OR article_excerpt LIKE &#039;%$q%&#039; OR article_details LIKE &#039;%$q%&#039;) ORDER BY article_post_datetime DESC&quot;;`\r\n\r\n# 数据库的更新(修改)\r\n\r\n数据库更新有以下几部分：\r\n\r\n- 文章详情页中(./detail.php)中，文章点击数更新：\r\n\r\n`$sql_statement = &quot;UPDATE articles SET article_click=article_click+&#039;1&#039; WHERE article_id = &#039;&quot; . $_GET[&#039;articleid&#039;] .&quot;&#039;&quot;;`\r\n\r\n- 管理员封禁、解封用户页面(./includes/ban.php, ./includes/restore.php)中，user_lock 字段更新:\r\n\r\n`$sql_statement = &quot;UPDATE users SET user_lock=&#039;1&#039; WHERE user_id= &#039;&quot; . $_GET[&#039;userid&#039;] .&quot;&#039;&quot;;`\r\n\r\n`$sql_statement = &quot;UPDATE users SET user_lock=&#039;0&#039; WHERE user_id= &#039;&quot; . $_GET[&#039;userid&#039;] .&quot;&#039;&quot;;`\r\n\r\n\r\n# 数据库的删除\r\n\r\n./includes/deleteresult.php\r\n\r\n`$sql_statement = &quot;DELETE FROM articles WHERE article_id=&#039;&quot; . $_GET[&#039;articleid&#039;] .&quot;&#039;&quot;;`\r\n\r\n','2018-11-01 22:12:05','2018-11-01 22:12:05',6,'数据库的建立，表中的插入数据范例，数据库的增删改查。',6),(4,1,'权限管理、session相关','\r\n\r\n# 权限管理\r\n\r\n用户表在创建时区分了管理员和普通用户，区分了被封禁与未被封禁的用户：\r\n\r\n```\r\nuser_type TINYINT(3) NOT NULL DEFAULT &#039;0&#039;,  # 0 为普通用户，1 为管理员\r\nuser_lock TINYINT(3) NOT NULL DEFAULT &#039;0&#039;,  # 用户违规，则锁定\r\n```\r\n\r\n普通用户在登录状态下可以发表文章及删除自己发表的文章，管理员在登录状态下可以**删除任意文章**以及**封禁用户**。\r\n\r\n![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwswt1ekqsj20i10byt99.jpg)\r\n\r\n进行发表/删除文章/用户时始终先判断登录状态和当前权限:\r\n\r\n![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwsvp46zi3j210o0bkgna.jpg)\r\n\r\n![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwsvpnbn5vj20wj09ojsa.jpg)\r\n\r\n\r\n# session相关\r\n\r\n## session创建\r\n\r\nsession在login.php中创建，设置的变量有用户名、登录状态、用户类型和用户id。同时将验证码$vcode的值也写进了session中进行比对。\r\n\r\n```\r\n$_SESSION[&quot;username&quot;] = $_POST[&quot;username&quot;];\r\n$_SESSION[&quot;isLogin&quot;] = 1;\r\n$_SESSION[&quot;usertype&quot;] = $usertype;\r\n$_SESSION[&quot;userid&quot;] = $id;\r\n```\r\n\r\n## session回收\r\n\r\nsession在logout.php中进行销毁`session_destroy()`，因为`print_r($_COOKIE)`发现cookie中有session的相关信息，所以在注销时将cookie一并清理\r\n\r\n```\r\n&lt;?php \r\nsession_start();\r\n$_SESSION = array();\r\nif(isset($_COOKIE[session_name()])){\r\n    setcookie(session_name(),&#039;&#039;, time()-42000, &#039;/&#039;);\r\n}\r\nsession_destroy();\r\necho &#039;注销成功&#039;;\r\nheader(&#039;refresh:1;url=./index.php&#039;);\r\n```\r\n## session存放位置\r\n\r\n经过序列化后的session数据存放在`/var/lib/php/sessions`\r\n\r\n![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwriwsb189j20p206qt9h.jpg)\r\n\r\n','2018-11-01 22:14:22','2018-11-01 22:14:22',5,'权限管理：用户表在创建时区分了管理员和普通用户，区分了被封禁与未被封禁的用户。',10),(5,1,'安全维护','\r\n# 服务端运维安全\r\n\r\n包含了\r\n\r\n- Mysql关闭外联，备份与恢复，避免弱密码\r\n- Apache关闭列目录，关注Apache日志\r\n- Linux进程 端口占用 网络连接 iptables防火墙\r\n- Web目录备份\r\n\r\n以上见[《服务端LAMP环境配置、运行与维护》](http://47.101.56.247/detail.php?articleid=2)。\r\n\r\n\r\n# 代码安全\r\n\r\n主要防止SQL注入和XSS漏洞，防止了简单的越权漏洞，防止暴力破解攻击。**遵循一个原则：不相信用户的任何输入。**\r\n\r\n## 确认用户session防止越权\r\n\r\n大量使用了 `$_SESSION` 中数据，确定是否为管理员在进行操作，主要有 ./manageuser.php、 ./delete.php、 ./requires/ban.php、 ./requires/restore.php \r\n\r\n![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwqjy6mmioj211n0ditar.jpg)\r\n\r\n## 防SQL注入\r\n\r\n主要分为确认参数安全，大体分为查询时的安全和插入时的安全，提交参数主要分为两类：\r\n\r\n### 参数为 int 型\r\n\r\n主要出现在查看文章的URL处\r\n`http://47.101.56.247/detail.php?articleid=16` \r\n此时参数应该为int整形，所以没必要使用复杂的过滤，直接使用 `is_numeric()` 函数判断即可，如果数据不符合或未提交完成参数， PHP页面返回错误，不进行数据库的操作。\r\n\r\n	# 如果未带参数跳转则返回首页 \r\n	if(!isset($_GET[&#039;articleid&#039;]) || !$_GET[&#039;articleid&#039;] || !is_numeric($_GET[&#039;articleid&#039;])){\r\n		header(&quot;Location:index.php&quot;);\r\n	}\r\n\r\n\r\n### 参数为 字符串 型\r\n\r\n这里分为两种，注册、登录、修改密码时参数 和 文章内容参数的安全：\r\n\r\n**注册、登录、修改密码时参数**:\r\n- 去除空白符(`trim()`函数)；\r\n- 在登录和注册页增加SQL过滤函数：\r\n\r\n![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwqjnv09irj219708e3za.jpg)\r\n\r\n![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwqjvxzl7ij214r09umy6.jpg)\r\n\r\n- 最后使用 `htmlspecialchars(addslashes($yourworld),ENT_QUOTES,&#039;UTF-8&#039;)`处理后存入数据库；\r\n\r\n\r\n- 文章内容 和 搜索页面(search.php) 的参数处理 ，直接使用 `htmlspecialchars(addslashes($yourworld),ENT_QUOTES,&#039;UTF-8&#039;)` 参数进行处理。\r\n\r\n## 防止(一般姿势的)XSS攻击\r\n\r\n对尖括号&lt;&gt;使用`htmlspecialchars()`进行转义后存储。\r\n\r\n    $articletitle = htmlspecialchars(addslashes($articletitle),ENT_QUOTES,&#039;UTF-8&#039;);\r\n    $articledetails = htmlspecialchars(addslashes($articledetails),ENT_QUOTES,&#039;UTF-8&#039;);\r\n\r\n\r\n字符 | 替换后\r\n---|---\r\n&lt; (小于) | `&amp;lt;`\r\n/&gt; (大于) | `&amp;gt;`\r\n\r\n\r\n## 登录验证码\r\n\r\n小时候我一直以为，验证码是网络的另一端有人在肉眼比对，现在我明白不用了，因为它本来就是由我生成的：\r\n\r\n```\r\n$str = Array(); \r\n$string = &quot;ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789&quot;;\r\nfor($i = 0;$i &lt; 4;$i++){\r\n   $str[$i] = $string[rand(0,35)];\r\n   $vcode .= $str[$i];\r\n}\r\n```\r\n\r\n之后就是图像处理的部分了，这一部分剽窃了他人的成果。\r\n\r\n```\r\nif(isset($_POST[&#039;username&#039;]) &amp;&amp; isset($_POST[&#039;password&#039;]) &amp;&amp; isset($_POST[&#039;verify&#039;])){\r\n      if($_POST[&#039;verify&#039;] == $_SESSION[&#039;vcode&#039;]){\r\n```\r\n\r\n传递变量，校验即可。\r\n\r\n![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwp1nmcuk9j20ux0i6aao.jpg)\r\n\r\n\r\n## 防止弱口令登录\r\n\r\n在注册处添加一句正则判断：\r\n\r\n![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwp1q68bggj215d06p3zc.jpg)\r\n\r\n前端加placeholder提示用户，增强体验：\r\n\r\n![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwp1s9vps7j20rj0c8aa6.jpg)\r\n\r\n## 杜绝密码明文存储\r\n\r\n![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwqjkf5vd8j20rc0b0gmv.jpg)\r\n\r\n单次md5的加密现在已经很脆弱了，可以考虑加salt或其它加密算法。\r\n\r\n# 网站备份 \r\n\r\n利用Linux的例行性排程(`crontab`)定时备份数据库文件与网站:\r\n\r\n![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwswa3givij20dr08rglj.jpg)\r\n\r\n\r\n### .sh 脚本编写\r\n\r\n```\r\n#!/bin/bash\r\n# /backup/backupday.sh\r\n# =========================================================\r\n# 备份数据的目录\r\nbasedir=/backup/daily/\r\n# =========================================================\r\nPATH=/bin:/usr/bin:/sbin:/usr/sbin; export PATH\r\nexport LANG=C\r\nbasefile1=$basedir/mysql.$(date +%Y-%m-%d).tar.bz2\r\nbasefile2=$basedir/html.$(date +%Y-%m-%d).tar.bz2\r\n[ ! -d &quot;$basedir&quot; ] &amp;&amp; mkdir $basedir\r\n# 为了防止mysql读写错误(备份的时候有人写入数据库，备份前关闭服务)\r\nsystemctl stop mysql.service\r\nsystemctl stop apache2.service\r\n# 1. MysQL (数据库目录在 /var/lib/mysql)\r\ncd /var/lib\r\n tar -jpc -f $basefile1 mysql\r\n# 2. \r\ncd /var/www\r\n tar -jpc -f $basefile2 html\r\n# 恢复 \r\nsystemctl start mysql.service\r\nsystemctl start apache2.service\r\n```\r\n\r\n### 设置权限脚本权限\r\n\r\n`chmod 700 /backup/backupwk.sh`\r\n\r\n### 添加到例行性排程中 \r\n\r\n每天2:30 进行备份\r\n\r\n```\r\nvim /etc/crontab\r\n# 加入两行\r\n30 2 * * * root /backup/backupday.sh\r\n```\r\n','2018-11-01 22:16:46','2018-11-01 22:16:46',3,'包含了\r\nMysql关闭外联，备份与恢复，避免弱密码,Apache关闭列目录，关注Apache日志',8),(6,1,'线上调试、其他特性优化','\r\n## 返回HTTP错误状态码(5xx)\r\n\r\n5xx的HTTP状态码代表服务器错误，此时要学会利用**Apache日志**(/var/log/apache2/error.log)进行分析排错，这种情况大多是PHP语法错误:\r\n\r\n![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwoffw20o0j20qh07wmy6.jpg)\r\n\r\n## 网页显示错乱/不全\r\n\r\n大多情况下是css js HTML的 编写错误，如引用缺失等。使用F12**开发者工具**可以很清楚地定位到问题，或者查看源代码。\r\n\r\n## 一般排错\r\n\r\n类似于编程中的“**单步调试法**”，一步一步跟踪程序执行的流程，根据变量的值，找到错误的原因。在Web系统的调试过程中，将COOKIE、SESSION或各种变量用echo，print_r打印出来，确定值的变化进行排错。\r\n\r\n另：Session值存在`/var/lib/php/session`中，必要时可以直接查看session文件内容。\r\n\r\n\r\n---\r\n\r\n## 搜索引擎优化(SEO)\r\n\r\n进行**META标签优化**，在detail.php中添加\r\n\r\n`&lt;meta name=&quot;description&quot; content=&quot;&lt;?php echo $articleexcerpt; ?&gt;&quot;&gt;`\r\n\r\n## 代码复用\r\n\r\n为了减少冗余的代码，方便管理，/incluede下的header.php、articleheader.php、connect.php等“组件”都是一次写好多处使用。如connect.php负责与数据库的连接操作，写好这一个组件，之后与数据库连接时只需要添加\r\n\r\n`require &#039;./includes/connect.php&#039;;`\r\n\r\n即可；header.php中包含了Web页面顶部的LOGO、用户登入登出、搜索框的代码实现，在其它页面php中也仅需要包含过去。类似的，每个页面右侧显示的最新文章、文章分类依赖于pageright.php；页面移动端的显示效果依赖于mobile.php。\r\n\r\n![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwogygdgiej20yi022q34.jpg)\r\n\r\n## 美化(ico、移动端)\r\n\r\n- 网站图标：\r\n\r\n`&lt;link rel=&quot;shortcut icon&quot; href=&quot;./images/favicon.ico&quot;&gt;`\r\n\r\n- 添加了移动端模板，适配手机端页面，登录注册搜索等功能都隐藏在了弹出式的js中，便于使用。\r\n\r\n## 其他细节\r\n\r\n- 在detail.php和search.php对网页title进行设置:\r\n\r\n`&lt;title&gt;&lt;?p echo $key; ?&gt;&lt;/title&gt;`\r\n\r\n进行了优化，提升用户体验。\r\n\r\n- 顶部栏(header.php)、侧边栏(pageright.php)使用户能方便跳转页面\r\n\r\n![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwsx8wtcwpj20tg0a50t8.jpg)\r\n\r\n','2018-11-01 22:19:32','2018-11-01 22:19:32',2,'特性优化包括了搜索引擎优化(SEO)，移动端适配等；实现了代码复用',13),(7,1,'Sduster&#039;s Blog概览','整体展示：\r\n\r\n![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwsxc0cgfjj21400p0dih.jpg)\r\n\r\n服务端环境：LAMP\r\n\r\n&gt; [服务端LAMP环境配置、运行与维护](http://47.101.56.247/detail.php?articleid=2)\r\n\r\n![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwsvytril5j22ps0xcatl.jpg)\r\n\r\n开发环境：本地Ubuntu测试，线上部署调试,使用Xshell和Xftp操作阿里云服务器。\r\n\r\n不使用框架，底层编写，了解其中原理。\r\n\r\n思考数据库的设计，建立用户表、文章表、评论表。\r\n\r\n&gt; [数据库的设计与操作](http://47.101.56.247/detail.php?articleid=3)\r\n\r\n页面均存在顶部栏，侧边栏，组件化，代码复用。侧边栏显示文章分类和最新文章。\r\n\r\n&gt; [其他特性优化](http://47.101.56.247/detail.php?articleid=6)\r\n\r\n注册登录，发表博客，对接markdown编辑器：\r\n\r\n![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwsxjqpdjaj21020e7jt4.jpg)\r\n\r\n\r\n增加修改密码功能，评论功能。\r\n\r\n普通用户对自己文章可进行删除操作，管理员可删除任意文章或用户，管理员可对用户进行封禁操作，被封禁的用户将无法登录：\r\n\r\n![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwswt1ekqsj20i10byt99.jpg)\r\n\r\n&gt; [权限管理](http://47.101.56.247/detail.php?articleid=4)\r\n\r\n\r\n- 对显示内容防止**XSS攻击**；\r\n- 注册、登录、修改密码，文章id参数均进行了**SQL防注入**处理；\r\n- 注册要求密码复杂度，登录增加验证码，防止**暴力破解攻击**\r\n- 进行删除文章、管理用户操作时均判断登录状态、用户权限，杜绝**越权漏洞**。\r\n- 密码使用md5()加密存储，杜绝存放明文密码。\r\n\r\n&gt; [安全维护](http://47.101.56.247/detail.php?articleid=5)\r\n\r\n\r\n进行了网站美化，移动端优化，简单的搜索引擎优化(SEO)。\r\n\r\n&gt; [其他特性优化](http://47.101.56.247/detail.php?articleid=6)\r\n\r\n','2018-11-01 22:45:44','2018-11-01 22:45:44',4,'             ',43);
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'LinuxSduty'),(2,'程序人生'),(3,'Web'),(4,'算法设计与分析'),(5,'现代密码学'),(6,'数据库学习');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comment_user_id` int(10) unsigned NOT NULL,
  `comment_article_id` int(10) unsigned NOT NULL,
  `comment_details` text NOT NULL,
  `comment_post_datetime` datetime NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `comment_user_id` (`comment_user_id`),
  KEY `comment_article_id` (`comment_article_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`comment_user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`comment_article_id`) REFERENCES `articles` (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,1,7,'&lt;script&gt;alert(&#039;XSS!&#039;)&lt;/script&gt;','2018-11-02 08:44:18'),(2,1,7,'这里是评论功能23333333','2018-11-02 08:44:45'),(3,7,6,'that&#039;s good!','2018-11-02 11:59:05');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `user_pass` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_telno` varchar(20) DEFAULT NULL,
  `user_sex` enum('男','女') DEFAULT '男',
  `user_birthday` date NOT NULL DEFAULT '0000-01-01',
  `user_register_datetime` datetime NOT NULL,
  `user_image_url` varchar(255) NOT NULL DEFAULT '',
  `user_description` varchar(255) NOT NULL DEFAULT '',
  `user_type` tinyint(3) NOT NULL DEFAULT '0',
  `user_lock` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `user_email` (`user_email`),
  UNIQUE KEY `user_telno` (`user_telno`),
  KEY `users_namepass` (`user_name`,`user_pass`,`user_lock`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'sdust','****手工改了****','asdfasdf',NULL,'男','0000-01-01','2018-11-01 21:49:31','','',1,0),(2,'hacker001','c8837b23ff8aaa8a2dde915473ce0991','196413@qq.com',NULL,'男','0000-01-01','2018-11-01 21:58:51','','',0,1),(3,'hacker002','c8837b23ff8aaa8a2dde915473ce0991','19641@qq.com',NULL,'男','0000-01-01','2018-11-01 21:59:05','','',0,1),(4,'hacker003','c8837b23ff8aaa8a2dde915473ce0991','1964@qq.com',NULL,'男','0000-01-01','2018-11-01 21:59:15','','',0,1),(5,'user001','c8837b23ff8aaa8a2dde915473ce0991','196@qq.com',NULL,'男','0000-01-01','2018-11-01 21:59:36','','',0,0),(6,'user002','c8837b23ff8aaa8a2dde915473ce0991','16@qq.com',NULL,'男','0000-01-01','2018-11-01 21:59:46','','',0,0),(7,'test001','8323f15343239abb72885940220a4f3e','sdafsdfsd',NULL,'男','0000-01-01','2018-11-02 11:56:36','','',0,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-11-09 10:08:06
