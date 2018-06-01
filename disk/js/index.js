var itis_rong;
var gifts=["金牡丹*100g","水仙*100g","小青柑*100g","铁观音*100g","很遗憾,您未中奖"];	//UI礼物列表；
var gifts_length=gifts.length;	//获取礼物列表长度；

function title_random(min,max){//起始显示->1个随机礼物，排除掉“无奖励”；
	return gifts[Math.floor(min+Math.random()*(max-min))];			
}

function start_animate_time(size){//开始执行动画->次数
	var time=Math.floor(10+Math.random()*(20-10));//随机1个数决定动画次数
//	var fast_time=(time/1.3).toFixed(0);	//高速动画次数
//	var slow_time=time-fast_time;	//低速动画次数
	console.log("总次数"+time);
//	console.log("高速次数"+fast_time);
//	console.log("低数次数"+slow_time);
	for(var i=0; i<time; i++){
		start_animate(size,50,1)
	};
//	for(var i=0; i<fast_time; i++){//高速动画
//		start_animate(size,50,1)//开始执行动画->具体效果
//	};
//	for(var i=0; i<slow_time; i++){//低速动画
//		start_animate(size,50,1)//开始执行动画->具体效果
//	};
	start_animate(size,2500,0);//最终结尾动画
};

function start_animate(size,speed,cb_if){
	$(".box ul").animate({
		"bottom":-size*44.16+"px"
	},speed,function(){		//cb_if:确定动画执行后，是否执行回调；
		if(cb_if==1){		//cb_if==1,才执行回调，每次都改变li的值
			$(".box ul").css("bottom","-15px");
			//每次执行动画，随机出class=“lx”的li的内容
			$(".box ul").find(".lx").text(function(){
				return	title_random(0,gifts_length-1);
			});
		}else{//弹出最终抽奖结果
			setTimeout(show_gift,1000)
		}
	});
};

function show_gift(){
	console.log("奖品是："+ itis_rong);
	if(itis_rong=="E"){
		alert("很遗憾,您未中奖.别忘了明天还有机会哦.");
	}else{
		lx_data.zzc1_guide_if=false;
		lx_data.zzc1_luck_if=true;
		$("#zzc1").fadeIn();
	}
}
//$(document).ready(function(){//界面加载
	//渲染LI
	var frag=document.createDocumentFragment();
	for(var i=0; i<gifts_length; i++){
		var new_li=document.createElement("li");
		new_li.className="lx";
//		new_li.innerText=title_random(0,gifts_length);
		$(frag).append(new_li);
	};
	$(".box ul").append(frag);
	
	var title=$(".box>div");
	title.text(function(){//调用->起始显示1个随机礼物，
		return	title_random(0,gifts_length-1);//排除掉“无奖励”；
	});	
	
	/*“随机礼物”动画*/
+function(){
	title.animate({
		"marginTop":"-3px"
	},500,title_auto_1)
}();
	function title_auto_1(){
		title.animate({
			"marginTop":"3px"
		},500,title_auto_2)
	}
	function title_auto_2(){
		title.animate({
			"marginTop":"-3px"
		},500,title_auto_1)
	};
	
	/*“随机礼物”自动切换*/
	var z=0;
var title_time=setInterval(function(){
		if(z==gifts_length-1){z=0};
		title.text(gifts[z]);
		z++;
	},1500);
	
/*找到“开始抽奖”按钮*/
var go=$(".start");
/*“开始按钮”动画*/
+function(){
	go.animate({
		"bottom":"13.5%"
	},400,start_auto_1)
}();
	function start_auto_1(){
		go.animate({
			"bottom":"12%"
		},400,start_auto_2)
	};
	function start_auto_2(){
		go.animate({
			"bottom":"13.5%"
		},400,start_auto_1)
	};
	
	go.one("click",function(){//点击->开始抽奖
		ajax();  /*************************************************************************开始正式抽奖*/
	});
	
//})//加载完成
function ajax(){
	var xhr=new XMLHttpRequest();
	xhr.onreadystatechange=function(){
		console.log(xhr.readyState);
		console.log(xhr.status);
		if(xhr.readyState==4){//拿到服务器的返回结果：可抽奖次数：aaa；中奖的礼物：bbb;
			var obj = JSON.parse(xhr.responseText);
			console.log(obj);
			lx_data.draw_number=obj.aaa;
			if(lx_data.draw_number>=1){//验证可抽奖次数从服务端获取，并且>=1才有资格抽奖
				start_animate_time(gifts_length+1);//开始抽奖，传入参数（礼物个数+1个固定礼物结果）->控制滚动的距离
				clearInterval(title_time);	//停止title随机礼物的随机效果
				go.stop();	//停止按钮动画
				title.stop();	//停止title随机礼物动画
				go.css("background","url(disk/img/input2.png)");	//按钮按下的背景显现
				go.text(0);	//按钮的值变为0
				title.css("display","none");
				itis_rong=obj.bbb;
				switch (obj.bbb){
					case "A":
						lx_data.prize=gifts[0];
						lx_data.lv="一等奖： ";
						lx_data.money="价值440元";
						break;
					case "B":
						lx_data.prize=gifts[1];
						lx_data.lv="二等奖： ";
						lx_data.money="价值170元";
						break;	
					case "C":
						lx_data.prize=gifts[2];
						lx_data.lv="三等奖： ";
						lx_data.money="价值100元";
						break;	
					case "D":
						lx_data.prize=gifts[3];
						lx_data.lv="四等奖： ";
						lx_data.money="价值76元";
						break;
					case "E":
						lx_data.prize=gifts[4];
						lx_data.lv="无奖励";
						lx_data.money="0元";
						break;
				};
			}else{	//可抽奖次数不是1的时候
				alert("亲，您今天已经抽过奖了，请明天再来吧!");
			};
		};
	};
	xhr.open("POST","index.php",true);
	xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xhr.send(`phone=${lx_data.phone_number}`);
//	xhr.send(`phone=22222222222222222`);
}
