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
		<div id="style_val_h">
			<link href="/themes/simplebootx_wx/Public/css/style.css" rel="stylesheet">
		</div>
		<div class="header bg_color_blue1 " style="width: 100%; transform-origin: 0px 0px 0px; opacity: 1; transform: scale(1, 1);" id="div_top_bar">
			<i class="back lt " id="back"></i>
			<i class="menu rt"></i>
			<div class="title color_white1 f22 lt">餐厅订单填写</div>
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
			<link href="/themes/simplebootx_wx/Public/css/restaurant.css" rel="stylesheet">

			<div id="zd_herder" class="ng-scope">
				<div class="er_conter_cents  bg_color_white1 maincontent" on-finish-render-filter="">
					<ul>
						<li class="color_black2 w98">
							<lable class="er_o">预订餐厅</lable>
							<span id="r_name" style="color: #757575;" class="ng-binding"><?php echo ($Restaurant['resname']); ?></span>
							<input type="hidden" value="<?php echo ($Restaurant['businessbeg']); ?>" id="businessbeg">
							<input type="hidden" value="<?php echo ($Restaurant['businessend']); ?>" id="businessend">
						</li>
						<li class="tiem_li tt_time w98" id="time_some">
							<lable class="er_o lt">就餐时间</lable>
							<p class="dateselect" id="div_date">
								<span id="book_date_show" class="lt f16 color_blue1 date" style="margin-top: 3px;"></span>
								<input type="hidden" name="id" id="food_id" value="<?php echo ($Restaurant["id"]); ?>">
								<input type="hidden" id="book_date_val" class="ng-binding" value="">
							</p>
						</li>
						<li class="jcan w98" id="xz_cd">
							<label class="er_o ">就餐时段</label>
							<em id="eta">请选择就餐时段</em>
							<span class="jiantou jcsj"></span>
						</li>
						<li class="color_black2 aderss_li w98" id="pfor_of">
							<lable class="er_o ">就餐位置</lable>
							<span style="color: #757575;" class="zd_cuand">
                    <input class="f16" type="radio" name="tabVote" value="1" id="Thall"><label for="Thall">大厅</label>
                	</span>
                </span>
							<span class="zd_cuand ng-hide" style="color: rgb(117, 117, 117); display: none;">
	                    <input class="f16" type="radio" name="tabVote" value="2" id="Privateroom" data-value="">
	                    <label for="Privateroom">包间</label>
	                </span>

							<?php if($foodsend['level'] == '-1'): ?><span class="zd_cuand ng-hide" style="color: rgb(117, 117, 117); display: none;">
	                    <input class="f16" type="radio" name="tabVote" value="3" id="Tmeat"><label for="Tmeat">送餐</label>
	                	</span>
								<?php else: ?>
								<span class="zd_cuand" style="color: rgb(117, 117, 117); transform-origin: 0px 0px 0px; opacity: 1; transform: scale(1, 1);">
                    <input class="f16" type="radio" name="tabVote" value="3" id="Tmeat" ng-checked="typeid==3"><label for="Tmeat">送餐</label>
                	</span><?php endif; ?>
						</li>

						<li class="content_list_nor  jiantou w98 ng-hide cd_shijian" id="degree">
							<span class="lt color_black1">时间点</span>
							<input style="margin-left: 44px;" type="text" id="degreeval" placeholder="" value="00:00" class="f16 color_gray3 listitem_tip">
							<div class="clear"></div>
						</li>

						<li class="w98 ng-hide cd_shijian">
							<lable class="er_o lt">送餐地址</lable>
							<input type="text" class="inp f16" placeholder="请填写地址" name="Nums" id="roomid" value="">
						</li>

						<li class="Delivery_address f14 w98 ng-hide cd_shijian" style="height: auto;">
							<div class="color_black1" style="height: 35px;">温馨提示：</div>
							<div class="color_red1 f14">
								<div class="color_red1 wx">
									1. 不支持酒店外送餐
								</div>
								<div class="color_red1 wx ng-binding">
									2. 请在送餐前0个小时订餐
								</div>
								<div class="color_red1 wx ng-binding">
									3. 取消订餐请于送餐前0小时内在线取消或是电话取消，否则餐费不退！
								</div>
							</div>
						</li>

						<li class="bj_tt w98 ng-hide">
							<label class="er_o lt">选择包间</label>
						</li>

						<li class="bj_tt ng-hide" style="height: auto;">
							<ul class="er_bji" id="bjian_id">
							</ul>
							<div class="w98 ng-hide">
								<div class="color_black1 f14 " style="width: 80px; float: left;">
									温馨提示：
								</div>
								<div class="color_red1 yj f14" style="width: calc(100% - 85px); float: left; line-height: 23px; margin-top: 12px;">
									预订包间，需预付定金 ￥<span class="dj_yj">0</span>
								</div>
								<div class="clear"></div>
							</div>
						</li>
						<li class="w98">
							<lable class="er_o">就餐人数</lable>
							<input type="tel" class="inp f16 color_r" placeholder="请填写就餐人数" name="Nums" id="Numss" value="">
						</li>
						<li class="order w98">
							<lable class="er_o">我要点菜</lable>
							<span class="caim color_red1">您还未点菜</span>
							<span class="jiantou"></span>
						</li>
						<li class="w98">
							<lable class="er_o">联系人姓名</lable>
							<input type="text" class="inp f16 color_r" name="Nums" id="pep" placeholder="请输入联系人姓名" value="<?php echo ($truename['name']); ?>">
						</li>
						<li class="w98">
							<lable class="er_o">联系电话</lable>
							<input type="tel" class="inp f16 color_r" name="Nums" maxlength="11" id="txt_tel" placeholder="请输入联系电话" value="<?php echo ($phone); ?>">
						</li>
						<li class="w98  ng-hide">
							<lable class="er_o">验证码</lable>
							<span class="lt" style="padding-right: 40px; box-sizing: border-box; position: relative; width: 72%;">
                    <input type="tel" name="name" id="txtCode" maxlength="11" class="input f16 color_gray1" placeholder="请输入验证码">
                    <span class="yzm bg_color_blue1 color_white1" id="div_get_yzm">获取验证码</span>
							</span>
						</li>
						<li class="w98  f16" onclick="requireShow()">
							<lable class="er_o">特殊需求</lable>
							<span id="bz" style="white-space: nowrap; overflow: hidden; display: block; margin-right: 20px;">无</span><span class="jiantou"></span>
						</li>

						<li class="w98 border_color_gray1 f16 ng-hide" ng-click="showPoint()"><span class="lt color_black2">积分</span>
							<span class="rt jiantou">
                    <span id="point" style="white-space: nowrap; overflow: hidden; display: block; margin-right: 20px;"></span>
							</span>
						</li>
						<li class="w98 border_color_gray1 f16 ng-hide" ng-click="showCoupon()">
							<span class="lt color_black2">优惠券</span><span class="rt jiantou">
                    <em id="coupon"></em>
                </span>
						</li>
						<li class="w98">
							<lable class="er_o">电话确认</lable>
							<div class="rt anniu border_color_gray1 ">
								<div class="hasanniu">
									<div class="animate off">
										<input name="hdsure" id="hdsure" type="hidden" value="0">
										<span class="switch-left bg_color_gray1"></span>
										<label class="bg_color_white1">&nbsp;</label><span class="switch-right bg_color_blue1"></span>
									</div>
								</div>
							</div>
						</li>
						<!--<li class="w98" id="zd_faapiao" ng-click="showInv()">
							<lable class="er_o">发票</lable>

							<div class="rt jiantou " onclick="showInv()" style="width:70%;">
								<input type="text" id="invtitle" readonly="readonly" class="input  f16 color_gray1" placeholder="">
							</div>
						</li>-->

					</ul>
					<div class="er_fot f14 w98">
						<div class="lt color_black1">温馨提示：</div>
						<!-- ngIf: restaurantdetail.is_refund==1 -->
						<div class="color_red1  lt ng-binding ng-scope" style="width: 68%;">
							请提前24小时取消订单，退款比例为0%
						</div>

						<div class="clear"></div>
					</div>

					<div class="plays_bk f20 bg_color_yellow1 w98" style="padding-right: 0;position: fixed;">
						<div class="color_white1  lt er_alllt" id="zd-countm" style="display:none">
							<div style="width: 84px; float: left">总额：￥</div>
							<div class="pr_Coun">0</div>
						</div>
						<div class="color_white1 bg_color_red1 rt er_allrt" ng-click="Topay()" id="order">去确认</div>

						<div class="clear"></div>
					</div>
				</div>

				<div id="requirement" class=" bg_color_white1 Bombbox " style="display: none;">
					<ul class="w98" style="max-height: 501.6px;">
						<span class="ellipse bg_color_gray3">
                <span class="warm bg_color_white1"></span>
						</span>
						<p class="requireTip f16">
							如有特殊需求欢迎拨打电话咨询

							<span class="tel bg_color_blue1 color_white1 f18" id="Span1"><a href="tel:<?php echo ($Restaurant["restel"]); ?>" style="color: #fff;">拨打电话</a></span>
						</p>
						<ul id="reqList">

							<li style="height: auto">
								<div class="border_color_gray1" style="border-bottom-width: 1px">
									<div class="lt f16">其他需求</div>
									<div class="rt anniu border_color_gray1" data="next">
										<div class="hasanniu">
											<div class="animate off">
												<input name="bzelse" type="hidden" value="1">
												<span class="switch-left bg_color_gray1"></span>
												<label class="bg_color_white1">&nbsp;</label><span class="switch-right bg_color_blue1"></span>
											</div>
										</div>
									</div>
									<div class="clear"></div>
								</div>
								<div style="-webkit-transform-origin: 0px 0px 0px; opacity: 1; -webkit-transform: scale(1, 1); display: none; margin-top: 10px;">
									<textarea name="i" cols="30" rows="4" placeholder="备注" class="input border_color_gray1 color_gray1 f16" id="bzL"></textarea>
								</div>
							</li>
						</ul>
						<span class="btnsure bg_color_blue1 color_white1" onclick="requireOk(1)">确认</span>
						<span style="margin-left: 20px;" class="color_blue1" onclick="requireOk(0)">取消</span>
					</ul>
				</div>

				<div class="timeblock bg_color_white1 Bombbox" id="zd-cduan" style="display: none;">
					<h3 class="f20">请选择就餐时段</h3>
					<ul style="height: 180.5px; max-height: 409.6px;" id="cd_ys" data-foodsendsrv="">
						<?php if(is_array($dictArr)): foreach($dictArr as $key=>$vo): ?><li data="<?php echo ($vo["name"]); ?>" id="canduan" data-canduan="<?php echo ($vo["id"]); ?>" data-time="9"><?php echo ($vo["name"]); ?></li><?php endforeach; endif; ?>
						<li class="ng-hide">夜宵时间在23点之前</li>
					</ul>
				</div>
				<!--点菜--------------------------------------------------------------------------------------------------------------------------------------->
				<div id="facilites">
					<div class="header bg_color_blue1 " style="width: 100%" id="headers_t">
						<i class="back lt "></i>
						<i class=" rt"></i>
						<div class="title color_white1 f22 lt">点菜</div>
					</div>
					<div class="center_contentss maincontent" style="background-color: white;">
						<div id="left_list">
							<ul>
								<?php if(is_array($food)): foreach($food as $key=>$v): ?><li class="lrr ng-binding ng-scope current" id="1460" on-finish-render-filters=""><?php echo ($key); ?></li><?php endforeach; endif; ?>
							</ul>
						</div>
						<div id="right_list">
							<div class="right_list_top">
								<?php if(is_array($food)): foreach($food as $key=>$v): ?><!-- ngRepeat: fls in menutype -->
									<div ng-repeat="fls in menutype" class="zd-topp ng-scope" style="transform-origin: 0px 0px 0px; opacity: 1; transform: scale(1, 1);">
										<?php if(is_array($v)): foreach($v as $key=>$vo): ?><input type="hidden" name="id" id="img_id" value="<?php echo ($vo["id"]); ?>">
											<!-- ngRepeat: food in fls.foodlist -->
											<div class="right_list_container zd-foid ng-scope" data-breakfast="1" data-supper="1" data-midnight="5" data-dinner="1" data-afternoon="5">
												<div class="lt right_list_container_imgdiv">
													<img src="http://image.yijiudian.cn<?php echo ($vo['picurl']); ?>">
												</div>
												<div class="lt right_list_container_mid">
													<div class="f16 ng-binding" style="line-height: 14px;"><?php echo ($vo["foodname"]); ?></div>
													<!-- ngIf: food.food_maxschedulenum>0 -->
													<div style="width: 100%; margin-top: 31px;" class="ng-scope">
														<div class="right_list_container_textdiv" data-foodid="<?php echo ($vo["id"]); ?>">
															<p class="numctn" id="data-maxschedulenum" data-maxschedulenum="<?php echo ($vo["maxnum"]); ?>" data-price="<?php echo ($vo["price"]); ?>" data-yprice="<?php echo ($vo["price"]); ?>">
																<span class="rect Reduction">-</span>

																<span class="rect Numbs">0</span>
																<span class="rect plus">+</span>
															</p>
														</div>
													</div>
												</div>
												<div class="rt color_red1 right_list_container_pricediv f14 ng-scope" style="padding-top: 52px;" ng-if="!(restaurantdetail.cleveldiscount>0&amp;&amp;restaurantdetail.cleveldiscount<100)">
													<p style="text-align: right; margin-right: 3px;">
														￥<span class="price_y ng-binding"><?php echo ($vo["price"]); ?></span>
													</p>
												</div>

												<div class="clear"></div>
											</div><?php endforeach; endif; ?>
									</div><?php endforeach; endif; ?>
							</div>
							<div class="right_list_bottom" ng-show="menutype!=null">
								<div style="line-height: 36px;">
									<p class="lt">您共点了:<span>0</span>道菜</p>
									<p class="rt" id="right_list_bottom_total">
										共计: <span class="color_red1" id="right_list_price">0元</span>
									</p>
									<p class="clear"></p>
								</div>
								<div id="right_list_bottom_btn" class="bg_color_blue1 ">
									好了，就点这些
								</div>
								<div class="clear"></div>
							</div>
						</div>
					</div>
					<div class="dlgdishesdetial" on-finish-render-filters="">
						<div>
							<p class="dlgdishesdetial_cap ng-binding"></p>
							<p class="dlgdishesdetial_cal" ng-click="room_pop_func()">×</p>
						</div>
						<div id="imgsTil_all" style="visibility: visible;">
							<ul class="imgsTil">
							</ul>
						</div>
						<p class="dlgdishesdetial_nortext ng-binding" ng-click="gdo()">

						</p>
						<span class="dlgdishesdetial_etext">海鲜自助包含的服务</span>
						<ul>
							<li>酒水畅饮不限量</li>
							<li>大虾、扇贝......各种海鲜，随你造</li>
							<li>还有生日礼物哦!</li>
						</ul>
					</div>
				</div>

				<!--菜品详情--------------------------------------------------------------------------------------------------------------------------------------->
				<div id="fooddetail">
					<div class="header bg_color_blue1 " style="width: 100%">
						<i class="back lt "></i>
						<i class=" rt"></i>
						<div class="title color_white1 f22 lt">点菜</div>
					</div>
					<div class="center_contentss maincontent" style="background-color: white; padding-bottom: 68px;">
						<div class="w98" style="max-height: 100%; overflow: scroll" id="id_img">
							<img style="width: 100%; margin-top: 12px;" class="ng-scope">

							<div class="desc ng-binding" id="desc"></div>
						</div>
						<div class="foodfooter w98 border_color_gray1">

							<div style="float:left" class="color_red1  ng-binding ng-scope">
								￥<span id="data-price"></span>
							</div>
							<div style="float: right;">

								<p class="numctn" data-foodid="" data-maxschedulenum="" data-price="" data-yprice="" style="width: 80px; float: left" id="maxschedulenum">
									<span class="rect Reduction">-</span>
									<span class="rect Numbs" id="data-num">0</span>
									<span class="rect plus">+</span>
								</p>
								<span class="bg_color_yellow2 color_white1 f14" style="height: 26px; line-height: 26px; border-radius: 5px; display: block; width: 80px; text-align: center; float: right;" id="addfood">添加</span>
							</div>

						</div>
					</div>

				</div>

				<div id="pointblock" class="bg_color_white1 Bombbox " style="display: none;">
					<ul class="jf w98 color_gray2" style="max-height: 409.6px;">
						<div class="border_color_gray1">
							<span class="lt  ng-binding"><span class="color_black1">积分：</span>可用积分，抵元</span>

							<div class="clear"></div>
						</div>
						<div class="border_color_gray1" style="overflow: hidden">
							<div class="lt">
								<span class="color_black1 lt">使用：</span>
								<input type="tel" id="jfNum" class="border_color_gray1 lt color_black1 input  f16 ng-pristine ng-untouched ng-valid" style="padding-left: 2px;" placeholder="0" ng-model="point">
								<span class="lt">积分,抵<em class="ng-binding"></em>元</span>
							</div>
						</div>
						<div style="text-align: left">
							<span class="btnsure bg_color_blue1 color_white1" ng-click="pointOk(1)">确认</span>
							<span style="margin-left: 20px;" class="color_blue1" ng-click="pointOk(0)">取消</span>
						</div>
					</ul>
				</div>
				<div id="couponblock" class="bg_color_white1 Bombbox " style="display: none;">
					<ul class="coupon w98 color_gray2" style="max-height: 409.6px;">
						<div class="border_color_gray1" style="border-bottom-width: 1px; line-height: 42px;">
							<span class="lt  ng-binding"><span class="color_black1">优惠券：</span>可用张</span>
							<div class="rt  anniu border_color_gray1" data="next">
								<div class="hasanniu">
									<div class="animate off">
										<input name="hdcoupon" id="hdcoupon" type="hidden" value="0">
										<span class="switch-left bg_color_gray1"></span>
										<label class="bg_color_white1">&nbsp;</label><span class="switch-right bg_color_blue1"></span>
									</div>
								</div>
							</div>
							<div class="clear"></div>
						</div>

						<ul class="couponlist" style="display: none">

						</ul>
						<div style="text-align: left">
							<span class="btnsure bg_color_blue1 color_white1" ng-click="couponOk(1)">确认</span>
							<span style="margin-left: 20px;" class="color_blue1" ng-click="couponOk(0)">取消</span>
						</div>
					</ul>
				</div>
				<div id="invblock" class="bg_color_white1 Bombbox " style="display: none;">
					<ul class="jf w98 color_gray2" style="max-height: 409.6px;">
						<div class="border_color_gray1" style="border-bottom-width: 1px">
							<span class="lt " style="width: 100%;"><span class="color_black1">发票抬头：</span>
							<input type="text" id="invti" placeholder="请输入个人/单位名称"></span>

							<div class="clear"></div>
						</div>

						<div style="margin: 15px auto 10px;">
							<span class="btnsure bg_color_blue1 color_white1" onclick="invOk(1)">确认</span>
							<span style="margin-left: 20px;" class="color_blue1" onclick="invOk(0)">取消</span>
						</div>
					</ul>
				</div>

			</div>

			<div id="yd_date" class="yd_date">
				<div class="time">
					<div class="xgtimebox">
						<div class="title">
							<div class="bon  calender_return_btn">取消</div>
							<div class="center ">
								<i class="yd zjt" id="jian"></i>
								<span>
			                        请选择日期 </span>
								<i class="yd yjt" id="jia"></i>
							</div>
							<div class="bon calender_ok_btn" id = "wc">完成</div>
						</div>
						<div class="xgtime_nr" id="date_list">
						</div>
					</div>
				</div>
			</div>

		</div>
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
		<script src="/themes/simplebootx_wx/Public/js/fastclick.1.0.6.min.js"></script>
		<script src="/themes/simplebootx_wx/Public/js/calenda.js?v=4.1"></script>
		<script src="/themes/simplebootx_wx/Public/js/jQuery.js"></script>
		<script src="/themes/simplebootx_wx/Public/js/mobiscroll.custom-2.16.1.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/themes/simplebootx_wx/Public/js/gong.js" type="text/javascript" charset="utf-8"></script>
		<script>
			//字符串格式化 eg: var str = "I Love {0}, and You Love {1}!"; alert(a.format("You","Me"));
			String.prototype.format = function() {
					var args = arguments;
					return this.replace(/\{(d+)}/g,
						function(m, i) {
							return args[i];
						});
				}
				//判断是否是时间
			function checkDate(d) {
				var ds = d.match(/\d+/g),
					ts = ['getFullYear', 'getMonth', 'getDate'];

				var d = new Date(d.replace(/-/g, '/')),
					i = 3;

				ds[1]--;

				while(i--)
					if(ds[i] * 1 != d[ts[i]]()) return false;

				return true;

			}

			//防注入过滤
			function zhiding_stripscript(s) {
				var pattern = new RegExp("[%--`~!@#$^&*()=|{}':;',\\[\\].<>/?~！@#￥……&*（）——|{}【】‘；：”“'。，、？]")
				var rs = "";
				for(var i = 0; i < s.length; i++) {
					rs = rs + s.substr(i, 1).replace(pattern, '');
				}
				return rs;
			}

			//日期格式化扩展 eg: var d = Date.Now; console.log(d.format('yyyy-MM-dd'));console.log(d.format('yyyy-MM-dd hh点mm分ss秒SSS毫秒')
			Date.prototype.format = function(format) {
				var date = {
					"M+": this.getMonth() + 1,
					"d+": this.getDate(),
					"h+": this.getHours(),
					"m+": this.getMinutes(),
					"s+": this.getSeconds(),
					"q+": Math.floor((this.getMonth() + 3) / 3),
					"S+": this.getMilliseconds()
				};
				if(/(y+)/i.test(format)) {
					format = format.replace(RegExp.$1, (this.getFullYear() + '').substr(4 - RegExp.$1.length));
				}
				for(var k in date) {
					var prefix = "00";
					if(k == "S+") {
						prefix = "000";
					}
					if(new RegExp("(" + k + ")").test(format)) {
						format = format.replace(RegExp.$1, RegExp.$1.length == 1 ?
							date[k] : (prefix + date[k]).substr(("" + date[k]).length));
					}
				}
				return format;
			}

			Date.prototype.DateAdd = function(strInterval, Number) {
					var dtTmp = this;
					switch(strInterval) {
						case 's':
							return new Date(Date.parse(dtTmp) + (1000 * Number));
						case 'n':
							return new Date(Date.parse(dtTmp) + (60000 * Number));
						case 'h':
							return new Date(Date.parse(dtTmp) + (3600000 * Number));
						case 'd':
							return new Date(Date.parse(dtTmp) + (86400000 * Number));
						case 'w':
							return new Date(Date.parse(dtTmp) + ((86400000 * 7) * Number));
						case 'q':
							return new Date(dtTmp.getFullYear(), (dtTmp.getMonth()) + Number * 3, dtTmp.getDate(), dtTmp.getHours(), dtTmp.getMinutes(), dtTmp.getSeconds());
						case 'm':
							return new Date(dtTmp.getFullYear(), (dtTmp.getMonth()) + Number, dtTmp.getDate(), dtTmp.getHours(), dtTmp.getMinutes(), dtTmp.getSeconds());
						case 'y':
							return new Date((dtTmp.getFullYear() + Number), dtTmp.getMonth(), dtTmp.getDate(), dtTmp.getHours(), dtTmp.getMinutes(), dtTmp.getSeconds());
					}
				}
				//返回日期相差天数
			function zhiding_getDays(strDateStart, strDateEnd) {
				var strSeparator = "-"; //日期分隔符
				var oDate1;
				var oDate2;
				var iDays;
				oDate1 = strDateStart.split(strSeparator);
				oDate2 = strDateEnd.split(strSeparator);
				var strDateS = new Date(oDate1[0], oDate1[1] - 1, oDate1[2]);
				var strDateE = new Date(oDate2[0], oDate2[1] - 1, oDate2[2]);
				iDays = parseInt(Math.abs(strDateS - strDateE) / 1000 / 60 / 60 / 24) //把相差的毫秒数转换为天数 
				return iDays;
			}

			//手机号码验证
			function check_mobile(val) {
				var reg = /(^0{0,1}1[3|4|5|6|7|8|9][0-9]{9}$)/;
				if(!reg.test(val)) {
					return false;
				} else {
					return true;
				}
			}
			//邮箱名验证
			function check_mail(mail) {
				var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				if(filter.test(mail)) return true;
				else {
					return false;
				}
			}

			function check_chinname(val) {
				val = val.replace(/\s+/g, "");
				var reg = /^[\u4E00-\u9FA5]{2,20}$/;
				if(!reg.test(val)) {
					return false;
				} else {
					return true;
				}

			}

			function check_enname(val) {
				val = val.replace(/\s+/g, "");
				var reg = /^[a-zA-Z]{3,20}$/i;
				if(!reg.test(val)) {
					return false;
				} else {
					return true;
				}

			}

			function check_name(val) {
				val = val.replace(/\s+/g, "");
				if(!check_chinname(val)) {
					if(!check_enname(val)) {
						var regc = /[\u4E00-\u9FA5]{1,20}/;
						var rege = /[a-zA-Z]{1,20}/i;
						if(regc.test(val) && rege.test(val)) {
							return 0;
						} else {
							if(regc.test(val))
								return -1;
							else
								return -2;
						}
					}
					return 2;
				} else
					return 1;
			}

			var c = new Calendar(function(day1) {
				window.Sdate = day1.date;
				window.Sweek = day1.week;
				window.InitDate();
			});
			c.fDrawCal.fullHouseClick = function(date) {
				try {
					//满房计算
					var i = 0
					for(i; i < c.fullDate.length; i++) {
						if(date == c.fullDate[i]) {
							$("#maxOptional").remove();
							$("#wwei_dialog_p").remove();
							$("#dateInclude").remove();
							$("#fullHouseClick").remove();
							$("body").append('<p id="fullHouseClick" style="width:40%;height:100px;text-align:center;position: fixed;bottom:10%;left:30%;z-index: 99999;background:rgba(0,0,0,0.6);color:#ffffff;border-radius: 5px;word-break:break-all;"><span style="display: block;margin-top: 30px;">不可以预定，请重新选择！</span></p>');

							setTimeout(function() {
								temps = true;
								$("#fullHouseClick").remove();
							}, 2000);

							return false;
						}
					}
				} catch(e) {
					return;
				}
			}
			c.fDrawCal.onSelect = function(ev) {
				var el = ev.currentTarget;
				var date = $(el).attr('date-data');
				if(date != undefined) {
					var d_Date = new Date();
					var minsec;
					if(date) {
						minsec = Date.parse(date.replace("-", "/").replace("-", "/")) - Date.parse(d_Date);
					}
					if(c.fullDate) {
						if(c.fDrawCal.fullHouseClick(date) == false) {
							return;
						}
					}
					var _Count = minsec / 1000 / 60 / 60 / 24; //factor: second / minute / hour / day
					if(_Count < -1)
						return;
					else {
						c.fDrawCal.showDays(date);
					}
				} else
					return;
			}

			c.fDrawCal.showDays = function(date) {
				var e = c;
				$(".calendar_select_first").html(parseInt($(".calendar_select_first").html()));
				$(".calendar_select_second").html(parseInt($(".calendar_select_second").html()));
				$(".calendar_day").removeClass("calendar_select").removeClass("calendar_select_first").removeClass("calendar_select_second").removeClass("bg").removeClass("color");
				var strDate = e.getDateString(new Date(date));
				$('#calendar_cell_' + strDate).addClass("calendar_select").addClass("bg").addClass("color");

			}

			c.fDrawCal.onOK = function() {
				var orderday = $('.calendar_select');
				var e = c;
				e.fDrawCal.closeDialog(0);
				var date = orderday.attr('date-data');
				var day1 = {
					dateStr: e.getDateStringChin(date),
					week: e.getWeekDayString(date),
					date: e.getDateString(date)
				};
				window.Sdate = day1.date;
				window.Sweek = day1.week;
				window.InitDate();
			}

			c.fDrawCal.showDialog = function() {
				var e = c;
				e.fDrawCal.showDays(window.Sdate);
				$('#yd_date').show();
				$("#date_list").css("height", $(window).height() - 72);
				if(e.fullDate) {
					for(var i = 0; i < e.fullDate.length; i++) {
						var ele = $("#calendar_cell_" + e.fullDate[i]);
						if(ele.find("span").length == 0)
							ele.append("<span style='display:block;line-height:18px;color:red;'>不可订</span>").css("line-height", "18px");
					}
				}
			}

			//页面时间格式化显示
			window.InitDate = function() {
				$("#book_date_val").val(window.Sdate);
				$("#book_date_show").html(new Date(window.Sdate).format('yyyy年MM月dd日') + " (" + window.Sweek + ")");
			};

			$("#div_date").on("click", function() {
				c.fDrawCal.showDialog();
			})

			var timeblock = $(".timeblock");
			var requireblock = $("#requirement"),
				currblock, pointblock = $("#pointblock"),
				invblock = $("#invblock"),
				couponblock = $("#couponblock");
			var mask = $(".mask");

			var blockShow = function(fn) {
				mask.fadeIn(100, function() {
					$("body").css("overflow", "hidden");
					currblock.fadeIn(100, function() {
						currblock.animate({
							"margin-top": -currblock.height() / 2
						}, 200, function() {
							mask.on("click", blockHide);
						})
					});
					if(fn)
						fn();
				});
			}

			window.showInv = function() {
				currblock = invblock;
				blockShow();
			}

			window.requireShow = function() {
				currblock = requireblock;
				blockShow();
			}
			var blockHide = function() {
				currblock.animate({
					"margin-top": -1000
				}, 200, function() {
					currblock.fadeOut();
					mask.fadeOut(800, function() {
						$("body").removeAttr("style");
						mask.off("click", blockHide);
					});
				});
			}

			window.invOk = function(val) {
				if(val == 1) {
					$("#invtitle").val($("#invti").val());
				}
				blockHide();
			}

			window.requireOk = function(val) {
					if(val == 1) {
						var aaa = $("#bzL").val();
						$("#bz").html(aaa);
					}
					blockHide();
				}
				//点击浮层就餐时段
			var getot = function() {
				currblock = timeblock;
				blockShow(function() {
					timeblock.find("[data='" + $("#eta").text() + "']").addClass("selected color_blue1").siblings().removeClass("selected color_blue1");
				});
			}
			$(".timeblock").on("tap", "li", function() {

				var ele = $(this);
				var etah = ele.attr("data");
				$("#eta").text(etah);
				ele.addClass("selected color_blue1").siblings().removeClass("selected color_blue1");
				blockHide();
			});

			//展现菜品
			var fac_Dishes = function() {
					$("#facilites").addClass("is-visible");
					$(".er_conter_cents").css("position", "fixed");
					$("body").css({
						"overflow": "hidden",
						"height": "100%"
					});
					$("#div_top_bar").fadeOut(10);
				}
				//返回按钮,点完菜
			$("#facilites .back,#right_list_bottom_btn").on("click", function() {
				fac_pop_func();
			});

			///关闭点菜单
			var fac_pop_func = function() {

				if(counttt > 0) {
					$(".caim").removeClass("color_red1").html("您一共点了" + counttt + "道菜");
				} else {
					$(".caim").addClass("color_red1").html("您还未点菜");
				}

				$("#facilites").removeClass("is-visible");
				$(".er_conter_cents").css("position", "inherit");
				$("body").removeAttr("style");
				$("#div_top_bar").fadeIn(200);
//				var abcd = $("#right_list_price").html();
				var pr_Coun = $(".pr_Coun").html(window.Conpfoodvipprice);
				var  ggg = $(".pr_Coun").html();
				var ooo = ggg.replace("元","");
		        if(ooo < 1){
		        	$("#zd-countm").css("display","none");
		        }else{
		        	$("#zd-countm").css("display","block");
		        }
				//$scope.$apply();
			};

			///关闭菜品详情
			var detail_pop_func = function() {
				$("#fooddetail").removeClass("is-visible");
			};

			window.fooddetail = null;
			//window.restaurantdetail ={"resid":2050,"hid":164844,"res_name":"绿谷咖啡厅","default_imgurl":"130915933016480900409031_320w169.jpg","restel":"0312-8631683","resdes":"<p style="margin: 0 0 0;line-height: 25px"><strong><span style="font-family: 宋体">绿谷咖啡厅</span></strong><span>—打造保定自助头等舱</span></p><p><span style="font-size:14px;font-family:宋体">位于酒店一层，共有餐位</span><span style="font-size:14px;font-family:'Calibri','sans-serif'">150</span><span style="font-size:14px;font-family:宋体">个。以接待早、中、晚自助餐为主，并根据季节变化提供不同主题的自助餐，优美的环境及合理的膳食搭配总能够给客人留下美好的印象。另外，绿谷咖啡厅还可提供</span><span style="font-size:14px;font-family:'Calibri','sans-serif'">12</span><span style="font-size:14px;font-family:宋体">小时的送餐服务，让客人足不出户便可享受美味佳肴</span></p><p>温馨提示：线上支付预定可享受9折优惠。</p>","cuisine":[],"price":138.00,"buffet":null,"is_refund":1,"cleveldiscount":100,"supportpredetermined":9,"foodnum":1,"foodsendsrv":5,"issuportonlinemenue":0,"setmealmum":0,"isbuffetres":0,"breakfastname":null,"lunchname":null,"dinnername":null,"suppername":null,"groupon":null,"promotions":null,"maxlimit":"","comment_count":0,"comment_score":5,"is_buffetrestime":"1,2,4","is_buffetrestimename":"自助|早|午|晚","food_sendsrvtime":"","food_sendsrvtimename":"","res_type":1,"res_typename":"中餐厅","per_person":0.00,"res_adress":"酒店一层","business_hours1":"106","business_hours2":"21","advance_hours":0,"nocancel_hours":0,"hour1":24,"refund_proportion1":0,"issmoking":1,"levelname":"","is_suportonlineroom":0,"imgs":["http://image.365zhiding.com/pubfile/2015/11/9/14/2/130915225213958322410076.jpg?iopcmd=thumbnail&type=8&width=640&height=360|iopcmd=convert&dst=jpg&Q=70","http://image.365zhiding.com/pubfile/2015/11/10/9/41/130915933016480900409031.jpg?iopcmd=thumbnail&type=8&width=640&height=360|iopcmd=convert&dst=jpg&Q=70"]};
			var showdetail = function(foodid, num) {
				window.Conpfoodtempvipprice = window.Conpfoodvipprice;
				//餐厅详细
				//	            var restaurantdetail = "/api/v1/Restaurant/fooddetail?foodid=" + foodid + "&resid=" + resid;
				//	            $http.get(restaurantdetail).success(function (data) {
				//var data={"errcode":0,"has_val":true,"result":{"foodid":3163,"resid":0,"foodname":"自助套餐","menutypeid":1460,"isrecommend":0,"defaultimgurl":"http://image.365zhiding.com/pubfile/2016/2/5/11/27/130991164485780000808690.jpg?iopcmd=thumbnail&type=8&width=320&height=320|iopcmd=convert&dst=jpg&Q=70","foodvipprice":0.0,"foodoriginalprice":138.00,"food_maxschedulenum":5,"food_breakfast":1,"food_supper":1,"food_midnight":5,"food_dinner":1,"food_afternoontea":5,"desc":"<p><span style="font-size:14px;font-family:宋体">位于酒店一层，共有餐位</span><span style="font-size:14px;font-family:'Calibri','sans-serif'">150</span><span style="font-size:14px;font-family:宋体">个。以接待早、中、晚自助餐为主，并根据季节变化提供不同主题的自助餐，优美的环境及合理的膳食搭配总能够给客人留下美好的印象。另外，绿谷咖啡厅还可提供</span><span style="font-size:14px;font-family:'Calibri','sans-serif'">12</span><span style="font-size:14px;font-family:宋体">小时的送餐服务，让客人足不出户便可享受美味佳肴。</span><span style="font-size: 14px;font-family: Calibri, sans-serif"><br> <br> </span></p>"}};
				$.post("<?php echo U('Restaurant/restaurantdetail');?>",{foodid:foodid},function(data){
					if(data.code == 0) {
						$("#fooddetail .center_contentss").height(h - 118);
						window.fooddetail = data.data;
						//window.fooddetail.foodvipprice = Math.ceil(window.fooddetail.foodoriginalprice * (window.restaurantdetail.cleveldiscount > 0 && window.restaurantdetail.cleveldiscount < 100 ? window.restaurantdetail.cleveldiscount : 100) / 100);
						$("#fooddetail").addClass("is-visible");
						$("#fooddetail .numctn").children().eq(1).html(num);
						var img = '<img style="width: 100%; margin-top: 12px;" class="ng-scope" src='+data.data['picurl']+'> <div class="desc ng-binding">'+data.data['des']+'</div>';
						$("#id_img").html(img);
						if(num == 0){
							$("#data-price").html(data.data['price']);
						}else{
							var price = data.data['price'] * num;
							$("#data-price").html(price);
						}
						$("#maxschedulenum").attr("data-maxschedulenum",data.data['maxnum']);
						$("#maxschedulenum").attr("data-foodid",data.data['id']);
						$("#maxschedulenum").data("foodid",data.data['id']);
						$("#maxschedulenum").attr("data-price",data.data['price']);
						$("#maxschedulenum").attr("data-yprice",data.data['price']);
					}
				},"json")
				
				//		
				//		       	});
			}

			//更改点菜数量
			var changefoodnum = function(type, ele, temp) {
				temp = temp || false;
				var inputele = ele.children().eq(1);
				var nums = parseInt(inputele.html());
				var Maxnum = parseInt(ele.attr("data-maxschedulenum"));
				var foodvipprice = parseInt(ele.attr("data-price")); //单个会员价
				//var foodvipprice = getflaot(parseFloat($(this).parent().attr("data-price")), 1);
				var foodoriginalprice = parseInt(ele.attr("data-yprice")); //单个原价
				//var foodoriginalprice = getflaot(parseFloat($(this).parent().attr("data-yprice")), 1);
				if(type == 1) {
					if(nums > Maxnum - 1) {
						alert("最多可预订" + Maxnum + "份");
						return;
					} else {
						nums = nums + 1; //累加
					}
					if(temp) {
						window.Conpfoodtempvipprice = window.Conpfoodtempvipprice + foodvipprice;
					} else {
						window.Conpfoodvipprice = window.Conpfoodvipprice + foodvipprice;
						Conprice = Conprice + foodoriginalprice;
						Connums = Connums + 1;
						if(nums == 1)
							counttt = counttt + 1;
					}

				} else {
					if(nums > 0) {
						nums = nums - 1; // 
					} else {
						return;
					}
					if(temp) {
						window.Conpfoodtempvipprice = window.Conpfoodtempvipprice - foodvipprice;
					} else {
						window.Conpfoodvipprice = window.Conpfoodvipprice - foodvipprice;
						Conprice = Conprice - foodoriginalprice;
						Connums = Connums - 1;
						if(nums == 0)
							counttt = counttt - 1;
					}
				}
				inputele.html(nums);
				if(!temp) {
					$("#right_list .right_list_bottom p").eq(0).children().html(counttt);
					//$scope.Conpfoodvipprice = getflaot($scope.Conpfoodvipprice, 1);
					window.Conpfoodvipprice = parseInt(window.Conpfoodvipprice);
					//console.log(window.Conpfoodvipprice, $("#right_list .right_list_bottom p").eq(1).children().eq(0));
					$("#right_list .right_list_bottom p").eq(1).children().eq(0).html(window.Conpfoodvipprice + "元");
					$(".pr_Coun").html(window.Conpfoodvipprice);
				}
			}

			var h, w;
			//餐段赋值 
			var hous_t = 0; //时间点，送餐时用 
			var Connums = 0; //选择的菜品总和    
			var Conprice = 0; //原价总价   
			window.Conpfoodvipprice = window.Conpfoodtempvipprice = 0; //会员总价
			var nums = 0; //临时菜品数量   
			var counttt = 0; //菜的道数
			window.Conumbe = 0; //订单包间所需金额
			var resST = 0,
				resSTM = 0,
				resET = 24,
				resETM = 0;

			$(function() {
				h = $(window).height();
				w = $(window).width();

				FastClick.attach(document.body);

				//选择就餐时段
				$("#xz_cd").on("click", function() {
					getot();
				});
				var timeScroll;
				//初始化时间控件
				var _dd = new Date();
				window.Sdate = _dd.format('yyyy-MM-dd');
				window.Sweek = c.getWeekDayString(_dd);
				c.init(window.Sdate);
				window.InitDate();

				//点菜打开菜品页面
				$(".order").on("click", function() {
					var eat = $("#eta").text();
					if(eat == "请选择就餐时段") {
						alert("请先选择用餐时段")
						getot();
						return;
					}
					$(".center_contentss").height(h - 50);
					$("#right_list").height(h - 50);
					$(".center_contentss").css("overflow-y", "scroll");
					$("#right_list").css("overflow", "scroll");

					fac_Dishes();
					$("#left_list").find("li").eq(0).addClass("current").siblings().removeClass("current"); //菜品 
					$(".right_list_top").css({
						height: h - 128
					}).children().eq(0).show().siblings().hide();
				});
				//选择菜品栏目
				$("#left_list").on("click", " ul li", function() {
					var ele = $(this);
					ele.addClass("current").siblings().removeClass("current");
					$("#right_list .right_list_top").children().eq(ele.index()).show().siblings().hide();

				});
				//单个菜品增加数量
				$("#right_list .right_list_top").on("click", function(e) {
					var ele = $(e.target);
					if(ele.parents(".numctn").length > 0) {
						if(ele.hasClass("Reduction")) {
							changefoodnum(0, ele.parent());
						} else if(ele.hasClass("plus")) {
							changefoodnum(1, ele.parent());
						}
					} else {
						var par = ele.hasClass("zd-foid") ? ele : ele.parents(".zd-foid");
						var food = par.find(".numctn").eq(0);
						showdetail(parseInt(food.parent().data("foodid")), parseInt(food.children().eq(1).html()));
					}

				});

				$("#fooddetail .back,#addfood").on("click", function(e) {
					
					var ele = $(e.target);
					if(ele.attr("id") == "addfood") {
						var foodid = ele.prev().data("foodid");
						var elefind = $("#right_list .right_list_top").find("[data-foodid='" + foodid + "']");
						var num = ele.prev().children().eq(1).html();
						var uynum = elefind.children().children().eq(1).html();
						if(num == 0) {
							if(uynum > 0)
								counttt = counttt - 1;
						} else {
							if(uynum == 0)
								counttt = counttt + 1;
						}
						elefind.children().children().eq(1).html(num);

						window.Conpfoodvipprice = window.Conpfoodtempvipprice;
						
						$("#right_list .right_list_bottom p").eq(0).children().html(counttt);
						//$scope.Conpfoodvipprice = getflaot($scope.Conpfoodvipprice, 1);
						window.Conpfoodvipprice = parseInt(window.Conpfoodvipprice);
						$("#right_list .right_list_bottom p").eq(1).children().eq(0).html(window.Conpfoodvipprice + "元");
					}
					detail_pop_func();
				});
				$("#fooddetail .numctn").on("click", function(e) {
					var ele = $(e.target);
					if(ele.parents(".numctn").length > 0) {
						if(ele.hasClass("Reduction")) {
							changefoodnum(0, ele.parent(), true);
						} else if(ele.hasClass("plus")) {
							changefoodnum(1, ele.parent(), true);
						}
					}
				});

				$(".maincontent,#requirement,.Bombbox").on("click swipe", ".anniu", function() {
					var ele = $(this);
					var divE = $(this).children().children();
					if(divE.hasClass("on")) {
						divE.removeClass("on").addClass("off");
					} else {
						divE.removeClass("off").addClass("on");
					}

					if(ele.attr("data") == "next") {

						if(parseInt(divE.children().eq(0).val()) >= 0) {
							if(ele.parent().next().css("display") == "none") {
								divE.children().eq(0).val(1);
								ele.parent().next().show();
							} else {
								divE.children().eq(0).val(0);
								ele.parent().next().hide();
							}
						}

					} else {
						if(ele.parents("#reqList").length == 0) {
							{
								if(parseInt(divE.children().eq(0).val()) >= 0) {
									if(divE.children().eq(0).val() == 0) {
										divE.children().eq(0).val(1);
									} else {
										divE.children().eq(0).val(0);
									}
								}
							}
						}

					}
				});

			});
			
			
			 $("#pfor_of").on("click", " .zd_cuand", function () {
	            var vules = $(this).find("input[name=tabVote]").val();
	            
	            if(vules == 3){
	            	var Hous_h = new Array();
			        var hs = "";
			
			        var Min_h = new Array();
			        var ms = "";
	            	$(".cd_shijian").removeClass("ng-hide");
	            	var businessbeg = $("#businessbeg").val();
	            	var businessend = $("#businessend").val();
	            	var mycars=new Array();
	            	mycars[1] = "1";
	            	mycars[2] = "1点半";
	            	mycars[3] = "2";
	            	mycars[4] = "2点半";
	            	mycars[5] = "3";
	            	mycars[6] = "3点半";
	            	mycars[7] = "4";
	            	mycars[8] = "4点半";
	            	mycars[9] = "5";
	            	mycars[10] = "5点半";
	            	mycars[11] = "6";
	            	mycars[12] = "6点半";
	            	mycars[13] = "7";
	            	mycars[14] = "7点半";
	            	mycars[15] = "8";
	            	mycars[16] = "8点半";
	            	mycars[17] = "9";
	            	mycars[18] = "9点半";
	            	mycars[19] = "10";
	            	mycars[20] = "10点半";
	            	mycars[21] = "11";
	            	mycars[22] = "11点半";
	            	mycars[23] = "12";
	            	mycars[24] = "12点半";
	            	mycars[25] = "13";
	            	mycars[26] = "13点半";
	            	mycars[27] = "14";
	            	mycars[28] = "14点半";
	            	mycars[29] = "15";
	            	mycars[30] = "15点半";
	            	mycars[31] = "16";
	            	mycars[32] = "16点半";
	            	mycars[33] = "17";
	            	mycars[34] = "17点半";
	            	mycars[35] = "18";
	            	mycars[36] = "18点半";
	            	mycars[37] = "19";
	            	mycars[38] = "19点半";
	            	mycars[39] = "20";
	            	mycars[40] = "20点半";
	            	mycars[41] = "21";
	            	mycars[42] = "21点半";
	            	mycars[43] = "22";
	            	mycars[44] = "22点半";
	            	mycars[45] = "23";
	            	mycars[46] = "23点半";
	            	mycars[47] = "0";
	            	mycars[48] = "0点半";
	            	
	            	if (businessbeg%2 == 0) {
	                    resST = mycars[businessbeg - 1];
	                    resSTM = 30;
	                }
	                else
	                    resST = parseInt(mycars[businessbeg]);
	                	resST = resST == 24 ? 0 : resST;
	
	                if (businessend%2 == 0) {
	                    resET = mycars[businessend - 1];
	                    resETM = 30;
	                }
	                else
	                    resET = mycars[businessend];
						
	                resET = resET == 24 ? 0 : resET;
	                if (parseInt(resET) < parseInt(resST)) {
	                    var leng_h = resST - resET - 1;
	                    for (var i = 0; i <= 24 - (resST - resET) ; i++) {
	                        if (i <= resET) {
	                            if (i < 10) {
	                                hs = "0" + i;
	                            } else {
	                                hs = i;
	                            }
	                        } else {
	                            if (i + leng_h < 10) {
	                                hs = "0" + parseInt(i + leng_h);
	                            } else {
	                                hs = parseInt(i + leng_h);
	                            }
	                        }
	                        Hous_h.push(hs);
	                    }
	
	                    for (var j = 0 ; j < 60; j++) {
	                        if (j < 10) {
	                            ms = "0" + j;
	                        } else {
	                            ms = j;
	                        }
	                        Min_h.push(ms);
	                    }
	
	                } else if (resET == resST) {
	                    for (var i = resST; i <= 23; i++) {
	                        if (i < 10) {
	                            hs = "0" + i;
	                        } else {
	                            hs = i;
	                        }
	                        Hous_h.push(hs);
	                    }
	
	                    for (var j = 0 ; j < 60; j++) {
	                        if (j < 10) {
	                            ms = "0" + j;
	                        } else {
	                            ms = j;
	                        }
	                        Min_h.push(ms);
	                    }
	                    
	                } else {
	                    for (var i = resST; i <= resET; i++) {
	                        if (i < 10) {
	                            hs = "0" + i;
	                        } else {
	                            hs = i;
	                        }
	                        Hous_h.push(hs);
	                    }
	
	                    for (var j = resSTM ; j < 60; j++) {
	                        if (j < 10) {
	                            ms = "0" + j;
	                        } else {
	                            ms = j;
	                        }
	                        Min_h.push(ms);
	                    }
	                }
	                timeScroll = $('#degree').mobiscroll({
                    mode: "scroller",
                    display: "modal",
                    lang: "zh",
                    headerText: "时间点",
                    dateFormat: 'hh:mm',
                    minWidth: 80,
                    wheels: [
                         [{ keys: Hous_h, values: Hous_h }]
                         , [{ keys: Min_h, values: Min_h }] //label: 'Label 1',
                    ],onChange: function (valueText, inst) {
                        var value = valueText.split(" ");
                        Min_h = [];
                        if (parseInt(value[0]) == resET) {
                            for (var j = 0 ; j <= resETM; j++) {
                                if (j < 10) {
                                    ms = "0" + j;
                                } else {
                                    ms = j;
                                }
                                Min_h.push(ms);
                            }

                            inst.settings.wheels[1][0].values = Min_h;
                            inst.settings.wheels[1][0].keys = Min_h;
                        } else if (value[0] == resST) {
                            for (var j = resSTM ; j < 60; j++) {
                                if (j < 10) {
                                    ms = "0" + j;
                                } else {
                                    ms = j;
                                }
                                Min_h.push(ms);
                            }
                            inst.settings.wheels[1][0].values = Min_h;
                            inst.settings.wheels[1][0].keys = Min_h;
                        }
                        else {
                            for (var j = 0 ; j < 60; j++) {
                                if (j < 10) {
                                    ms = "0" + j;
                                } else {
                                    ms = j;
                                }
                                Min_h.push(ms);
                            }
                            inst.settings.wheels[1][0].values = Min_h;
                            inst.settings.wheels[1][0].keys = Min_h;
                        }
                        timeScroll.mobiscroll('changeWheel', [0, 1], 0);
                    }
                    , onSelect: function (valueText) {
                        var h = valueText.substring(0, 2);
                        var m = valueText.substring(3, 5);
                        $('#degreeval').val(h + ":" + m);
                        hous_t = h + ":" + m;
                    }
                });
                if (resST < 10) {
                    if (resSTM < 10)
                        $("#degreeval").val("0" + resST + ":" + "0" + resSTM);
                    else
                        $("#degreeval").val("0" + resST + ":" + resSTM);
                } else {
                    if (resSTM < 10)
                        $("#degreeval").val(resST + ":" + "0" + resSTM);
                    else
                        $("#degreeval").val(resST + ":" + resSTM);
                }
	            }else{
	            	$(".cd_shijian").addClass("ng-hide");
	            }
	        });
	        
	        
	       
                

			$("#back").on("click", function() {
					if(confirm("您的订单未填写完成，是否确定要离开当前页面？")) {
						window.location.href = "index.php?g=Wechat&m=Restaurant&a=restaurant";
					} else {
						return false;
					}
				})
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
			$("#order").on("click",function(){
				var foodNum = "";//菜品数量集合
	            var CoFoodid = "";//菜品id集合
	            $("#right_list .right_list_top .right_list_container_mid .right_list_container_textdiv").each(function () {
	                var numbs = parseInt($(this).children().find(".Numbs").html());
	                if (numbs > 0) {
	                    foodNum = foodNum + numbs + ",";
	                    CoFoodid = CoFoodid + $(this).attr("data-foodid") + ",";
	                }
	            });
				var ctid = $("#food_id").val();
				var ctime = $("#book_date_val").val();
				var cdname = $("#eta").html();
				if(cdname == "早餐"){
					var cdid = 1;
				}
				if(cdname == "午餐"){
					var cdid = 2;
				}
				if(cdname == "晚餐"){
					var cdid = 4;
				}
				var jcaddress = $('#pfor_of input[name="tabVote"]:checked ').val();
				var degreeval = $("#degreeval").val();
				var address = $("#roomid").val();
				var Numss = $("#Numss").val();
				var dishes = $(".caim").html();
				var pep = $("#pep").val();
				var tel = $("#txt_tel").val();
				var bz = $("#bz").html();
				var hdsure = $("#hdsure").val();
				if(pep == "" || tel== "" || dishes == "您还未点菜"){
					alert("电话、联系人、我要点菜不能为空！");
					return false;
				}
				if(jcaddress == '3'){
					if(address== "" || degreeval == ""){
						alert("时间点、送餐地址不能为空！");
					}
					return false;
				}
				$.post("<?php echo U('Restaurant/orderPay');?>",{foodNum:foodNum,CoFoodid:CoFoodid,ctid:ctid,ctime:ctime,cdid:cdid,jcaddress:jcaddress,degreeval:degreeval,address:address,Numss:Numss,dishes:dishes,pep:pep,tel:tel,bz:bz,hdsure:hdsure},function(data){
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
										window.location.href = "http://diangu.yijiudian.cn/Wechat/Room/cyorderlist?id='"+data.id+"'&ctime="+data.ctime;
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
		<script>
			$("#wc").on("click",function(){
				setTimeout(function() {
					var jctime = $("#book_date_val").val();
					var tbody = "";
					$.post("<?php echo U('Restaurant/jctime');?>",{jctime:jctime},function(data){
						if(data.success){
							var obj = data.message;
							$.each(obj,function(n,value) {   
					            var trs = "";  
					            
					            trs += '<li data="'+value.name+'" id="canduan" data-canduan="'+value.id+'" data-time="9">'+value.name+'</li>';
					            tbody += trs;         
					        });  
					        $("#cd_ys").html(tbody);  
						}
					},"json")
				}, 200);
			})
		</script>
		</body>
</html>