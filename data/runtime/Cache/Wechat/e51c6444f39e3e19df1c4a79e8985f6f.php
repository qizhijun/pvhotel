<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html class="ng-scope">

	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no, initial-scale=1">
		<meta content="telephone=no,email=no" name="format-detection">
		<title class="ng-binding">电谷国际酒店</title>
		<link href="/themes/simplebootx_wx/Public/css/all.css?v=4.77" rel="stylesheet">
		<link href="/themes/simplebootx_wx/Public/css/gong.css" rel="stylesheet">
	</head>

	<body>
		<div id="style_val_h">
			<link href="/themes/simplebootx_wx/Public/css/style.css" rel="stylesheet">
		</div>
		<div class="header bg_color_blue1 " style="width: 100%; display: block; transform-origin: 0px 0px 0px; opacity: 1; transform: scale(1, 1);" id="div_top_bar">
			<i class="back lt "></i>
			<i class="menu rt"></i>
			<div class="title color_white1 f22 lt">餐厅</div>
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
		<div id="main_main" class="ng-scope">
			<style class="ng-scope">
				.maincontent {
					padding-bottom: 65px;
				}
				
				.list .foodsingle .fodlt {
					width: 90px;
					height: 90px;
					margin-top: 5px;
				}
				
				.list .foodsingle> .lt img {
					width: 100%;
					display: inherit;
				}
				
				.list .foodsingle .rt_pl {
					width: 33%;
					margin-left: 5px;
				}
				
				.list .foodsingle .d_price {
					width: 106px;
				}
				/*calc(100% - 175px)*/
				
				.list .foodsingle {
					padding-bottom: 13px;
					box-sizing: border-box;
				}
				
				.list .foodsingle .info> .lt {
					width: 100%;
				}
				
				.list .foodsingle .info> .lt p {
					/*max-height: 24px;*/
					overflow: hidden;
				}
				
				.zjian {
					width: 100%;
					line-height: 23px;
					margin-top: 4px;
				}
				
				.zjian h3 {
					height: 28px;
				}
				
				.list {
					border-bottom-width: 1px;
				}
				
				.list .foodsingle .info> .rt {
					width: 46%;
				}
				
				.list .foodsingle .rt> .price {
					white-space: nowrap;
					text-align: right;
					line-height: 26px;
				}
				
				.list .foodsingle .rt> .tag2 {
					float: right;
					margin-top: 6px;
					text-align: center;
					line-height: 26px;
					width: 80px;
					height: 26px;
					border-radius: 5px;
				}
				
				.dj {
					text-align: center;
					height: 45px;
					line-height: 45px;
				}
				
				.list_cent {
					padding-top: 12px;
					padding-bottom: 12px;
					border-bottom-width: 1px;
				}
				
				.list_cent> .lt {
					width: 65px;
					height: 65px;
				}
				
				.list_cent> .lt> img {
					width: 100%;
				}
				
				.list_cent> .dc_c {
					width: 47%;
					margin-left: 2%;
				}
				
				.list_cent> .yd_diac {
					max-width: 30%;
					margin-left: 2%;
				}
				
				.list_cent:last-child {
					border-bottom-width: 0;
				}
				
				.maincontent {
					padding-top: 50px;
					width: 100%;
				}
				
				.er_mtop> .list_all {
					margin-top: 0px;
					margin-bottom: 10px;
				}
				
				.er_mtop> .list_all:first-child {
					margin-top: 0px;
					min-width: 300px;
				}
				
				.clear {
					clear: both;
					height: 0;
					width: 0;
				}
				
				.dc_xiao {
					float: right;
					margin-top: 4px;
					text-align: center;
					line-height: 26px;
					width: 80px;
					height: 26px;
					border-radius: 5px;
				}
				
				.ye_top {
					line-height: 26px;
					width: 100%;
					text-align: center;
				}
				
				.bjianyud {
					margin-top: 30px;
				}
				
				.prce_yd {
					text-align: right;
				}
			</style>

			<div class="er_mtop bg_color_gray2 maincontent ng-scope" style="min-height: 470px;">
				<div class="list_all bg_color_white1 ng-scope" data-tel="0312-8631620">
					<?php $arr = array( "1" => "1:00", "2" => "1:30", "3" => "2:00", "4" => "2:30", "5" => "3:00", "6" => "3:30", "7" => "4:00", "8" => "4:30", "9" => "5:00", "10" => "5:30", "11" => "6:00", "12" => "6:30", "13" => "7:00", "14" => "7:30", "15" => "8:00", "16" => "8:30", "17" => "9:00", "18" => "9:30", "19" => "10:00", "20" => "10:30", "21" => "11:00", "22" => "11:30", "23" => "12:00", "24" => "12:30", "25" => "13:00", "26" => "13:30", "27" => "14:00", "28" => "14:30", "29" => "15:00", "30" => "15:30", "31" => "16:00", "32" => "16:30", "33" => "17:00", "34" => "17:30", "35" => "18:00", "36" => "18:30", "37" => "19:00", "38" => "19:30", "39" => "20:00", "40" => "20:30", "41" => "21:00", "42" => "21:30", "43" => "22:00", "44" => "22:30", "45" => "23:00", "46" => "23:30", "47" => "00:00", "48" => "00:30", ); ?>
					<?php if(is_array($Restaurant)): foreach($Restaurant as $key=>$vo): $array = array( "breakfirst" => '早', "lunch" => '午', "afternoontea" => "下", "dinner" => "晚", "support" => "夜" ); $p = json_decode($vo['picurl'],true); $isbuffetres = json_decode($vo['isbuffetres'],true); $foodsend = json_decode($vo['foodsend'],true); ?>

						<div class="list border_color_gray1" style="padding-top: 8px;">
							<a href="<?php echo U('Restaurant/restaurant_details',array('id'=>$vo['id']));?>">
							<div class="w98" style="">
								<h3 class="color_black1 " style="height: 24px; line-height: 24px; margin-bottom: 2px;">
                    <span class="ng-binding"><?php echo ($vo["resname"]); ?></span><span class="f14 color_gray1 ng-binding ng-scope" >(<?php echo ($vo["name"]); ?>)</span>
                		</h3>
							</div>
							</a>
							<div class="foodsingle w98 border_color_gray1">

								<div class="lt fodlt">
									<a href="<?php echo U('Restaurant/restaurant_details',array('id'=>$vo['id']));?>">
										<img src="http://image.yijiudian.cn<?php echo sp_get_asset_upload_path($p['photo'][0]['url']);?>">
									</a>
								</div>
								<a href="<?php echo U('Restaurant/restaurant_details',array('id'=>$vo['id']));?>">
								<div class="lt rt_pl">
									<div class="info">
										<div class="lt color_gray1">
											<p class="f14 ng-binding" style="display: none"><span class="f14 color_blue1 ng-binding">5</span>分/0评论</p>
											<p ng-if="rst.business_hours1!=rst.business_hours2" class="ng-scope">
												营业:
												<span class="color_gray1 ng-binding ng-scope"><?php echo ($arr[$vo["businessbeg"]]); ?>-</span>
												<span class="color_gray1 ng-binding ng-scope"><?php echo ($arr[$vo['businessend']]); ?></span>

											</p>
											<p class="f14 ng-binding ng-scope">
												<?php if($isbuffetres['isdel'] == 1){ echo "自助"; $s = count($isbuffetres['list']); for($i=0;$i <$s;$i++){ echo '|'.$array[$isbuffetres[ 'list'][$i]]; } } ?>
											</p>
											<p class="f14 ng-binding ng-scope">
												<?php if($foodsend['level'] == 1){ echo "送餐"; $s = count($foodsend['foodsend']); for($i=0;$i <$s;$i++){ echo '|'.$array[$foodsend[ 'foodsend'][$i]]; } } ?>
											</p>
											<p class="f14 ng-binding ng-scope" style="height: 24px; white-space: nowrap; overflow: hidden">位于:<?php echo ($vo["resaddress"]); ?></p>
										</div>
										<div class="clear"></div>
									</div>
								</div>
								</a>
								<div class="rt d_price">
									<div class="rt pricets" style="line-height: 32px; width: 100%;">
										<!-- ngIf: rst.per_person>0 -->
										<p <?php if($vo['support_online'] == '-1'): ?>style="display:none;"<?php endif; ?> class="tag2 bg_color_yellow2 color_white1 f14 book" data-type="0">
											<?php if($phone): ?><a href="http://diangu.yijiudian.cn/Wechat/Room/restaurant_book?id=<?php echo ($vo['id']); ?>" style="color:#fff;">马上预订</a>
											<?php else: ?>
											<a href="<?php echo U('User/reg');?>" style="color:#fff;">马上预订</a><?php endif; ?>
										</p>
										<p class="tag2 bg_color_yellow1 color_white1 f14 tel" id="phote"><a href="tel:<?php echo ($vo["restel"]); ?>" style="color: #fff;">电话咨询</a></p>
									</div>
								</div>
								<div class="clear"></div>
							</div>
						</div><?php endforeach; endif; ?>
					<!--<div class="list_cent border_color_gray1 ng-scope" style="padding-left: 12px;">
						<div class="lt">
							<img src="http://img1.clding.com/pubfile/2015/9/23/18/44/130874786498509234143643.jpg">
						</div>
						<div class="lt dc_c">
							<div class="info">
								<div class="lt zjian">
									<h3 class="color_black2 f16">送餐</h3>
								</div>
								<div class="clear"></div>
							</div>
						</div>
						<div class="rt yd_diac">
							<div class="rt ye_top" style="padding-right: 12px;">
								<p class="tag1 bg_color_yellow2 dc_xiao color_white1 f14 book ng-scope" data-type="3">
									马上预订
								</p>
							</div>
						</div>
						<div class="clear"></div>
					</div>-->
				</div>
				<div class="dj bg_color_gray2 f16" style="display: none;">
					查看其它餐厅
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