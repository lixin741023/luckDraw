<?php
	
	$server_name="hdm386770475.my3w.com";	/*服务器名*/
	$server_user="hdm386770475";	/*服务器账户*/
	$server_pas="zzbfcd123";	/*服务器密码*/
	$data_name="hdm386770475_db";	/*数据库名*/

	$conn=mysql_connect($server_name,$server_user,$server_pas);	//链接到服务器
	mysql_select_db($data_name);	//选择数据库
	mysql_query("set names 'utf8'");	//向数据库提交编码格式

	$sql="UPDATE lx_user SET draw_number=1";
	mysql_query($sql,$conn);

	mysql_close($conn);
?>
