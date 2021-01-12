<?php if (!defined('THINK_PATH')) exit();?><html ng-app="HotelmApp" class="ng-scope">

	<head>
		<style type="text/css">
			@charset "UTF-8";
			[ng\:cloak],
			[ng-cloak],
			[data-ng-cloak],
			[x-ng-cloak],
			.ng-cloak,
			.x-ng-cloak,
			.ng-hide:not(.ng-hide-animate) {
				display: none !important;
			}
			
			ng\:form {
				display: block;
			}
		</style>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no, initial-scale=1">
		<meta content="telephone=no,email=no" name="format-detection">
		<title ng-bind="hotel_basic_info.hname" class="ng-binding">电谷国际酒店</title>
		<!--<link href="/webapp/css/all.css?v=4.0" rel="stylesheet" />-->
		<link href="/themes/simplebootx_wx/Public/css/all.css?v=4.77" rel="stylesheet">
		<link href="/themes/simplebootx_wx/Public/css/gong.css" rel="stylesheet">

	</head>

	<body>
		<!--    <div ng-bind-html="hotel_basic_info.style_val | trustHtml"></div>-->

		<div id="style_val_h">
			<link href="/themes/simplebootx_wx/Public/css/style.css" rel="stylesheet">
		</div>
		
		<div class="header bg_color_blue1 " style="width: 100%; transform-origin: 0px 0px 0px; opacity: 1; transform: scale(1, 1);" id="div_top_bar">
			<i class="back lt "></i>
			<i class="menu rt"></i>
			<div class="title color_white1 f22 lt">订单详情</div>
		</div>

		<ul id="topnav" class="bg_color_blue1 color_white1 w98 f20" style="display: none;">
	<a href="<?php echo U('Index/index');?>">
		<li style="color:#FFFFFF;" class="border_color_blue2 ng-binding ng-scope" ng-if="hotel_basic_info.realhid!=100289" ng-click="jump('/'+hotel_basic_info.realhid)">首页</li>
	</a>
	<a href="<?php echo U('Contact/info');?>" >
		<li style="color:#FFFFFF;" class="border_color_blue2 ng-binding" ng-click="jump('/'+hotel_basic_info.realhid+'/hotelintroduce/index')">酒店介绍</li>
	</a>
	<a href="<?php echo U('Index/xinwen');?>" >
		<li style="color:#FFFFFF;" class="border_color_blue2 ng-binding" ng-click="jump('/'+hotel_basic_info.realhid+'/news/list')">酒店新闻</li>
	</a>
	<a href="<?php echo U('Index/photo');?>">
		<li style="color:#FFFFFF;" class="border_color_blue2 ng-binding" ng-click="jump('/'+hotel_basic_info.realhid+'/hotelintro/index')">酒店相册</li>
	</a>
	<!--<li class="border_color_blue2 ng-binding" ng-click="jump('/'+hotel_basic_info.realhid+'/hotelintro/pictorialindex')">酒店画报</li>-->
	<!--<li class="border_color_blue2 ng-scope" ng-if="hotel_basic_info.realhid!=100289" ng-click="go_game()">互动游戏</li>-->
	<?php $phone = $_SESSION['fans']['phone']; ?>
	<?php if($phone): ?><a href="<?php echo U('User/user_center');?>" style="color: #fff;">
	<li class="border_color_blue2" ng-click="jump('/'+hotel_basic_info.realhid+'/member/index')">会员中心</li>
	</a>
	<?php else: ?>
	<a href="<?php echo U('User/reg');?>" style="color: #fff;">
	<li class="border_color_blue2" ng-click="jump('/'+hotel_basic_info.realhid+'/member/index')">会员中心</li>
	</a><?php endif; ?>
	<li>
	</li>
