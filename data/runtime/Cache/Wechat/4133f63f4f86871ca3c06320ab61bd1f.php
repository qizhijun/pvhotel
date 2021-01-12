<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html ng-app="HotelmApp" class="ng-scope">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no, initial-scale=1">
		<meta content="telephone=no,email=no" name="format-detection">
		<title ng-bind="hotel_basic_info.hname" class="ng-binding">电谷国际酒店</title>
		<!--<link href="/webapp/css/all.css?v=4.0" rel="stylesheet" />-->
		<link href="/themes/simplebootx_wx/Public/css/all.css?v=4.77" rel="stylesheet">
		<link href="/themes/simplebootx_wx/Public/css/gong.css" rel="stylesheet">
	</head>

	<body style="overflow: auto;">
		<div id="style_val_h">
			<link href="/themes/simplebootx_wx/Public/css/style.css" rel="stylesheet">
		</div>

		<div class="header bg_color_blue1 " style="width: 100%; display: block; transform-origin: 0px 0px 0px; opacity: 1; transform: scale(1, 1);" id="div_top_bar">
			<i class="back lt "></i>
			<i class="menu rt"></i>
			<div class="title color_white1 f22 lt">客房</div>
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
		<div id="main_main" class="ng-scope">
			<link href="/themes/simplebootx_wx/Public/css/room.css" rel="stylesheet" class="ng-scope">
			<div class="maincontent firstpage ng-scope" style="min-height: 470px;">
				<div class="hotelinfo w98">
					<div class="name">
						<span class="f22 hname color_black2 lt ng-binding"><?php echo ($infoArr["hotel_name"]); ?></span>
						<span class="share lt bg_color_blue1"><span class="circle"></span></span><i class="fav lt"></i>
						<div class="clear"></div>
					</div>
					<p class="info color_gray1">
						<span style="display: block; line-height: 15px; height: 15px;"><span class="f16 ng-binding"><?php echo ($infoArr["name"]); ?></span> <span class="f16 ng-binding" ng-show="hotelinfo.hopentime!=0">2008年开业</span></span>
						<span class="facilities">

                <i class="wifi fachide"></i>
                <i class="park"></i>
                <i class="res"></i>
                <i class="air fachide"></i>
                <i class="swim fachide"></i>
                <i class="sport"></i>
                <i class="pickup"></i></span>
						<span class="jiantou color_blue1 f16" onclick="pop_func(0)">酒店设施</span>
					</p>
				</div>

				<div class="dateselect border_color_gray1 w98">
					<div class="lt border_color_gray1">
						<p class="f16 color_black2">入住</p>
						<p class="date">
							<span class="f16 color_blue1">
                    		<em id="sdate"><?php echo ($time); ?></em>
                    		<em id="sdateW"><?php echo ($week); ?></em></span>
							<input type="hidden" value="<?php echo ($sdate); ?>" id="HDSDate">
							<input type="hidden" value="<?php echo ($time2); ?>" id="HDTIme">
						</p>
					</div>
					<div class="rt">
						<p class="f16 color_black2">离店</p>
						<p class="date">
							<span class="f16 color_blue1">
                    		<em id="edate"><?php echo ($time1); ?></em>
                    		<em id="edateW"><?php echo ($week1); ?></em>
                </span>
							<input type="hidden" value="<?php echo ($edate); ?>" id="HDEDate">
						</p>

					</div>
					<div class="clear"></div>
				</div>
				<a href="http://map.baidu.com/mobile/webapp/place/marker/qt=inf&vt=map&act=read_share&code=307/third_party=uri_api&point=12854601.33%7C4682216.65&title=%E7%94%B5%E8%B0%B7%E5%9B%BD%E9%99%85%E9%85%92%E5%BA%97&content=%E7%94%B5%E8%B0%B7%E5%9B%BD%E9%99%85%E9%85%92%E5%BA%97">
					<div class="map border_color_gray1 w98">
						<p>
							<span class="address color_black2 f16 ng-binding"><?php echo ($infoArr["hotel_address"]); ?></span>
							<span class="color_gray1 regional f14 ng-binding"></span>
							<span class="jiantou color_blue1 f16">看地图</span>

						</p>
					</div>
				</a>
				<a href="<?php echo U('Room/room_comment');?>">
					<div class="comment w98" ng-click="gocomment()">
						<p>
							<span class="color_black2 f16 ng-binding ng-hide">
	
	                <span class="color_blue1 ng-binding"></span>分/好评 差评0</span>
							<span class="color_black2 f16">
	
	                <span class="color_blue1 ">5</span>分/好评0 差评0</span>

							<span class="jiantou color_blue1 f16">看点评</span>
						</p>
					</div>
				</a>
				<div class="list border_color_gray1" id="roomlist">

					
				</div>
				<div class="border_color_gray1 nopage" style="border-top-width: 1px; height: 48px; line-height: 48px; text-align: center; display: none;">
					没有找到符合条件的房型信息，请选择其他日期重新查询
				</div>
				<div class="border_color_gray1 nopage1" style="border-top-width: 1px; height: 48px; line-height: 48px; text-align: center; display: none;">
					没有房型销售
				</div>
			</div>

			<div id="map" class="bg_color_white1 ng-scope">
				<div class="header bg_color_blue1">
					<i class="back lt "></i>
					<i class="menu rt" style="display: none"></i>
					<div class="title color_white1 f22 lt">酒店地图</div>
				</div>
				<div class="maincontent" style="min-height: 470px;">
					<iframe id="frame_map" style="width: 100%; border: 0"></iframe>
				</div>
			</div>

			<div id="facilites" class="bg_color_white1 ng-scope">
				<div class="header bg_color_blue1 ">
					<i class="back lt "></i>
					<i class="menu rt" style="display: none"></i>
					<div class="title color_white1 f22 lt">酒店设施</div>
				</div>
				<div id="facilites_main" style="height: 577px;">
					<div class="maincontent" style="min-height: 470px;">
						<div class="hotelinfo w98 ">
							<div class="name">
								<span class="f22 hname color_black2 lt ng-binding">电谷国际酒店</span>
								<span class="share lt bg_color_blue1"><span class="circle"></span></span><i class="fav lt"></i>
								<div class="clear"></div>
							</div>
							<p class="color_gray1">
								<span class="f16 ng-binding">五星/豪华酒店</span> <span class="f16 ng-binding">2008年开业</span>
							</p>
						</div>

						<div class="facilities  w98 border_color_gray1">
							<h3 class="title f18 color_black2">酒店设施</h3>
							<div id="faccontain">
								<div>
									<ul>
										<li class="">
											<i class="fac1"></i>
										</li>
										<li class="">
											<i class="fac2"></i>
										</li>
										<li class="">
											<i class="fac3"></i>
										</li>
										<li class="">
											<i class="fac4"></i>
										</li>
										<li class="">
											<i class="fac5"></i>
										</li>
										<li class="">
											<i class="fac6"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac11"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac12"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac13"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac14"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac15"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac16"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac18"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac20"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac22"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac24"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac27"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac28"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac29"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac30"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac33"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac217"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac37"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac38"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac40"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac47"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac48"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac49"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac50"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac53"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac55"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac59"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac60"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac8"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac61"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac62"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac63"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac64"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac65"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac66"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac70"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac72"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac73"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac74"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac75"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac83"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac85"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac86"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac87"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac89"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac90"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac91"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac94"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac96"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac97"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac99"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac101"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac102"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac103"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac104"></i>
										</li>
										<li class="fachide facitem">
											<i class="fac107"></i>
										</li>
									</ul>
									<span class="jiantou facmore" style="position:relative; padding-right:15px;">
                            			查看更多设施
                            		</span>
								</div>
							</div>
						</div>

						<div class="info w98 border_color_gray1">
							<h3 class="title f18 color_black2">酒店简介</h3>
							<div class="content color_gray1 ng-binding"></div>
						</div>

						<div class="w98 contact border_color_gray1" ng-click="tel()">
							<h3 class="title f18 color_black2 ng-binding" style="line-height: 30px;">联系电话：0312-8631888</h3>
						</div>
						<div class="info basicinfo color_gray1 w98 border_color_gray1">
							<h3 class="title f18 color_black2">基本信息</h3>
							<p><span class="ng-binding">豪华酒店</span></p>
							<p>
								<span class="ng-binding">2008年开业</span>
								<span class="ng-binding">2008年最后一次装修</span>
							</p>
							<p><span class="ng-binding">291间客房</span></p>
						</div>
					</div>
				</div>
			</div>

			<div id="yd_date" class="yd_date ng-scope">
				<div class="time">
					<div class="xgtimebox">
						<div class="title">
							<div class="bon  calender_return_btn">取消</div>
							<div class="center ">
								<i class="yd zjt" id="jian"></i>
								<span>您将入住<label id="numDayNew">1</label>晚 </span>
								<i class="yd yjt" id="jia"></i>
							</div>
							<div class="bon calender_ok_btn" id="wc">完成</div>
						</div>
						<div class="xgtime_nr" id="date_list">

						</div>
					</div>
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

		<script src="/themes/simplebootx_wx/Public/js/zepto.1.1.6.min.js?v=1.111"></script>
		<script src="/themes/simplebootx_wx/Public/js/jQuery.js"></script>
		<script src="/themes/simplebootx_wx/Public/js/fastclick.1.0.6.min.js"></script>
		<script src="/themes/simplebootx_wx/Public/js/calenda.js"></script>
		<script src="/themes/simplebootx_wx/Public/js/gong.js" type="text/javascript" charset="utf-8"></script>

		<script>
			var c = new Calendar(function(day1, day2) {
				window.Sdate = day1;
				window.Edate = day2;
				window.InitDate();
				console.log(day1);
				console.log(day2);
			});

			window.InitDate = function() {
				$("#sdate").html(window.Sdate.dateStr);
				$("#sdateW").html(window.Sdate.week);
				$("#HDSDate").val(window.Sdate.date);
				$("#edate").html(window.Edate.dateStr);
				$("#edateW").html(window.Edate.week);
				$("#HDEDate").val(window.Edate.date);
			}

			var xx = function() {
				var te = $(this).children();
				var target = $(this).prev();
				if(te.hasClass("fan")) {
					te.text("查看更多").removeClass("fan");
					target.animate({
						height: 84
					}, 200);
				} else {
					te.text("折叠起来").addClass("fan");

					var pH = target.children().height();
					target.animate({
						height: pH
					}, 200);
				}
			}

			var pop_func = function(val) {
				$("#facilites_main").scrollTop(0);
				if(val == 0) {
					blockpop = $("#facilites");
				} else {
					blockpop = $("#map");
				}
				blockpop.addClass("is-visible");
				//$("body").css({"overflow": "hidden","height":"100%"});
				$(".firstpage").css("position", "fixed");
				$("#div_top_bar").fadeOut(200);
				$(document).on("tap", "#facilites .back,#map .back", function() {
					fac_pop_func();
				});
			}

			var fac_pop_func = function() {
				blockpop.removeClass("is-visible");
				//$("body").removeAttr("style");
				$(".firstpage").css("position", "relative");
				$("#div_top_bar").fadeIn(200);
			};

			function imgAjax(id) {
				$.post("<?php echo U('Room/img_post');?>", {
					roomid: id
				}, function(data) {
					if(data.code == 0) {
						window.roominfo = data.data;
						// window.roominfo.max_room_num = window.rooms[ele.index()].max_room_num
						var area = parseInt(window.roominfo.room_area);
						window.roominfo.room_area = area == NaN ? 0 : area;
						window.roominfo.lowprice = $("#price" + id).html();
						$(".mask").fadeIn(200, function() {
							$(".maincontent").css("position", "fixed");
							showRoom(1);

							var target = $("#readmore").prev();
							var pH = target.children().height();
							if(pH > 84) {
								$("#readmore").children().text("查看更多").removeClass("fan");
								target.animate({
									height: 84
								}, 200);
							} else {
								target.css("height", "auto");
								$("#readmore").hide();
							}
							if(window.roominfo.facilities != null && window.roominfo.facilities.length > 0) {
								$(".roomfacilities").animate({
									height: 0
								}, 200);
								if($("#morefac").hasClass("fan"))
									$("#morefac").text("查看更多房型设施").removeClass("fan").show();
							} else
								$("#morefac").hide();
							$(".detailroom").animate({
								top: "50%"
							}, 100, function() {
								$("body").css("overflow", "hidden");
								$(".detailroom").find(".close").addClass("is-scaled-up");
							});
							var coun = $('.rooming ul').children().length;
							if(coun > 1) {
								var slider = Swipe($('.rooming'), {
									auto: 3000,
									continuous: true
								});
							}
							//$('.rooming ul').height($('.rooming ul').children().eq(0).height);
							$(document).on("tap", ".mask", function() {
								window.room_pop_func();
							});
						});
					}
				}, "json")
			}

			function tcAjax(cid, rid,paymenttype) {
				window.begintime = $("#HDSDate").val();
				window.endtime = $("#HDEDate").val();
				window.id = rid;
				window.paymenttype = paymenttype;
				window.price = $("#price" + rid).html();
				window.num = $("#prices" + rid).attr("data-num");
				window.rnum = $("#prices" + rid).attr("data-rnum");
				$.post("<?php echo U('Room/img_post');?>", {
					roomid: cid
				}, function(data) {
					if(data.code == 0) {
						window.roominfo = data.data;
						window.phone = data.phone;
						//window.roominfo.max_room_num = window.rooms[ele.index()].max_room_num
						var area = parseInt(window.roominfo.room_area);
						window.roominfo.room_area = area == NaN ? 0 : area;
						//window.roominfo.lowprice = ele.find(".rplist").find(".sellprice").eq(0).html();
						$(".mask").fadeIn(200, function() {
							$(".maincontent").css("position", "fixed");
							showRoom(0);

							var target = $("#readmore").prev();
							var pH = target.children().height();
							if(pH > 84) {
								$("#readmore").children().text("查看更多").removeClass("fan");
								target.animate({
									height: 84
								}, 200);
							} else {
								target.css("height", "auto");
								$("#readmore").hide();
							}
							if(window.roominfo.facilities != null && window.roominfo.facilities.length > 0) {
								$(".roomfacilities").animate({
									height: 0
								}, 200);
								if($("#morefac").hasClass("fan"))
									$("#morefac").text("查看更多房型设施").removeClass("fan").show();
							} else
								$("#morefac").hide();
							$(".detailroom").animate({
								top: "50%"
							}, 100, function() {
								$("body").css("overflow", "hidden");
								$(".detailroom").find(".close").addClass("is-scaled-up");
							});
							var coun = $('.rooming ul').children().length;
							if(coun > 1) {
								var slider = Swipe($('.rooming'), {
									auto: 3000,
									continuous: true
								});
							}
							//$('.rooming ul').height($('.rooming ul').children().eq(0).height);
							$(document).on("tap", ".mask", function() {
								window.room_pop_func();
							});
						});
					}
				}, "json")
			}
			var showRoom = function(t) {
				var cat = {
					1: "单人床",
					2: "双床",
					3: "大床"
				};
				var infodata = {
					"errcode": 0,
					"has_val": true,
					"result": {
						"hid": 164844,
						"hname": "电谷国际酒店",
						"hcity": "保定",
						"star": "五星/豪华酒店",
						"checkin": 10,
						"checkout": 14,
						"is_wifi": false,
						"is_inter": true,
						"is_carstop": true,
						"is_res": true,
						"is_chineseres": true,
						"is_westernres": true,
						"is_swim": false,
						"is_fitness": true,
						"is_airport": false,
						"is_bellman": true,
						"is_nosmoking": true,
						"hopentime": 2008,
						"address": "朝阳北大街1888号",
						"regional": "",
						"hdecorate": 2008,
						"comment": null,
						"introduction": "",
						"himg": "http://image.365zhiding.com/pubfile/2015/11/2/18/18/130909331036635345574965.jpg?iopcmd=thumbnail&type=8&width=640&height=360|iopcmd=convert&dst=jpg&Q=70",
						"htype": "豪华酒店",
						"lat": "38.913634",
						"lng": "115.473592",
						"htel": "0312-8631888",
						"rnum": 291,
						"maxday": "2016-08-08",
						"fac": [1, 2, 3, 4, 5, 6, 11, 12, 13, 14, 15, 16, 18, 20, 22, 24, 27, 28, 29, 30, 33, 217, 37, 38, 40, 47, 48, 49, 50, 53, 55, 59, 60, 8, 61, 62, 63, 64, 65, 66, 70, 72, 73, 74, 75, 83, 85, 86, 87, 89, 90, 91, 94, 96, 97, 99, 101, 102, 103, 104, 107]
					}
				};
				window.hotelinfo = infodata.result;
				console.log(window.roominfo);
				var tempdiv = $("<div class='detailroom'></div>").css({
					"height": th,
					"margin-top": -(th / 2),
					"top": -(th / 2) - 5
				});
				var tempclose = $('<h3 class="f22 color_black1 bg_color_white1">' + window.roominfo.room_name + '</h3>');
				tempclose.append($('<span class="close"></span>').on("click", function() {
					window.room_pop_func();
					//window.$apply();
				}));
				tempdiv.append(tempclose);
				var tempinfo = $(' <div class="roominfo bg_color_white1 color_gray1"></div>').height(th - 92);
				if(window.roominfo.pics['photo'][1]){
					var tempimg = '<img style="display:block;margin:auto;width:100%;" alt="" src="http://diangu.yijiudian.cn/data/upload/' + window.roominfo.pics['photo'][1]['url'] + '" >';
				}else{
					var tempimg = '<img style="display:block;margin:auto;" alt="" src="http://diangu.yijiudian.cn/data/upload/' + window.roominfo.pics['photo'][0]['url'] + '" >';
				}
				
				tempinfo.append("<div class='rooming'>" + tempimg + "<div>");
				tempinfo.append(' <p class="border_color_gray1 f20 w98" style="border-bottom-width: 1px; height: 40px; line-height: 38px;">优惠促销</p>');
				tempinfo.append('<div style="overflow: hidden" class="w98"><div>' + window.roominfo.descp + '</div></div><p class="w98" id="readmore"><span class="jiantou color_blue1 more f16">查看更多</span></p>');
				var tempmaininfo = $('<div class="maininfo border_color_gray1 w98" style="border-bottom-width: 1px; border-top-width: 1px; margin-top: 5px; padding-top: 5px; padding-bottom: 5px;"></div>');
				tempmaininfo.append('<p><i class="area"></i><span>面积</span>' + window.roominfo.room_area + '㎡</p>');
				tempmaininfo.append('<p><i class="peop"></i><span>可住</span>' + window.roominfo.imax_guestnum + '人</p>');
				tempmaininfo.append('<p><i class="bed"></i><span>床型</span>' + cat[window.roominfo.category_type] + '(' + window.roominfo.bed_size + '米)</p>');
				if(window.roominfo.floor)
					tempmaininfo.append('<p><i class="floor"></i><span>楼层</span>' + window.roominfo.floor + '</p>');
				if(window.roominfo.facilities != null) {
					var tempfac = $('<div></div>');
					var tempfacstr = '';
					for(var i = 0; i < window.roominfo.facilities.length; i++) {
						var fac = window.roominfo.facilities[i];
						tempfacstr += '<div><p class="border_color_gray1">' + fac.name + '</p>';
						for(var j = 0; j < fac.items.length; j++) {
							tempfacstr += '<p><span class="f16">' + fac.items[j] + '</span></p>';
						}
						tempfacstr += '</div>';
					}
					tempfac.append(tempfacstr);

					tempmaininfo.append($('<div></div>').addClass("roomfacilities").append(tempfac)).append($('<span class="jiantou color_blue1 more">查看更多房型设施</span>').on("click", function() {
						var te = $(this);
						var target = te.prev();
						if(te.hasClass("fan")) {
							te.text("查看更多房型设施").removeClass("fan");
							target.animate({
								height: 0
							}, 200);
						} else {
							te.text("折叠房型设施").addClass("fan");
							var pH = target.children().height();
							target.animate({
								height: pH
							}, 200);
						}
					}));
				}
				tempinfo.append(tempmaininfo).append($('<div  style="padding-bottom: 10px;" class="w98"></div>').append('<p style="height: 38px; line-height: 38px;"><i class="date"></i><span class="f20">入住和离店</span></p>').append('<p>入住时间：' + window.roominfo.earlieintime + ':00之后<br /> 离店时间：' + window.roominfo.lastouttime + ':00之前<br /><span class="color_blue1">详情请致电酒店(' + window.roominfo.hotel_tel + ')</span> </p>'));
				tempdiv.append(tempinfo);
				var tempnav = $('<div></div>').addClass("nav color_white1 bg_color_yellow1");
				if(t > 0) {
					tempnav.append('<span class="lt w98 ">' + window.roominfo.lowprice + '  起</span>');
				} else {
					tempnav.append('<span class="lt w98 ">' + window.price + '</span>');
					window.phone
					if(window.num < window.rnum)
					if(window.phone){
						tempnav.append($('<a style="color:#fff;" href="index.php?g=Wechat&m=Room&a=room_book&id=' + window.id + '&begintime=' + window.begintime + '&endtime=' + window.endtime + '&Zprice=' + window.price + '&paymenttype='+window.paymenttype+ '"><span class="rt bg_color_red1">马上预订</span></a>').on("click", function() {
							window.gotoorder(window.roominfo.room_id, window.roominfo.rateplan);
							window.$apply();
						}));
					}else{
						tempnav.append($('<a style="color:#fff;" href="index.php?g=Wechat&m=User&a=reg"><span class="rt bg_color_red1">马上预订</span></a>').on("click", function() {
							window.gotoorder(window.roominfo.room_id, window.roominfo.rateplan);
							window.$apply();
						}));
					}
						
					else
						tempnav.append('<span class="full bg_color_gray1 color_white1 rt">满房</span>');
				}
				tempdiv.append(tempnav);
				tempdiv.appendTo("body");
				//展开更多
				$("#readmore").on("tap", xx);
			}

			window.room_pop_func = function() {
				$(".maincontent").css("position", "relative");
				$(".detailroom").animate({
					top: -(th / 2) - 5
				}, 100, function() {
					$("body").removeAttr("style");
					$(".detailroom").remove();
					$(".mask").fadeOut(200);
					$("#readmore").off("tap", xx);
				});
			}

			window.isshow = false;
			var th;

			$(function() {
				th = $(window).height() * 0.8;

				FastClick.attach(document.body);
				//点击日期区块显示日期选择
				$(".dateselect").on("click", function(e) {
					var begintime = $("#HDSDate").val();
					var endtime = $("#HDEDate").val();
					var time2 = $("#HDTIme").val();
					c.init(begintime, endtime, time2);
					c.fDrawCal.showDialog();
				});

				//展开酒店设施的方法
				$(".facmore").on("click", function() {
					$(".facitem").toggleClass("fachide");
					window.isshow = !window.isshow;

				});

				//预订或加载房间详情
				var ele = $(this);

				$("#roomlist").on("tap", ".roomsingle", function(e) {
					var ele = $(this);
					var target = $(e.target);
					//显示房间详情
					if(target.hasClass("img") || target.parents(".img").length > 0) { //展开rp

							$(".mask").fadeIn(200, function() {
								$(".maincontent").css("position", "fixed");
								// showRoom(1);

								var target = $("#readmore").prev();
								var pH = target.children().height();
								if(pH > 84) {
									$("#readmore").children().text("查看更多").removeClass("fan");
									target.animate({
										height: 84
									}, 200);
								} else {
									target.css("height", "auto");
									$("#readmore").hide();
								}
								if(window.roominfo.facilities != null && window.roominfo.facilities.length > 0) {
									$(".roomfacilities").animate({
										height: 0
									}, 200);
									if($("#morefac").hasClass("fan"))
										$("#morefac").text("查看更多房型设施").removeClass("fan").show();
								} else
									$("#morefac").hide();
								$(".detailroom").animate({
									top: "50%"
								}, 100, function() {
									$("body").css("overflow", "hidden");
									$(".detailroom").find(".close").addClass("is-scaled-up");
								});
								var coun = $('.rooming ul').children().length;
								if(coun > 1) {
									var slider = Swipe($('.rooming'), {
										auto: 3000,
										continuous: true
									});
								}
								$(document).on("tap", ".mask", function() {
									window.room_pop_func();
								});
							});
					} else {
						$("#roomlist").find(".rateplanlist").hide()

						var jiantou;
						if(target.hasClass("roommain"))
							jiantou = target;
						else
							jiantou = target.parents(".roommain").find(".jiantou");
						if(jiantou.hasClass("open")) {
							$("#roomlist").find(".jiantou").removeClass("open");
							var item = ele.index();
							jiantou.removeClass("open");
							ele.find(".rateplanlist").hide();
						} else {
							$("#roomlist").find(".jiantou").removeClass("open");
							jiantou.addClass("open");
							if(ele.find(".rateplanlist").children().length - 1 > 3) {
								for(var i = 3; i < ele.find(".rateplanlist").children().length - 1; i++) {
									ele.find(".rateplanlist").children().eq(i).hide();
								}

								ele.find(".rateplanlist").children(".more").show();
							}
							ele.find(".rateplanlist").show();
						}
					}
				});

			});

			$(".dateselect").on("tap", function(e) {
				c.fDrawCal.showDialog();
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
		<script type="text/javascript">
			$(function() {
				$("#wc").on("click", function() {
					setTimeout(function() {
						var HDSDate = $("#HDSDate").val();
						var HDEDate = $("#HDEDate").val();
						$.post("<?php echo U('Room/roomajax');?>", {
							HDSDate: HDSDate,
							HDEDate: HDEDate
						}, function(data) {
							$("#roomlist").html(data);
						})
					}, 200);
				})
			})
			$(function() {
				//首次加载房型所有信息
				var HDSDate = $("#HDSDate").val();
				var HDEDate = $("#HDEDate").val();
				$.post("<?php echo U('Room/roomajax');?>", {
					HDSDate: HDSDate,
					HDEDate: HDEDate
				}, function(data) {
					$("#roomlist").html(data);
				})
			})
		</script>
	</body>

</html>