/**数据导入导出*/
var lx_data=new Vue({
	el:".bg",
	data:{
		phone_number:"",	//手机号码
		draw_number:"",	//可抽奖次数？
		
		zzc1_guide_if:true,	//活动介绍框显示？隐藏
		zzc1_luck_if:false,	//中奖提示框显示？隐藏
		zzc1_form_if:false,	//中奖表单填写显示？隐藏
		
		prize:"很遗憾,您未中奖",	//最终中奖，默认：未中奖
		lv:"",	//奖品等级
		money:""	//奖品价值
	},
	methods:{
		phoneUP:function(){
			if(/^1[3|4|5|7|8][0-9]{9}$/.test(this.phone_number)){//手机号合法性验证
				//把 合法手机号 存入localstorage，并且禁用input输入；
//				localStorage.setItem("phone",this.phone_number);//2018年2月10日22:03:19
				$("#zzc1").fadeOut();
				this.zzc1_guide_if=false;
			}else{
				alert("亲，您可能输入了错误的手机号。")
			};
		},
		zzc1_form_show:function(){
			this.zzc1_luck_if=false;
			this.zzc1_form_if=true;
			var xhr=new XMLHttpRequest();
			
  	xhr.onreadystatechange=function(){
//		console.log(xhr.readyState);
//		console.log(xhr.status);
//		console.log("------------------------")
		if(xhr.readyState==4){
			obj=JSON.parse(xhr.responseText);	//生成全局location对象
			frag=document.createDocumentFragment();	//创建全局文档碎片
			$(".lx_province").append(lx_create1);
			$(".lx_province").change(lx_create2);
			+function(){lx_create2()}();
//			$("#lx").val(this.phone_number);
		};
  	};
	xhr.open("GET","disk/js/data.json",true);
  	xhr.send();
  	
  	function lx_create1(){
//		console.log("aaaaaaa")
  		for(var i=0; i<obj.provinces.length; i++){
  			var new_op=document.createElement("option");
  			new_op.innerHTML=obj.provinces[i].provinceName;
  			$(frag).append(new_op);
  		}
  		return frag;
  	};
  	
  	function lx_create2(){
//		console.log("bbbbbbbbbbb")
  		for(var i=0; i<obj.provinces.length; i++){
  			if($(".lx_province").find("option:selected").text()==obj.provinces[i].provinceName){
  				$(".lx_city option").remove();
  				for(var z=0; z<obj.provinces[i].citys.length; z++){
  					var new_op=document.createElement("option");
  					new_op.innerHTML=obj.provinces[i].citys[z].citysName;
  					$(frag).append(new_op);
  				};
  				$(".lx_city").append(frag);
  			};
  		};
  	};
		},
		end:function(){
			
			console.log($("#name").val());
			localStorage.setItem("name",$("#name").val());
			
			console.log($("#address_province").val());
			localStorage.setItem("address_province",$("#address_province").val());
			
			console.log($("#address_city").val());
			localStorage.setItem("address_city",$("#address_city").val());
			
			console.log($("#address_address").val());
			localStorage.setItem("address_address",$("#address_address").val());
			
		}
	}//methods_end
	
});//数据end	

/*页面载入后检查localstorage的值*/
if(localStorage.getItem("phone")==null){//localstorage为null，说明是第一次进入；
		
}else{//当localstorage的值没有null，则不弹出输入手机号码框；
	$("#zzc1").css("display","none");
	lx_data.phone_number=localStorage.getItem("phone");
};

setInterval(function(){
	console.log("vue实例中的值: "+lx_data.phone_number)
},2000)
setInterval(function(){
	console.log("本地存储的值值: "+localStorage.getItem("phone"));
	console.log("-------------------------------------------")
},2000)	