</ul>
		<!-- ngView:  -->
		<div id="main_main" ng-view="" class="ng-scope">

			<style class="ng-scope">
				.maincontent {
					padding-bottom: 65px;
				}
				
				.orderinfo {
					border-top-width: 1px;
					border-bottom-width: 1px;
					margin-top: 10px;
					line-height: 28px;
					padding-bottom: 5px;
					background-color: #fff
				}
				
				.orderinfo> p:first-child {
					height: 38px;
					line-height: 38px;
					border-bottom-width: 1px;
					margin-bottom: 5px;
				}
				
				.hotelinfo .info {
					overflow: hidden;
				}
				
				.hotelinfo .info span {
					display: block;
					height: 30px;
					line-height: 30px;
				}
				
				.hotelinfo .rtb {
					width: 90px;
					position: absolute;
					top: 0px;
					right: 0;
				}
				
				.hotelinfo .rtb span {
					display: block;
					height: 38px;
					line-height: 38px;
					text-align: center;
					border-radius: 5px;
					margin-bottom: 8px;
				}
				
				.hotelinfo .rtb span:first-child {
					margin-top: 58px;
				}
				
				.hotelinfo .info li {
					display: block;
					/*height: 32px;*/
					line-height: 32px;
				}
				
				.person {
					margin-right: 10px;
					float: left;
					display: block;
				}
				
				#xx_xq .er_dashed {
					border-width: 1px;
					border-style: dashed;
					padding: 0 8px;
					text-align: center;
					height: 24px;
					margin-top: 6px;
					line-height: 24px;
					margin-right: 5px;
					height: 20px;
					line-height: 18px;
					width: auto;
				}
				
				@media screen and (max-width: 350px) {
					.day {
						margin-left: 105px;
					}
				}
				
			</style>
			<?php $status = array("1"=>"待支付","2"=>"已支付","3"=>"订单已确认","-1"=>"订单已取消"); ?>
			<div class="maincontent bg_color_gray3 ng-scope">
				<div class="orderinfo border_color_gray1 w98">
					<p class="border_color_gray1 color_black1">订单信息<?php if($ordercyList['status'] == '-1'): ?><span style="display:none;" class="rt color_blue1" id="calcel" >取消订单</span><?php else: ?><span class="rt color_blue1" id="calcel" >取消订单</span><?php endif; ?></p>
					<!--   OrderInfo.osatus>0-->
					<p class="ng-binding">
						<input type="hidden" id="orderid" name="id" value="<?php echo ($ordercyList['id']); ?>">
						订单状态：<?php echo ($status[$ordercyList['status']]); ?>
						<!--<span class="color_blue1" ng-click="showReason()" ng-if="OrderInfo.osatus==-5||OrderInfo.osatus==-6" style="margin-left:20px;">查看原因</span>--><br> 预订日期：<?php echo (date("Y-m-d H:i:s",$ordercyList['created'] )); ?>
						<br> 订单编号:<?php echo ($ordercyList["id"]); ?>

					</p>
				</div>
				<div class="orderinfo border_color_gray1 w98">
					<p class="border_color_gray1 color_black1">订单金额<?php if($ordercyList['status'] == '-1'): ?><span class="rt color_blue1" style="display:none;" ng-click="pay()" id="orderpay">去支付</span><?php else: if(empty($ordercyList['automn'])): ?><span class="rt color_blue1" id="orderpay" ng-click="pay()">去支付</span><?php endif; endif; ?></p>
					<p class="ng-binding">
						订单总价：￥<?php echo ($ordercyList['paycost']); ?><br> 付款方式：在线付

					</p>
				</div>

				<div class="orderinfo border_color_gray1 w98 hotelinfo">
					<p class="border_color_gray1 color_black1">酒店信息</p>
					<div style="position:relative; padding-right:90px;">
						<div class="info" id="xx_xq">
							<?php $weizhi = array("1"=>"大厅","2"=>"包间","3"=>"送餐") ?>
							<ul>
								<li class="f18 color_black1 ng-binding">电谷国际酒店-<?php echo ($ordercyList["resname"]); ?></li>
								<li class="ng-binding">就餐时段：<?php echo ($ordercyList["name"]); ?></li>
								<li class="ng-binding">就餐位置：<?php echo ($weizhi[$ordercyList["jcaddress"]]); ?></li>
								<li class="ng-binding">用餐人数：<?php echo ($ordercyList["jcnum"]); ?> </li>
								<li style="overflow:hidden">
									<p class="lt" style="width:auto;">用餐时间：</p>
									<p class="lt ng-binding ng-scope" style="width:auto;" ng-if="OrderInfo.istransport!=10"><?php echo (date("Y-m-d",$ordercyList['ctime'] )); ?></p>
								</li>
								<li ng-if="OrderInfo.extend!=null&amp;&amp;OrderInfo.extend!=''" class="ng-scope">
									<p style="width:90px;float: left">我的菜单：</p>
									<?php if(is_array($foodList)): foreach($foodList as $key=>$vo): ?><p class="f14 lt er_dashed color_red1 border_color_red1 lt ng-binding ng-scope" ng-repeat="cd in OrderInfo.extend"><?php echo ($vo["foodname"]); ?></p><?php endforeach; endif; ?>
								</li>
							</ul>
						</div>
						<div class="rtb color_white1">
							<span class="bg_color_blue1" id="tel"><a href="tel:<?php echo ($info['hotel_tel']); ?>" style="color:#fff;">酒店电话</a></span>

						</div>
						<div class="clear"></div>

					</div>
				</div>

				<div class="orderinfo border_color_gray1 w98">
					<p class="border_color_gray1 color_black1">联系人信息</p>
					<p class="ng-binding">
						<span class="color_black1 ng-binding" "=" ">联系人：<?php echo ($ordercyList['vipname']); ?></span>          
            <br>
            联系电话：<?php echo ($ordercyList['vipphone']); ?>
        </p>
    </div>
