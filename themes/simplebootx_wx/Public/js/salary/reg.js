require(["zepto",'utils'],function($,utils){
	$(function(){
		var baseurl=$("body").attr("baseurl");
		//发送短信验证码
		$("#btn_vcode").on("tap",function(){
			utils.sendMsg(this,"phone",baseurl+"/index.php?g=Wechat&m=Salary&a=sendVcode");
		});
		
		//提交激活信息
		window.flag=true;
		$("#btn_sub").on("tap",function(){
			if(!window.flag){
				return false;
			}else{
				window.flag=false;
			}
			var name=$.trim($("#name").val());
			var phone=$.trim($("#phone").val());
			var vcode=$.trim($("#vcode").val());
			if(name==""){
				utils.alert("请输入姓名",1500);
				window.flag=true;
				return false;
			}
			if(phone==""){
				utils.alert("请输入手机号",1500);
				window.flag=true;
				return false;
			}
			if(vcode==""){
				utils.alert("请输入验证码",1500);
				window.flag=true;
				return false;
			}
			//数据提交
			utils.wxpost(baseurl+"/index.php?g=Wechat&m=Salary&a=regSave",{
				name:name,
				phone:phone,
				vcode:vcode
			},function(res){
				utils.alert("认证成功",100000000);
				setTimeout(function(){
					utils.loading(true);
					location.href=res.url;
				},1500);
			},function(){
				window.flag=true;
			});
		});
	});
});