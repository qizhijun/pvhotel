<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html ng-app='HotelmApp'>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no, initial-scale=1" />
		<meta content="telephone=no,email=no" name="format-detection" />
		<title ng-bind="hotel_basic_info.hname"></title>
		<!--<link href="/webapp/css/all.css?v=4.0" rel="stylesheet" />-->
		<link href="/themes/simplebootx_wx/Public/css/all.css?v=4.77" rel="stylesheet">
		<link href="/themes/simplebootx_wx/Public/css/gong.css" rel="stylesheet">
	</head>

	<body style="max-width: 640px;">

		<div id="style_val_h">
			<link href="/themes/simplebootx_wx/Public/css/style.css" rel="stylesheet">
		</div>
		<div class="header bg_color_blue1 " style="width: 100%;" id="div_top_bar">
			<i class="back lt "></i>
			<i class="menu rt"></i>
			<div class="title color_white1 f22 lt">客房订单</div>
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
		<div id="main_main" ng-view="" class="ng-scope">
			<style class="ng-scope">
				#orderresult {
					position: fixed;
					z-index: 1;
					top: 0px;
					left: 0;
					height: 100%;
					width: 100%;
					-webkit-transform: translateX(100%);
					-moz-transform: translateX(100%);
					-ms-transform: translateX(100%);
					-o-transform: translateX(100%);
					transform: translateX(100%);
					-webkit-transition: -webkit-transform 0.3s;
					-moz-transition: -moz-transform 0.3s;
					transition: transform 0.3s;
				}
				
				#orderresult .maincontent {
					height: 100%;
					overflow-y: scroll;
					visibility: visible;
					position: relative;
				}
				
				#orderresult.is-visible {
					-webkit-transform: translateX(0);
					-moz-transform: translateX(0);
					-ms-transform: translateX(0);
					-o-transform: translateX(0);
					transform: translateX(0);
				}
				
				.info {
					padding: 35px 0;
					border-bottom-width: 1px;
				}
				
				.info span {
					display: block;
					text-align: center;
				}
				
				.info .ellipse {
					display: block;
					width: 50px;
					height: 50px;
					border-radius: 25px;
					margin: 0 auto 0;
					position: relative;
				}
				
				.info .ok {
					width: 12px;
					height: 21px;
					border-width: 3px;
					border-style: solid;
					border-color: transparent #fff #fff transparent;
					position: absolute;
					right: 15px;
					top: 8px;
					transform: rotate(45deg);
					-webkit-transform: rotate(45deg);
					-o-transform: rotate(45deg);
					border-top-right-radius: 5px;
					border-bottom-left-radius: 5px;
					border-bottom-right-radius: 4px;
				}
				
				.ordermaininfo {
					border-top-width: 1px;
					border-bottom-width: 1px;
				}
				
				.ordermaininfo .lt {
					width: calc(100% - 95px);
					line-height: 26px;
					padding: 12px 0;
				}
				
				.ordermaininfo .lt span {
					display: block;
				}
				
				.ordermaininfo .rt {
					width: 95px;
					height: 76px;
					line-height: 76px;
				}
				
				.ordermaininfo .jiantou {
					position: relative;
					padding-right: 20px;
				}
				
				.ordermaininfo .jiantou:after {
					top: 10px;
				}
				
				.ordermaininfo .jiantou:before {
					top: 2px;
				}
			</style>

			<div class="maincontent ng-scope">

				<div class="info ">
					<span class="ellipse  bg_color_blue1">
	            <span class="ok  bg_color_blue1"></span>
					</span>
					<span class="f20 color_black1" style="height: 32px; line-height: 32px;">提交成功</span>
					<span class="f16 color_black1">我们会尽快处理，稍后向您通知结果</span>
				</div>
				<div class="ordermaininfo border_color_gray1 w98">
					<div class="lt">
						<span class="ng-binding">电谷国际酒店</span>

						<span class="ng-binding"><?php echo ($orderList['room_name']); ?> </span>
					</div>
					<a href="<?php echo U('User/roomorderlist',array('id'=>$orderList['id']));?>" style="color: #333;">
					<div class="rt" ng-click="detail()">
						订单详情<span class="jiantou"></span>

					</div>
					</a>
					<div class="clear"></div>
				</div>
			</div>

		</div>

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

				<img src="http://image.365zhiding.com/hotelm/img/loading.gif" style="width: 80%; display: block; margin-left: 10%;" />
				<span class="f18" style="margin-top: -10px; color: #454545">努力加载中...</span>
			</div>
		</div>

		<div id="div_ajax_start1" style="display: none; position: fixed; z-index: 999999; text-align: center; width: 100%; height: 100%; top: 0; left: 0; -webkit-transform-origin: 0px 0px 0px; opacity: 1; -webkit-transform: scale(1, 1); background-color: #f5f1ee;">
			<div style="padding: 20px 60px; top: 50%; border-radius: 15px; left: 50%; width: 320px; margin-left: -160px; height: 150px; margin-top: -75px; position: absolute; box-sizing: border-box;">

				<img src="http://image.365zhiding.com/hotelm/img/loading.gif" style="width: 78px; display: block; margin: 0 auto;" />
				<span class="f18" style="margin-top: 5px; color: #454545">努力加载中...</span>
			</div>
		</div>
		<div id="resu" style="position: fixed; display: none; border-radius: 5px; background-color: rgba(0,0,0,0.8); height: 36px; line-height: 36px; top: 70%; margin-top: -18px; width: 70%; margin-left: 15%; text-align: center; color: #fff">
			支付失败
		</div>
		<script src="/themes/simplebootx_wx/Public/js/zepto.1.1.6.min.js?v=1.111"></script>
		<script src="/themes/simplebootx_wx/Public/js/fastclick.1.0.6.min.js"></script>
		<script src="/themes/simplebootx_wx/Public/js/calenda.js?v=4.1"></script>
		<script src="/themes/simplebootx_wx/Public/js/gong.js" type="text/javascript" charset="utf-8"></script>

		<script>
			//$("#style_val").html(decodeURIComponent(style_val));//多色系样式绑定
			$(function() {
				FastClick.attach(document.body);
			});

			/*********ajax等待相关开始*********/
			$(document).on("ajaxStart", function(e, xhr, options) {
				$("#div_ajax_start").attr('stat', 'starting');
				setTimeout(function() {
					if($("#div_ajax_start").attr('stat') == 'starting') {

						$("#div_ajax_start").show();
					}
				}, 10);
			})
			$(document).on("ajaxStop", function(e, xhr, options) {
				setTimeout(function() {
					$("#div_ajax_start").attr('stat', 'stop').hide();

				}, 1000)
			})

			/*********ajax等待相关开始*********/
			$(document).on("ajaxStart1", function() {
				setTimeout(function() {
					$("#div_ajax_start1").show();
				}, 10);
			})
			$(document).on("ajaxStop1", function() {
				setTimeout(function() {
					$("#div_ajax_start1").hide();
				}, 1000)
			})
			var window_width = $(window).width();
			var window_height = $(window).height();
			/*********ajax等待相关结束*********/
		</script>

	</body>

</html>