</div>
<div class="modal " id="calcelok" style="display:none; "><div class="main bg_color_white1 "><p class="f18 content " style="padding: 10px 0px 0; line-height: 36px; text-align: center; ">您确定取消订单？</p><p class="btn color_blue1 "><span class="cancel lt " id="shou">手抖了</span><span class="ok rt " id="shouok">确认取消</span></p></div></div>

<!--<div class="modal bg_color_white1 " id="calcelblock ">
    <p class="title f18 bg_color_blue1 color_white1 w98 ">取消订单</p>
    <div class="main w98 ">
        <textarea id="content " rows="10 " class="border_color_gray1 " draggable="false ">

        </textarea>
        <p class="btn ">
<span class="ok color_white1 bg_color_blue1 " ng-click="calcel() ">确认</span>
<span class="cancel color_white1 bg_color_gray1 " id="close ">关闭</span>
        </p>
        
    </div>
</div>

<div class="modal bg_color_white1 " id="calcelreason " style="height:auto; ">
     <p class="title f18 bg_color_blue1 color_white1 w98 ">取消原因</p>
    <div class="main w98 ">
        <p style="min-height:100px; margin-top:10px; ">{{OrderInfo.cancelreason}}</p>
        <p class="btn " >
<span class="cancel color_white1 bg_color_blue1 " style="margin:10px auto; float:none " id="closeRea ">关闭</span>
        </p>
    </div>

</div>--></div>

    <div id="div_footer_item" class="bottom_nav w98 bg_color_white1 border_color_gray1" style="display: block; transform-origin: 0px 0px 0px; opacity: 1; transform: scale(1, 1);">
	<a href="<?php echo U('Room/room');?>">
		<p class="lt one <?php echo ($room_curr); ?>">
			<span class="f14">客房</span>
		</p>
	</a>
	<a href="<?php echo U('Restaurant/restaurant');?>">
		<p class="lt two <?php echo ($restaurant_curr); ?>">
			<span class="f14">餐饮</span>
		</p>
	</a>
	<a href="<?php echo U('Conferenceroom/meeting');?>">
		<p class="lt three <?php echo ($meeting_curr); ?>">
			<span class="f14">会议</span>
		</p>
	</a>
	<a href="<?php echo U('Sports/sports');?>">
		<p class="lt four <?php echo ($sports_curr); ?>">
			<span class="f14">娱乐</span>
		</p>
	</a>
	<a href="<?php echo U('User/user_center');?>">
		<p class="lt five <?php echo ($user_curr); ?>">
			<span class="f14">我的</span>
		</p>
	</a>
	<div class="clear"></div>
</div>

<p id="p_copyright" class="footer f14 ng-binding" style="display: block; transform-origin: 0px 0px 0px; opacity: 1; transform: scale(1, 1);">
	Copyright @2014-2015 电谷国际酒店<br> All Right Reseved E酒店 技术支持
</p>
		<div class="mask"></div>
		<div id="div_ajax_start" style="position: fixed; z-index: 999999; text-align: center; width: 100%; height: 100%; top: 0; left: 0; -webkit-transform-origin: 0px 0px 0px; opacity: 1; -webkit-transform: scale(1, 1); background-color: rgba(0,0,0,0.6); display: none">
			<div style="background-color: #f5f1ee; padding: 20px 60px; top: 50%; border-radius: 15px; left: 50%; margin-left: -110px; margin-top: -70px; width: 220px; height: 140px; position: absolute; box-sizing: border-box;">

				<img src="/themes/simplebootx_wx/Public/img/loading.gif" style="width: 80%; display: block; margin-left: 10%;">
				<span class="f18" style="margin-top: -10px; color: #454545">努力加载中...</span>
			</div>
		</div>

		<div id="div_ajax_start1" style="position: fixed; z-index: 999999; text-align: center; width: 100%; height: 100%; top: 0px; left: 0px; transform-origin: 0px 0px 0px; opacity: 1; transform: scale(1, 1); display: none; background-color: rgb(245, 241, 238);">
			<div style="padding: 20px 60px; top: 50%; border-radius: 15px; left: 50%; width: 320px; margin-left: -160px; height: 150px; margin-top: -75px; position: absolute; box-sizing: border-box;">

				<img src="/themes/simplebootx_wx/Public/img/loading.gif" style="width: 78px; display: block; margin: 0 auto;">
				<span class="f18" style="margin-top: 5px; color: #454545">努力加载中...</span>
			</div>
		</div>
		<div id="resu" style="position: fixed; display: none; border-radius: 5px; background-color: rgba(0,0,0,0.8); height: 36px; line-height: 36px; top: 70%; margin-top: -18px; width: 70%; margin-left: 15%; text-align: center; color: #fff">
			支付失败
		</div>
    <!--  <div class="modal bg_color_white1 " id="confirmblock ">
    <div class="main " style="padding: 0 20px; ">

        <p class="f18 content "  style="padding: 10px 0px 0; line-height: 36px; text-align: center; ">您的订单未填写完成，是否确定要离开当前页面？</p>
        <p class="btn color_blue1 ">
            <span class="cancel lt " onclick="return false; ">取消</span>
            <span class="ok rt " onclick="return true; ">离开</span>
        </p>

    </div>
