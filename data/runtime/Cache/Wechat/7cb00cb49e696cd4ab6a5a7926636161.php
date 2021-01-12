<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html ng-app="HotelmApp" class="ng-scope">

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
			<div class="title color_white1 f22 lt">休闲娱乐</div>
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
			<style type="text/css" class="ng-scope">
				.maincontent {
					padding-bottom: 65px;
				}
				/*main*/
				
				.main {
					border-bottom-width: 1px;
					overflow: hidden;
					padding-bottom: 17px;
					min-height: 153px;
				}
				
				.main .name {
					line-height: 24px;
					margin-top: 12px;
					margin-bottom: 2px;
				}
				
				.main-bg {
					position: relative;
					padding-left: 95px;
					width: 100%;
					box-sizing: border-box;
				}
				
				.main-bg img {
					width: 90px;
					height: 90px;
					top: 5px;
					position: absolute;
					left: 0px;
				}
				
				.main p {
					line-height: 24px;
				}
				
				.condition {
					max-width: 33%;
					margin-left: 3%;
					overflow: visible;
					margin-top: 2px;
				}
				
				.condition p {
					overflow: visible;
					width: 120%;
				}
				
				.price {
					max-width: 50%;
				}
				
				.price p {
					text-align: right;
				}
				
				.consultation {
					margin-top: 6px;
					text-align: center;
					line-height: 26px;
					width: 80px;
					height: 26px;
					-moz-border-radius: 5px;
					-webkit-border-radius: 5px;
					border-radius: 5px;
				}
				
				.more {
					height: 38px;
					line-height: 38px;
					width: 100%;
					display: block;
					text-align: center;
					margin: 8px auto 0px;
				}
			</style>
			<div class="maincontent ng-scope" style="min-height: 470px;">
				<?php if(is_array($Sports)): foreach($Sports as $key=>$vo): $p = json_decode($vo['picurls'],true); ?>
					<a href="<?php echo U('Sports/sports_detail',array('id'=>$vo['id']));?>" style="color:#000000;">
						<div id="list">
							<div class="main w98 border_color_gray1 sportsingle ng-scope" data-tel="0312-8631655">
								<p class="color_black2 f18 name ng-binding"><?php echo ($vo["ename"]); ?></p>
								<div class="main-bg lt">
									<img src="<?php echo sp_get_asset_upload_path($p['photo'][0]['url']);?>">
									<div class="condition lt f14">
										<p style="display:none" class="ng-binding"><span class="color_blue1 ng-binding">5</span>分/0评论</p>

										<p class="ng-binding"><?php echo ($vo["name"]); ?></p>
										<p class="ng-binding ng-scope">位于：<?php echo ($vo["enaddress"]); ?></p>

									</div>
									<div class="price rt">
										<p class="f14 color_black2" style="height: 24px;">
											<span class="ng-scope"><span class="color_red1 f20  ng-binding">￥<?php echo ($vo["perperson"]); ?></span> 起</span>

										</p>

										<div <?php if($vo['issuppre'] == -1): ?>style="display:none;"<?php endif; ?> class="consultation bg_color_yellow2 f14 color_white1 rt clear book ng-scope">马上预订</div>
											<div class="consultation bg_color_yellow1 f14 color_white1 rt clear tel ng-scope"><a href="tel:<?php echo ($vo["entel"]); ?>" style="color: #fff;">电话咨询</a></div>
									</div>

								</div>

							</div>

						</div>
					</a><?php endforeach; endif; ?>
				<span class="more bg_color_gray2 f16 color_gray1 " id="pageNext" style="display: none;">点击查看更多</span>
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

				<img src="http://image.365zhiding.com/hotelm/img/loading.gif" style="width: 80%; display: block; margin-left: 10%;">
				<span class="f18" style="margin-top: -10px; color: #454545">努力加载中...</span>
			</div>
		</div>

		<div id="div_ajax_start1" style="position: fixed; z-index: 999999; text-align: center; width: 100%; height: 100%; top: 0px; left: 0px; transform-origin: 0px 0px 0px; opacity: 1; transform: scale(1, 1); display: none; background-color: rgb(245, 241, 238);">
			<div style="padding: 20px 60px; top: 50%; border-radius: 15px; left: 50%; width: 320px; margin-left: -160px; height: 150px; margin-top: -75px; position: absolute; box-sizing: border-box;">

				<img src="http://image.365zhiding.com/hotelm/img/loading.gif" style="width: 78px; display: block; margin: 0 auto;">
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