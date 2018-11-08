![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwsxc0cgfjj21400p0dih.jpg)



本项目是Web安全课的课程设计项目，以php语言不依托任何后端框架开发的一个博客管理系统，环境为Ubuntu 16.04TLS + Apache2 + Mysql。实现了基本的博客功能：注册、登录、发表博客、评论、管理博客、封禁用户（管理员）；完善了安全防护措施：可防御SQL注入、XSS攻击、越权攻击、暴力破解；全站使用markdown 编辑器和解析器，主页显示文章分类、最新文章以及博文的预览，进行了简单的搜索引擎优化和移动端美化。

[Github地址](https://github.com/Fazx/SdusterBlog)

[线上演示地址(暂时开放)](http://47.101.56.247)

本项目与@zzzskd 共同开发，且其代码比重更大。

# 服务端LAMP环境配置、运行与维护

- Ubuntu 16.04 LTS
- Apache2
- Mysql
- php7.0

## Ubuntu(Linux运维)

查看已建立的网络连接以及对应进程

`netstat -antulp | grep EST`

**iptables**封杀某个IP或者ip段，如：123.4.5.6

    iptables -I INPUT -s 123.4.5.6 -j DROP
    iptables -I INPUT -s 123.4.5.1/24 -j DROP


`find / *.php -perm 4777`　 //查找777的权限的php文件 

`awk -F: '{if($3==0)print $1}' /etc/passwd`　　//查看root权限的账号

查看页面访问排名前十的IP

`cat /var/log/apache2/access.log  | cut -f1 -d " " | sort | uniq -c | sort -k 1 -r | head -10`


![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwofqkyfwzj21f3072t9q.jpg)

查看页面访问排名前十的URL

`cat /var/log/apache2/access.log  | cut -f4 -d " " | sort | uniq -c | sort -k 1 -r | head -10`

**备份Web目录:**

`tar -zcvf web.tar.gz /var/www/html/`


## Mysql

`sudo apt-get install mysql-server`

**关闭Mysql外联:**

```
UPDATE mysql.user SET HOST = "localhost" WHERE USER = "root";
FLUSH PRIVILEGES;
```


**备份mysql数据库:**

```
mysqldump -u 用户名 -p 密码 数据库名 > back.sql　　//备份指定数据库
mysqldump --all-databases > back.sql　　　　//备份所有数据库
```

**还原mysql数据库:**

`mysql -u 用户名 -p 密码 数据库名 < back.sql`

避免使用弱密码登录。

## Apache2

`sudo apt-get install apache2`

**关闭列目录：**

配置`/etc/apache2/apache2.conf`

```
<Directory /var/www/>
	Options Indexes FollowSymLinks
	AllowOverride None
	Require all granted
</Directory>
```

去除`Indexes`即关闭列目录。

**要善于用Apache日志(/var/log/apache2/error.log)解决网站报错、发现用户恶意行为。**

如图有人在恶意扫描我们的Web目录：

![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwofksl4bbj21d308478b.jpg)

## php7

`sudo apt-get install php7.0`

安装php7 module进行解析

`sudo apt-get install libapache2-mod-php7.0`



# 数据库的设计与操作



## 数据库的建立


`CREATE DATABASE IF NOT EXISTS blog DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;`# 设置字符集，避免乱码



## 表的建立

### 用户表

```
CREATE TABLE users(
	user_id INT(10) UNSIGNED AUTO_INCREMENT,
	user_name VARCHAR(50) NOT NULL UNIQUE,              # user_name 不能重复
	user_pass VARCHAR(50) NOT NULL,
	user_email VARCHAR(50) NOT NULL UNIQUE,
	user_telno VARCHAR(20) UNIQUE,
	user_sex ENUM('男','女')  DEFAULT '男',
	user_birthday DATE NOT NULL DEFAULT '0000-01-01',
	user_register_datetime DATETIME NOT NULL,
	user_image_url VARCHAR(255) NOT NULL DEFAULT '',    # 用户头像地址 只有注册成功后才能设置
	user_description VARCHAR(255) NOT NULL DEFAULT '',  # 用户自我描述
	user_type TINYINT(3) NOT NULL DEFAULT '0',          # 0 为普通用户，1 为管理员
	user_lock TINYINT(3) NOT NULL DEFAULT '0',          # 用户违规，则锁定
	PRIMARY KEY (user_id),
	INDEX users_namepass(user_name, user_pass, user_lock)            # 建立索引，加快搜索速度
)ENGINE=InnoDB DEFAULT CHARSET=utf8 ;                   # 设置引擎和字符集
```

### 文章类别表 系统默认 用户不能设置

```
CREATE TABLE categories(
	category_id INT(10) UNSIGNED AUTO_INCREMENT,
	category_name VARCHAR(50) NOT NULL, 
	PRIMARY KEY (category_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 ;
```

### 文章表

```
CREATE TABLE articles(
	article_id INT(10) UNSIGNED AUTO_INCREMENT,
	article_user_id INT(10) UNSIGNED NOT NULL,
	article_title VARCHAR(50) NOT NULL,
	article_details TEXT NOT NULL,
	article_post_datetime DATETIME NOT NULL,
	article_modify_datetime DATETIME NOT NULL,
	article_category_id INT(10) UNSIGNED NOT NULL,
	article_excerpt VARCHAR(70) NOT NULL,
	article_click INT(10) NOT NULL DEFAULT '0',
	PRIMARY KEY (article_id),
	FOREIGN KEY (article_user_id) REFERENCES users(user_id), # 外键 
	FOREIGN KEY (article_category_id) REFERENCES categories(category_id) # 外键
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

### 评论功能数据库设计

```
CREATE TABLE comments(
    comment_id INT(10) UNSIGNED AUTO_INCREMENT,
	comment_user_id INT(10) UNSIGNED NOT NULL,
	comment_article_id INT(10) UNSIGNED NOT NULL,
	comment_details TEXT NOT NULL,
	comment_post_datetime DATETIME NOT NULL,
	PRIMARY KEY (comment_id),
	FOREIGN KEY (comment_user_id) REFERENCES users(user_id), # 外键 
	FOREIGN KEY (comment_article_id) REFERENCES articles(article_id) # 外键
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

文章与评论是一对多的关系。

## 表中的插入数据范例

### 用户表中插入数据

```
INSERT INTO users (user_name, user_pass, user_email, user_regiter_datetime) VALUES ('zzz', 'zzz', '196413@qq.com', now());

now() => YYYY-MM-DD HH:MM:SS

```

### 向类别表中插入数据

`INSERT INTO categories (category_name) VALUES ('程序人生');`

### 向文章表中插入数据

```
INSERT INTO articles (article_user_id, article_title, article_details, article_post_datetime, article_modify_datetime, article_category_id, article_excerpt) VALUES ('1', 'test', 'this is a test', now(), now(), '1', 'this is an excerpt');

ALTER TABLE articles ADD article_click INT(10) NOT NULL DEFAULT '0' AFTER article_excerpt; # 修改文章表，添加属性 浏览数目(在article_excerpt之后添加)
```


修改详情：

1 只有 InnoDB 引擎支持外键限制，而 MyISMA 引擎不能支持外键限制，因此将三个表的引擎换为 `InnoDB(ALTER TABLE users ENGINE=innodb;)`
2 由于外键要求两表中的类型必须一致，因此将 `article_category_id INT(10) UNSIGNED NOT NULL` 和 `article_user_id INT(10) UNSIGNED NOT NULL` 添加 UNSIGNED 限定

## 数据库的连接

connect.php组件，代码复用：

```
$mysqli = new mysqli("localhost", "root", "root", "blog");
	$mysqli -> set_charset('utf8'); # 设定字符集
	if($mysqli -> connect_errno){
		die('连接失败：'.$mysqli -> connect_error);
```

## 数据库的插入


- 在注册页面中(./register.php)有用户表的插入，其插入命令为

```
INSERT INTO users (user_name, user_pass, user_email, user_register_datetime) VALUES ('$username',md5('$password'),'$email', now())";
		$sql = "INSERT INTO users (user_name, user_pass, user_email)VALUES(?,?,?)
```

- 在文章发表页面(./mdeditor.php)的文章表的插入，其插入命令为 

```
INSERT INTO articles (article_user_id, article_title, article_details, article_category_id, article_post_datetime, article_modify_datetime,article_excerpt
) VALUES ('$userid','$articletitle','$articledetails', '$articlecategoryid', now(), now(),'$articleexcerpt')
```

- 类别表的插入，类别表只有超级管理员(网站所有者)才能插入，命令为 `INSERT INTO categories (category_name) VALUES ('category_name');`

## 数据库的查询

查询命令是最多的，有：

- 首页(./index.php) 中 文章粗略的查询命令，按时间倒序排序：

`$query = "SELECT user_id, user_name, article_id, article_title, article_post_datetime, article_category_id, category_name, article_excerpt, article_click FROM users, articles, categories WHERE article_user_id=user_id AND article_category_id=category_id ORDER BY article_post_datetime DESC";`

- ./detail.php 中，文章详细的查询...

- ./delete.php 中，按照 联合 session 中user_id的查询

`$sql_statement = "SELECT article_user_id, article_id, article_title, article_post_datetime, category_name, article_excerpt, article_click  FROM  articles, categories WHERE article_id='" . $_GET['articleid'] ."'". " AND category_id=article_category_id";`

- ./auther.php、./category.php 中按作者、类别的查询...

- ./login.php 中的查询...

- ./mdeditor.php 中，查询文章类别...

- ./search.php 中，模糊查询命令:

`$query = "SELECT user_id, user_name, article_id, article_title, article_post_datetime, article_category_id, category_name, article_excerpt, article_click FROM users, articles, categories WHERE article_user_id=user_id AND article_category_id=category_id AND (article_title LIKE '%$q%' OR article_excerpt LIKE '%$q%' OR article_details LIKE '%$q%') ORDER BY article_post_datetime DESC";`

## 数据库的更新(修改)

数据库更新有以下几部分：

- 文章详情页中(./detail.php)中，文章点击数更新：

`$sql_statement = "UPDATE articles SET article_click=article_click+'1' WHERE article_id = '" . $_GET['articleid'] ."'";`

- 管理员封禁、解封用户页面(./includes/ban.php, ./includes/restore.php)中，user_lock 字段更新:

`$sql_statement = "UPDATE users SET user_lock='1' WHERE user_id= '" . $_GET['userid'] ."'";`

`$sql_statement = "UPDATE users SET user_lock='0' WHERE user_id= '" . $_GET['userid'] ."'";`

## 数据库的删除

./includes/deleteresult.php

`$sql_statement = "DELETE FROM articles WHERE article_id='" . $_GET['articleid'] ."'";`



# 服务端运维安全

包含了

- Mysql关闭外联，备份与恢复，避免弱密码
- Apache关闭列目录，关注Apache日志
- Linux进程 端口占用 网络连接 iptables防火墙
- Web目录备份

以上见[《服务端LAMP环境配置、运行与维护》](http://47.101.56.247/detail.php?articleid=2)。


# 代码安全

主要防止SQL注入和XSS漏洞，防止了简单的越权漏洞，防止暴力破解攻击。**遵循一个原则：不相信用户的任何输入。**

## 确认用户session防止越权

大量使用了 `$_SESSION` 中数据，确定是否为管理员在进行操作，主要有 ./manageuser.php、 ./delete.php、 ./requires/ban.php、 ./requires/restore.php 

![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwqjy6mmioj211n0ditar.jpg)

## 防SQL注入

主要分为确认参数安全，大体分为查询时的安全和插入时的安全，提交参数主要分为两类：

### 参数为 int 型

主要出现在查看文章的URL处
`http://47.101.56.247/detail.php?articleid=16` 
此时参数应该为int整形，所以没必要使用复杂的过滤，直接使用 `is_numeric()` 函数判断即可，如果数据不符合或未提交完成参数， PHP页面返回错误，不进行数据库的操作。

	# 如果未带参数跳转则返回首页 
	if(!isset($_GET['articleid']) || !$_GET['articleid'] || !is_numeric($_GET['articleid'])){
		header("Location:index.php");
	}


### 参数为 字符串 型

这里分为两种，注册、登录、修改密码时参数 和 文章内容参数的安全：

**注册、登录、修改密码时参数**:
- 去除空白符(`trim()`函数)；
- 在登录和注册页增加SQL过滤函数：

![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwqjnv09irj219708e3za.jpg)

![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwqjvxzl7ij214r09umy6.jpg)

- 最后使用 `htmlspecialchars(addslashes($yourworld),ENT_QUOTES,'UTF-8')`处理后存入数据库；


- 文章内容 和 搜索页面(search.php) 的参数处理 ，直接使用 `htmlspecialchars(addslashes($yourworld),ENT_QUOTES,'UTF-8')` 参数进行处理。


## 防止(一般姿势的)XSS攻击

对尖括号<>使用`htmlspecialchars()`进行转义后存储。




    $articletitle = htmlspecialchars(addslashes($articletitle),ENT_QUOTES,'UTF-8');
    $articledetails = htmlspecialchars(addslashes($articledetails),ENT_QUOTES,'UTF-8');



| 字符      | 替换后 |
| --------- | ------ |
| < (小于)  | `&lt;` |
| /> (大于) | `&gt;` |


效果验证：

![](http://ww1.sinaimg.cn/large/b12bdb25ly1fx117ehkefj20ny09iglu.jpg)

文章标题及详情处不存在XSS；

![](http://ww1.sinaimg.cn/large/b12bdb25ly1fx117vcul0j20mr07vglu.jpg)

评论处不存在XSS。


## 登录验证码

小时候我一直以为，验证码是网络的另一端有人在肉眼比对，现在我明白不用了，因为它本来就是由我生成的：

```
$str = Array(); 
$string = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
for($i = 0;$i < 4;$i++){
   $str[$i] = $string[rand(0,35)];
   $vcode .= $str[$i];
}
```

之后就是图像处理的部分了，这一部分剽窃了他人的成果。

```
if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['verify'])){
      if($_POST['verify'] == $_SESSION['vcode']){
```

传递变量，校验即可。

![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwp1nmcuk9j20ux0i6aao.jpg)


## 防止弱口令登录

在注册处添加一句正则判断：

![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwp1q68bggj215d06p3zc.jpg)

前端加placeholder提示用户，增强体验：

![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwp1s9vps7j20rj0c8aa6.jpg)

## 杜绝密码明文存储

![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwqjkf5vd8j20rc0b0gmv.jpg)

单次md5的加密现在已经比较脆弱了，可以考虑加salt或其它加密算法。

# 网站备份 

利用Linux的例行性排程(`crontab`)定时备份数据库文件与网站:

![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwswa3givij20dr08rglj.jpg)


### .sh 脚本编写

```
#!/bin/bash
# /backup/backupday.sh
# =========================================================
# 备份数据的目录
basedir=/backup/daily/
# =========================================================
PATH=/bin:/usr/bin:/sbin:/usr/sbin; export PATH
export LANG=C
basefile1=$basedir/mysql.$(date +%Y-%m-%d).tar.bz2
basefile2=$basedir/html.$(date +%Y-%m-%d).tar.bz2
[ ! -d "$basedir" ] && mkdir $basedir
# 为了防止mysql读写错误(备份的时候有人写入数据库，备份前关闭服务)
systemctl stop mysql.service
systemctl stop apache2.service
# 1. MysQL (数据库目录在 /var/lib/mysql)
cd /var/lib
 tar -jpc -f $basefile1 mysql
# 2. 
cd /var/www
 tar -jpc -f $basefile2 html
# 恢复 
systemctl start mysql.service
systemctl start apache2.service
```

### 设置权限脚本权限

`chmod 700 /backup/backupwk.sh`

### 添加到例行性排程中 

每天2:30 进行备份

```
vim /etc/crontab
# 加入两行
30 2 * * * root /backup/backupday.sh
```



# 权限管理

用户表在创建时区分了管理员和普通用户，区分了被封禁与未被封禁的用户：

```
user_type TINYINT(3) NOT NULL DEFAULT '0',  # 0 为普通用户，1 为管理员
user_lock TINYINT(3) NOT NULL DEFAULT '0',  # 用户违规，则锁定
```

普通用户在登录状态下可以发表文章及删除自己发表的文章，管理员在登录状态下可以**删除任意文章**以及**封禁用户**。

![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwswt1ekqsj20i10byt99.jpg)

进行发表/删除文章/用户时始终先判断登录状态和当前权限:

![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwsvp46zi3j210o0bkgna.jpg)

![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwsvpnbn5vj20wj09ojsa.jpg)


# session相关

## session创建

session在login.php中创建，设置的变量有用户名、登录状态、用户类型和用户id。同时将验证码$vcode的值也写进了session中进行比对。

```
$_SESSION["username"] = $_POST["username"];
$_SESSION["isLogin"] = 1;
$_SESSION["usertype"] = $usertype;
$_SESSION["userid"] = $id;
```

## session回收

session在logout.php中进行销毁`session_destroy()`，因为`print_r($_COOKIE)`发现cookie中有session的相关信息，所以在注销时将cookie一并清理

```
<?php 
session_start();
$_SESSION = array();
if(isset($_COOKIE[session_name()])){
    setcookie(session_name(),'', time()-42000, '/');
}
session_destroy();
echo '注销成功';
header('refresh:1;url=./index.php');
```
## session存放位置

经过序列化后的session数据存放在`/var/lib/php/sessions`

![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwriwsb189j20p206qt9h.jpg)



# 线上调试、其他特性优化

## 返回HTTP错误状态码(5xx)

5xx的HTTP状态码代表服务器错误，此时要学会利用**Apache日志**(/var/log/apache2/error.log)进行分析排错，这种情况大多是PHP语法错误:

![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwoffw20o0j20qh07wmy6.jpg)

## 网页显示错乱/不全

大多情况下是css js HTML的 编写错误，如引用缺失等。使用F12**开发者工具**可以很清楚地定位到问题，或者查看源代码。

## 一般排错

类似于编程中的“**单步调试法**”，一步一步跟踪程序执行的流程，根据变量的值，找到错误的原因。在Web系统的调试过程中，将COOKIE、SESSION或各种变量用echo，print_r打印出来，确定值的变化进行排错。

另：Session值存在`/var/lib/php/session`中，必要时可以直接查看session文件内容。

---

## 搜索引擎优化(SEO)

进行**META标签优化**，在detail.php中添加

`<meta name="description" content="<?php echo $articleexcerpt; ?>">`

## 代码复用

为了减少冗余的代码，方便管理，/incluede下的header.php、articleheader.php、connect.php等“组件”都是一次写好多处使用。如connect.php负责与数据库的连接操作，写好这一个组件，之后与数据库连接时只需要添加

`require './includes/connect.php';`

即可；header.php中包含了Web页面顶部的LOGO、用户登入登出、搜索框的代码实现，在其它页面php中也仅需要包含过去。类似的，每个页面右侧显示的最新文章、文章分类依赖于pageright.php；页面移动端的显示效果依赖于mobile.php。

![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwogygdgiej20yi022q34.jpg)

## 美化(ico、移动端)

- 网站图标：

`<link rel="shortcut icon" href="./images/favicon.ico">`

- 添加了移动端模板，适配手机端页面，登录注册搜索等功能都隐藏在了弹出式的js中，便于使用。

## 其他细节

- 在detail.php和search.php对网页title进行设置:

`<title><?p echo $key; ?></title>`

进行了优化，提升用户体验。

- 顶部栏(header.php)、侧边栏(pageright.php)使用户能方便跳转页面

![](http://ww1.sinaimg.cn/large/b12bdb25ly1fwsx8wtcwpj20tg0a50t8.jpg)

- 阅读数量显示，每点击一次阅读数+1

```
if($result -> num_rows == 1){
        # 文章存在则浏览数加一
        $result -> close();
        $sql_statement = "UPDATE articles SET article_click=article_click+'1' WHERE article_id = '" . $_GET['articleid'] ."'";
        $result = $mysqli -> prepare($sql_statement);
        $result -> execute();
        $result -> close();
    }
```