</div>-->
    <script src="/themes/simplebootx_wx/Public/js/zepto.1.1.6.min.js?v=1.111 "></script>
	<script src="/themes/simplebootx_wx/Public/js/fastclick.1.0.6.min.js "></script>
	<script src="/themes/simplebootx_wx/Public/js/calenda.js?v=4.1 "></script>
	<script src="/themes/simplebootx_wx/Public/js/gong.js " type="text/javascript " charset="utf-8 "></script>
	<script src="/themes/simplebootx_wx/Public/js/jQuery.js " type="text/javascript " charset="utf-8 "></script>

    <script>
        //$("#style_val ").html(decodeURIComponent(style_val));//多色系样式绑定
        $(function () {
            FastClick.attach(document.body);
        });

        /*********ajax等待相关开始*********/
        $(document).on("ajaxStart ", function (e, xhr, options) {
            $("#div_ajax_start ").attr('stat', 'starting');
            setTimeout(function () {
                if ($("#div_ajax_start ").attr('stat') == 'starting') {

                    $("#div_ajax_start ").show();
                }
            }, 10);
        })
        $(document).on("ajaxStop ", function (e, xhr, options) {
            setTimeout(function () {
                $("#div_ajax_start ").attr('stat', 'stop').hide();

            }, 1000)
        })

        /*********ajax等待相关开始*********/
        $(document).on("ajaxStart1 ", function () {
            setTimeout(function () {
                $("#div_ajax_start1 ").show();
            }, 10);
        })
        $(document).on("ajaxStop1 ", function () {
            setTimeout(function () {
                $("#div_ajax_start1 ").hide();
            }, 1000)
        })
        var window_width = $(window).width();
        var window_height = $(window).height();
        /*********ajax等待相关结束*********/
    </script>
    <script>
		$("#calcel").on("click",function(){
			$("#calcelok").css({display:"block"});
		})
		$("#shou").on("click",function(){
			$("#calcelok").css({display:"none"});
		})
		$("#shouok").on("click",function(){
			var id = $("#orderid").val();
			var status = "-1";
			$.post("<?php echo U('User/cydelete');?>",{id:id,status:status},function(data){
				if(data.code == 0){
					$("#calcelok").css({display:"none"});
					$("#status").html(data.data);
					$("#calcel").css({display:"none"});
					$("#chainfo").css({display:"none"});
				}
			},"json")
		})
		$("#chainfo").on("click",function(){
			$("#jiudianxinxi").css({display:"block"});
		})
		$(".guanbiok").on("click",function(){
			$("#jiudianxinxi").css({display:"none"});
		})
		$("#orderpay").on("click",function(){
			var cyid = $("#orderid").val();
			$.post("http://diangu.yijiudian.cn/Wechat/User/cyorderPay",{cyid:cyid},function(data){
      			if(data.success){
		          	var jsonparam=JSON.parse(data.payparam);
					WeixinJSBridge.invoke(
						'getBrandWCPayRequest',
						jsonparam,
						function(res){
							WeixinJSBridge.log(res.err_msg);
							if(res.err_msg == "get_brand_wcpay_request:ok"){
								alert("支付成功");
								setTimeout(function(){
									window.location.href = "";
								}, 200);
							}else{
								//支付失败或者取消支付
								alert(res.err_msg);
							}
						}
					);
      			}else{
      				alert(data.msg);
      			}
      		},"json");
		})	
		</script>


</body></html>