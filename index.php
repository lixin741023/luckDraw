<?php
	date_default_timezone_set("PRC");
	$phone=$_REQUEST["phone"];	/*接收从客户端传入的手机号*/

	$server_name="localhost";	/*服务器名*/
	$server_user="root";	/*服务器账户*/
	$server_pas="root";	/*服务器密码*/
	$data_name="luckdraw";	/*数据库名*/

	$conn=mysql_connect($server_name,$server_user,$server_pas);	//链接到服务器
	mysql_select_db($data_name);	//选择数据库
	mysql_query("set names 'utf8'");	//向数据库提交编码格式

	$draw_number_UI=null;	//返回UI抽奖次数
	$gift_UI=null;	//返回UI最终礼物

		//1、判断用户手机号是否存在数据库？？？
	if(select_phone($phone)){	//1.1、如果存在…………
			//2、判断该用户可抽奖次数…………
		if(draw_number_if($phone)>=1){	//2.1、如果可以可抽奖次数为1…………
			start_gift($phone);	//3、-->开始抽奖	
			return_UI($draw_number_UI,$gift_UI);	//4、-->返回json到UI
		}else{	//2.2、如果可抽奖次数不是1-->返回UI结束脚本|
			return_UI($draw_number_UI,$gift_UI);
		};
	}else{	//1.2、如果不存在…………	
		add_phone($phone);	//增把该手机号添加到数据库…………
			//2、判断该用户可抽奖次数…………
		if(draw_number_if($phone)>=1){	//2.1、如果可以可抽奖次数为1…………
			start_gift($phone);	//3、-->开始抽奖	
			return_UI($draw_number_UI,$gift_UI);	//4、-->返回json到UI
		}else{	//2.2、如果可抽奖次数不是1-->返回UI结束脚本|
			return_UI($draw_number_UI,$gift_UI);
		};
	};

	/**流程方法集合**/
	function select_phone($a){	//根据“手机号”查询相关信息function
		$sql="SELECT * FROM lx_user WHERE phone=$a";
		$result=mysql_query($sql,$GLOBALS["conn"]);
		$end=mysql_fetch_assoc($result);
		// var_dump($end);
		return $end;
	};

	function add_phone($a){	//把“手机号”添加到数据库
		$sql="INSERT INTO lx_user(phone) VALUES('$a')";
		$result=mysql_query($sql,$GLOBALS["conn"]);
	};

	function draw_number_if($a){	//判断“手机号”下的可抽奖次数是否为1？？
		$sql="SELECT draw_number FROM lx_user WHERE phone=$a";
		$result=mysql_query($sql,$GLOBALS["conn"]);
		$end=mysql_result($result,0,"draw_number");
		$GLOBALS["draw_number_UI"]=$end;
		return $GLOBALS["draw_number_UI"];
	};

	function name_if($a){	//判断“手机号”下的用户姓名是否为“XXX”？？
		$sql="SELECT name FROM lx_user WHERE phone=$a";
		$result=mysql_query($sql,$GLOBALS["conn"]);
		$end=mysql_result($result,0,"name");
		return $end;
	};

	/***************************************************开始抽奖流程*********************************************/	
	function start_gift($a){	//开始抽奖
		//首先将抽奖用户的可抽奖次数变为-1；
		$draw_number=draw_number_if($a);
		$sql="UPDATE lx_user set draw_number=$draw_number-1 WHERE phone=$a";
		mysql_query($sql,$GLOBALS["conn"]);
		//从未中奖的用户有更高几率中奖(根据其用户名是否是默认的“XXX”)
		if(name_if($a)=="XXX"){
			gifts_rand_super();		//超高几率随机礼物
		}else{
			gifts_rand_normal();	//正常几率随机礼物
		};
	};

	function gifts_rand_super(){	//超高几率随机礼物
		$x=rand(1,100);
		if($x>=1&&$x<=45){	//1~45均中奖	45%
			$x="D";
			gift_sql($x);
		}else{
			$x="E";
			gift_sql($x);
		};
	};

	function gifts_rand_normal(){	//正常几率随机礼物
		$x=rand(1,100);
		if($x>=12&&$x<=14){	//一等奖12~14,3%	A
			$x="A";
			gift_sql($x);
		}else if($x>=22&&$x<=26){	//二等奖22~26,5%	B
			$x="B";
			gift_sql($x);
		}else if($x>=31&&$x<=39){	//三等奖31~39,9%	C
			$x="C";
			gift_sql($x);
		}else if($x>=41&&$x<=54){	//四等奖41~54,14%	D
			$x="D";
			gift_sql($x);
		}else{	//无奖励	E
			$x="E";
			gift_sql($x);
		};
	};

	function gift_sql($gift_x){	//根据传入的“参数”开始在数据库中查找该礼物
		// echo $gift_x;
		$sql="SELECT * FROM lx_gift WHERE gift='$gift_x'";
		$result=mysql_query($sql,$GLOBALS["conn"]);
		$end=mysql_result($result,0,"gift_number");
		if($end==0){	//如果用户抽中的礼物已经被抽完了
			$GLOBALS["gift_UI"]="E";
			update_user_gift($GLOBALS["gift_UI"]);	//把中奖礼物更新到用户信息中
		}else{	//如果用户抽中的礼物没有被抽完……
			$GLOBALS["gift_UI"]=$gift_x;
			update_gift_number($gift_x,$end);	//数据库中该礼物-1
			update_user_gift($GLOBALS["gift_UI"]);	//把中奖礼物更新到用户信息中
		};
	};

	function update_gift_number($a,$b){	//“礼物”被抽走，数据库礼物个数-1
		$sql="UPDATE lx_gift set gift_number=$b-1 WHERE gift='$a'";
		$result=mysql_query($sql,$GLOBALS["conn"]);
	};

	function update_user_gift($a){	//把“中奖礼物”更新到用户信息中
		$sql="SELECT * FROM lx_user WHERE phone=$GLOBALS[phone]";
		$result=mysql_query($sql,$GLOBALS["conn"]);
		$end=mysql_result($result,0,"gifts");
		$gift_string=$end." ".$a;
		$sql="UPDATE lx_user set gifts='$gift_string' WHERE phone=$GLOBALS[phone]";
		$result=mysql_query($sql,$GLOBALS["conn"]);
		update_user_time();	//还需要把中奖的时间更新到用户信息中
	};

	function update_user_time(){	//把中奖的时间更新到用户信息中
		$time=date("m-d").".".date("H:i");	//获取当前时间
		$sql="SELECT * FROM lx_user WHERE phone=$GLOBALS[phone]";
		$result=mysql_query($sql,$GLOBALS["conn"]);
		$end=mysql_result($result,0,"draw_time");
		$new_time="___".$time."  ".$end;
		$sql="UPDATE lx_user set draw_time='$new_time' WHERE phone=$GLOBALS[phone]";
		$result=mysql_query($sql,$GLOBALS["conn"]);
		// echo "\n";
		// echo $time;		
	};
	/***************************************************结束抽奖流程*********************************************/

	function return_UI($a="",$b=""){	//把“可抽奖次数”和“中奖礼物”返回到UI
		$arr_UI=array(
	 		"aaa"=>$a,
	 		"bbb"=>$b
	 	);
	 	$to_UI=json_encode($arr_UI);
	 	echo $to_UI;
	};


mysql_close($conn);
?>