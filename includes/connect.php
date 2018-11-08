<?php
	/**
		connect.php 作为数据库连接的公共文件
	*/
	$mysqli = new mysqli("localhost", "root", "root", "blog");
	$mysqli -> set_charset('utf8'); # 设定字符集
	if($mysqli -> connect_errno){
		die('连接失败：'.$mysqli -> connect_error);
	}
