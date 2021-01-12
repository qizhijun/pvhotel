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
		<link href="/themes/simplebootx_wx/Public/css/all.css?v=4.77" rel="stylesheet">
		<link href="/themes/simplebootx_wx/Public/css/gong.css" rel="stylesheet">
		<script src="/themes/simplebootx_wx/Public/js/Pictorialdetail.js?v=11.18" async=""></script>
		<script src="/themes/simplebootx_wx/Public/js/hhSwipe.js" async=""></script>
		<script src="/themes/simplebootx_wx/Public/js/share.js" async=""></script>

	</head>

	<body>
		<!--    <div ng-bind-html="hotel_basic_info.style_val | trustHtml"></div>-->

		<div id="style_val_h">
			<link href="/themes/simplebootx_wx/Public/css/style.css" rel="stylesheet">
		</div>
		
		<div class="header bg_color_blue1 " style="width: 100%; transform-origin: 0px 0px 0px; opacity: 1; transform: scale(1, 1);" id="div_top_bar">
			<i class="back lt "></i>
			<i class="menu rt"></i>
			<div class="title color_white1 f22 lt">酒店画报</div>
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
				#fixflo {
					padding-top: 50px;
				}
				
				#fixflo .content {
					width: 100%;
				}
				
				#fixflo .content_img {
					width: 100%;
				}
				
				#fixflo .content .content_title {
					width: 100%;
					height: 70px;
					margin: 0 auto;
					border-bottom: 0.5px solid #dfdfdd;
					text-align: center;
				}
				
				#fixflo .content .content_title h2 {
					margin-top: 14px;
					color: #000;
				}
				
				#fixflo .content div p {
					color: #000;
				}
				
				#fixflo .content_brief {
					width: 98%;
					margin: 0 auto;
					line-height: 1.6em;
				}
				
				#fixflo .content_brief h3 {
					margin: 20px 0 5px 0;
					color: #000;
				}
				
				#fixflo .content_brief img {
					width: 100%;
					margin: 10px auto;
				}
				
				.content_brief i {
					background: none
				}
				
				#fixflo .content_share {
					margin: 30px 5px;
				}
				
				#fixflo .io1 {
					width: 24px;
					height: 24px;
					float: left;
					margin-left: 5px;
					background: url("/webapp/images/share.png");
					background-size: 350px;
				}
				
				#fixflo .content_share .share1 {
					background-position: 0 0;
				}
				
				#fixflo .content_share .share2 {
					background-position: -24px 0;
				}
				
				#fixflo .content_share .share3 {
					background-position: -50px 0;
				}
				
				#fixflo .content_share .share4 {
					background-position: -76px 0;
				}
				
				#fixflo .content_share .share5 {
					background-position: -102px -2px;
				}
				
				#div_footer_item {
					display: none;
				}
				
				#imgsTil_all {
					width: 100%;
					height: auto;
					position: relative;
					overflow: hidden;
					word-break: break-all
				}
				
				#imgsTil_all .imgsTil {
					overflow: hidden;
				}
				
				#imgsTil_all .imgsTil .limgs {
					list-style-type: none;
					float: left;
					position: relative;
				}
				/*分享*/
				
				.shares {
					height: 34px;
					width: 100%;
					margin: 20px 0 15px;
				}
				
				.shares span {
					display: block;
					line-height: 34px;
					margin-right: 5px;
				}
				
				.shares li {
					text-indent: -9999px;
					width: 32px;
					float: left;
					margin-right: 5px;
					height: 34px;
					background-image: url(/themes/simplebootx_wx/Public/img/bg.png);
					background-size: 500px;
					background-position-y: -286px;
				}
				
				#share li.weixin {
					background-position-x: -7px;
				}
				
				#share li.qzone {
					background-position-x: -44px;
				}
				
				#share li.weibo {
					background-position-x: -8px;
					display: none;
				}
				
				#share li.xinlang {
					background-position-x: -79px;
				}
				
				#share li.douban {
					background-position-x: -153px;
				}
				
				#share li.renren {
					background-position-x: -116px;
				}
			</style>

			<div id="fixflo" class="centersss ng-scope">
				<div id="imgsTil_all" style="visibility: visible;">
					<div class="imgsTil" id="limgs" style="width: 100%; height: 1077px;">
						<!-- ngRepeat: dt in detailList -->
						<div class="imgsTil limgs ng-scope" on-finish-render-filters="" ng-repeat="dt in detailList" data-index="0" style="width: 100%; left: 0px; transition-duration: 0ms; transform: translate(0px, 0px) translateZ(0px);">
							<div class="content">
								<img class="content_img ng-isolate-scope" lazy-src="http://image.365zhiding.com/pubfile/2016/7/27/9/44/131140574863240000535867.jpg?iopcmd=thumbnail&amp;type=8&amp;width=640&amp;height=640|iopcmd=convert&amp;dst=jpg&amp;Q=70" src="http://image.365zhiding.com/pubfile/2016/7/27/9/44/131140574863240000535867.jpg?iopcmd=thumbnail&amp;type=8&amp;width=640&amp;height=640|iopcmd=convert&amp;dst=jpg&amp;Q=70" style="opacity: 1;">

								<div class="content_title">
									<h2 class="f22 color_gray1 ng-binding">巧媳妇洗涤</h2>

									<p class="f16 ng-binding"></p>
								</div>
							</div>
							<div class="content_brief">
								<div class="detai_j ng-binding" ng-bind-html="dt.detaildesc|trustHtml">
									<p style="text-align:center"><b><span style="font-family:宋体">巧媳妇专业洗涤简介</span></b></p>
									<p><b><span style="font-family:宋体">洗涤，专业品质</span></b></p>
									<p><span style="font-family:宋体">巧媳妇洗衣是保定电谷酒店打造的洗衣大平台，团队拥有</span><span>15</span><span style="font-family:宋体">年的洗衣管理经验，五星级酒店的服务品质。致力于为您打造一个便捷的洗衣流程，满足您更多样的洗涤需求，以及恒久不变的品质体验。我们的服务理念是：</span> <span style="font-family:宋体">巧媳妇呵护您的双手</span><span>&nbsp;&nbsp; </span><span style="font-family:宋体">托起绿色洗衣新概念</span></p>
									<p><b><span style="font-family:宋体">取送，快速安全</span></b></p>
									<p><span style="font-family:宋体">巧媳妇洗衣取送工作是交给社区里有固定住所的“取衣天使”来操作。他们可能就是您的街坊邻里，可以随时为您办理收取洗衣的服务，免去您的焦急等待。为您提供一份放心、踏实、亲切的服务！巧媳妇洗衣通过各种流程控制，保障衣物的高效取送和洗涤，为您打造更接地气的洗衣服务。</span></p>
									<p><span>&nbsp;</span></p>
									<p><b><span style="font-family:宋体">便宜，性价比高</span></b></p>
									<p><span style="font-family:宋体">五星级酒店的洗衣品质，亲民的洗涤价格，以及一应俱全的洗涤类别，方便您的生活更给您带来与众不同的服务体验。</span></p>
									<p><span>&nbsp;</span></p>
									<p><b><span style="font-family:宋体">送洗，方便快捷</span></b></p>
									<p><span style="font-family:宋体">巧媳妇洗衣除洗衣天使流动收送外，在电谷国际酒店一层也设有固定收发点，交通便利。普通衣物，</span><span>48</span><span style="font-family:宋体">小时可取。另外，我们还增设了四小时加急服务，只需收衣物的</span><span>50%</span><span style="font-family:宋体">加急费用。还可完全根据您的需要，为您量身定制专属的洗衣服务，在便捷的基础上更满足品质和服务的完美体验。</span></p>
									<p><br></p>
									<p style="text-align: center;"><b>客服电话：0312-8631888转52</b></p>
								</div>
							</div>
						</div>
						<!-- end ngRepeat: dt in detailList -->
					</div>
				</div>
				<div class="shares w98">

					<div class="lt" id="share">
						<ul>
							<li class="qzone" onclick="shareQzone('巧媳妇洗涤','http://hotelm.zhiding365.com/#/164844/hotelintro/Pictorialdetail?magazineid=180','','电谷国际酒店','undefined')" ;="">分享到qq空间</li>
							<li class="xinlang" onclick="shareTSina('巧媳妇洗涤','http://hotelm.zhiding365.com/#/164844/hotelintro/Pictorialdetail?magazineid=180','电谷国际酒店','undefined')" ;="">分享到新浪微博</li>
							<li class="weibo" onclick="shareToWb('巧媳妇洗涤','http://hotelm.zhiding365.com/#/164844/hotelintro/Pictorialdetail?magazineid=180','电谷国际酒店','undefined')" ;="">分享到腾讯微博</li>
							<li class="renren" onclick="shareRR('巧媳妇洗涤','http://hotelm.zhiding365.com/#/164844/hotelintro/Pictorialdetail?magazineid=180','电谷国际酒店','undefined')" ;="">分享到人人</li>
							<li class="douban" onclick="shareDouBan('巧媳妇洗涤','http://hotelm.zhiding365.com/#/164844/hotelintro/Pictorialdetail?magazineid=180','undefined')" ;="">分享到豆瓣</li>
						</ul>
					</div>
				</div>

			</div>
		</div>

		<p id="p_copyright" class="footer f14 ng-binding" style="transform-origin: 0px 0px 0px; opacity: 1; transform: scale(1, 1);">
			Copyright @2014-2015 电谷国际酒店<br> All Right Reseved 直订网 技术支持
		</p>
		<div class="mask"></div>
		<div id="div_ajax_start" style="position: fixed; z-index: 999999; text-align: center; width: 100%; height: 100%; top: 0; left: 0; -webkit-transform-origin: 0px 0px 0px; opacity: 1; -webkit-transform: scale(1, 1); background-color: rgba(0,0,0,0.6); display: none">
			<div style="background-color: #f5f1ee; padding: 20px 60px; top: 50%; border-radius: 15px; left: 50%; margin-left: -110px; margin-top: -70px; width: 220px; height: 140px; position: absolute; box-sizing: border-box;">

				<img src="/themes/simplebootx_wx/Public/img/loading.gif" style="width: 80%; display: block; margin-left: 10%;">
				<span class="f18" style="margin-top: -10px; color: #454545">努力加载中...</span>
			</div>
		</div>

		<div id="div_ajax_start1" style="display: none; position: fixed; z-index: 999999; text-align: center; width: 100%; height: 100%; top: 0px; left: 0px; transform-origin: 0px 0px 0px; opacity: 1; transform: scale(1, 1); background-color: rgb(245, 241, 238);">
			<div style="padding: 20px 60px; top: 50%; border-radius: 15px; left: 50%; width: 320px; margin-left: -160px; height: 150px; margin-top: -75px; position: absolute; box-sizing: border-box;">

				<img src="/themes/simplebootx_wx/Public/img/loading.gif" style="width: 78px; display: block; margin: 0 auto;">
				<span class="f18" style="margin-top: 5px; color: #454545">努力加载中...</span>
			</div>
		</div>
		<div id="resu" style="position: fixed; display: none; border-radius: 5px; background-color: rgba(0,0,0,0.8); height: 36px; line-height: 36px; top: 70%; margin-top: -18px; width: 70%; margin-left: 15%; text-align: center; color: #fff">
			支付失败
		</div>
		<script src="/themes/simplebootx_wx/Public/js/zepto.1.1.6.min.js?v=1.111"></script>
		<script src="/themes/simplebootx_wx/Public/js/jQuery.js"></script>
		<script src="/themes/simplebootx_wx/Public/js/fastclick.1.0.6.min.js"></script>
		<script src="/themes/simplebootx_wx/Public/js/calenda.js"></script>
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
		<script>
			var _hmt = _hmt || [];
			(function() {
				var hm = document.createElement("script");
				hm.src = "//hm.baidu.com/hm.js?f9aee954c7251b95c429cb15f68c4a8a";
				var s = document.getElementsByTagName("script")[0];
				s.parentNode.insertBefore(hm, s);
			})();
		</script>

	</body>

</html>