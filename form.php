<?php
	
	$phone=$_REQUEST["phone"];	/*接收从客户端传入的手机号*/

	$server_name="localhost";	/*服务器名*/
	$server_user="root";	/*服务器账户*/
	$server_pas="root";	/*服务器密码*/
	$data_name="luckdraw";	/*数据库名*/

	$conn=mysql_connect($server_name,$server_user,$server_pas);	//链接到服务器
	mysql_select_db($data_name);	//选择数据库
	mysql_query("set names 'utf8'");	//向数据库提交编码格式
	/***************************************************接收中奖用户表单信息*********************************************/		
	$phone_name=$_REQUEST["phone_name"];	//中奖用户姓名
	$phone_sex=$_REQUEST["phone_sex"];	//中奖用户性别
	$phone_province=$_REQUEST["phone_province"];	//中奖用户省份
	$phone_city=$_REQUEST["phone_city"];	//中奖用户城市
	$phone_address=$_REQUEST["phone_address"];	//中奖用户地址
	
	$sql="UPDATE lx_user set name='$phone_name' where phone=$phone";
	mysql_query($sql,$conn);

	$sql="UPDATE lx_user set sex='$phone_sex' where phone=$phone";
	mysql_query($sql,$conn);

	$address=$phone_province."".$phone_city."".$phone_address;
	$sql="UPDATE lx_user set home='$address' where phone=$phone";
	mysql_query($sql,$conn);

	mysql_close($conn);

	echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link href="disk/plugin/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" />
		<style>
			p{
				text-align: center;
			}
		</style>
	</head>
	<body style="max-width: 414px; margin: 0 auto;">
		<div style="text-align: center;">
			<img src="disk/img/success.jpg" />
		</div>
		<p style="padding: 0 5px;">您可以加我们“九和茶庄”个人服务微信号为好友：<p>
		<p style="font-size: 24px; text-shadow: 2px 2px 4px #ccc; text-decoration: underline; letter-spacing: 2px;">JHCZ002</p>
		<p style="padding: 0 5px;">随时查看您的中奖信息，以及近期最新的优惠活动，也可以向我们咨询喝茶养身之道，购买最新茶叶。</p>
		<div style="padding: 0 20px;">
			<a class="btn btn-block btn-lg btn-default" href="index.html" style="margin-top: 10%;">返回</a>
		</div>
	</body>
</html>


EOT;
?>

