<?php
	
	$server_name="localhost";	/*服务器名*/
	$server_user="root";	/*服务器账户*/
	$server_pas="root";	/*服务器密码*/
	$data_name="luckdraw";	/*数据库名*/

	$conn=mysql_connect($server_name,$server_user,$server_pas);	//链接到服务器
	mysql_select_db($data_name);	//选择数据库
	mysql_query("set names 'utf8'");	//向数据库提交编码格式	

	$sql="SELECT * FROM lx_user";
	$result=mysql_query($sql,$conn);
	while($end=mysql_fetch_assoc($result)){
		$user_list[]=$end;
	};

	$to_UI=json_encode($user_list);
	echo $to_UI;



	mysql_close($conn);
?>
