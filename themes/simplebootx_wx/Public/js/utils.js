define(['zepto','iDialog'],function($,iDialog){
	return {
		flip:function(name,title){
			$("body").attr("class",name);
			this.setTitle(title);
		},
		flipSub:function(name,title,id,subname){
			$("body").attr("class",name);
			$("#"+id).attr("class",subname);
			this.setTitle(title);
		},
		setTitle:function(title){
			$("title").html(title);
			var $iframe = $('<iframe style="height:0px;width:0px;border:none;" src="/favicon.ico"></iframe>');
			$iframe.on('load',function() {
				setTimeout(function() {
					$iframe.off('load').remove();
				}, 0);
			}).appendTo($("body"));
			this.loading(false);//清楚加载栏
		},
		setCookie:function(name,value,expire){
			var exp = new Date();
			exp.setTime(exp.getTime() + expire * 60 * 1000);
		    document.cookie = name + "=" + encodeURI(value) + ";expires=" + exp.toGMTString();
		},
		getCookie:function(name){
			var arr = document.cookie.match(new RegExp("(^| )" + name + "=([^;]*)(;|$)"));
		    if (arr != null) {
		        return decodeURI(arr[2]);
		    } else {
		        return "";
		    }
		},
		wxpost:function(url,data,call,Ecall){
			var me=this;
			this.loading(true);
			$.post(url,data,function(res){
				me.loading(false);
				if(res&&res.success){
					if(call!=undefined){
						if(res.message){
							me.alert(res.message,2000);
						}
						call(res);
					}
				}else{
					var mess=res&&res.message?res.message:"操作错误";
					me.alert(mess,2000);
					if(Ecall!=undefined){
						Ecall(res);
					}
					if(res.url){
						setTimeout(function(){
							location.href=res.url;
						},2000);
					}
				}
			},'json');
		},
		isSub:function(call){//判断是否关注
			var baseurl=$("body").attr("baseurl");
			this.wxpost(baseurl+"/index.php?g=wechat&m=user&a=issub",{},function(res){
				if(call!=undefined){
					call(res);
				}
			});
		},
		isLogin:function(call){//判断是否登陆
			var baseurl=$("body").attr("baseurl");
			this.wxpost(baseurl+"/index.php?g=wechat&m=user&a=islogin",{},function(res){
				if(call!=undefined){
					call(res);
				}                                                                                                                                                                                                                                                                                        
			});
		},
		sendMsg:function(handel,phoneId,sendUrl){
			var me=this;
			var _this=handel;
			if(!_this.index){
				console.log(_this.index);
				_this.index=60;
				var myphone=$.trim($("#"+phoneId).val());
				if(/^\d{11}$/.test(myphone)){
					$(_this).html("发送中...");
					$.post(sendUrl,{
						phone : myphone
					},function(res){
						if (res.success) {
							$(_this).html("发送成功");
							_this.timer = setInterval(function(){
								if(_this.index<=0){
									clearInterval(_this.timer);
									$(_this).html("获取验证码");
								}else{
									_this.index--;
									$(_this).html(_this.index+"秒");
								}
							}, 1000);

						} else {
							me.alert(res.message, 1500);
							$(_this).html("获取验证码");
							_this.index=0;
						}
					},"json")
				}else{
					me.alert('手机号码不正确', 1500);
					_this.index=0;
				}
			}
		},
		alert:function(f, c){
			var e = new iDialog();
			var a = {
				classList: "alert",
				title: "",
				close: "",
				content: '<div class="icon success"></div><div style="padding:10px 30px;line-height:23px;text-align:center;font-size:14px;color:#ffffff;">' + f + "</div>"
			};
			var g = null;
			e.open(a);
			if (c) {
				g = setTimeout(function() {
					e.die();
					clearTimeout(g)
				}, c)
			}
		},
		info:function(f, c){
			var e = new iDialog();
			var a = {
				classList: "alert",
				title: "",
				close: "<span id='self_close' style='color:#fff;margin-right: 10px;'>x</span>",
				content: '<div style="padding:10px 30px;line-height:23px;text-align:center;font-size:14px;color:#ffffff;">' + f + "</div>"
			};
			var g = null;
			e.open(a);
			if (c) {
				g = setTimeout(function() {
					e.die();
					clearTimeout(g)
				}, c)
			}
		},
		loading:function(a){
			if (a) {
				window.loader = new iDialog();
				window.loader.open({
					classList: "loading",
					title: "",
					close: "",
					content: ""
				})
			} else {
				if(window.loader){
					window.loader.die();
					delete window.loader
				}
			}
		},
		confirm:function(f, c, b){
			var e = new iDialog();
			var a = {
				classList: "tip",
				title: "",
				close: "",
				content: f
			};
			a.btns = [{
				id: "",
				name: "确定",
				onclick: "fn.call();",
				fn: function(d) {
					c && c.call(this);
					d.die()
				}
			}, {
				id: "",
				name: "取消",
				onclick: "fn.call();",
				fn: function(d) {
					b && b.call(this);
					d.die()
				}
			}];
			e.open(a)
		}
	};
});