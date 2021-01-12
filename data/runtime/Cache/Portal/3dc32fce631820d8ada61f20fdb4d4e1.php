<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<title><?php echo ($site_seo_title); ?> <?php echo ($site_name); ?></title>
		<meta name="keywords" content="<?php echo ($site_seo_keywords); ?>" />
		<meta name="description" content="<?php echo ($site_seo_description); ?>">
			<?php  function _sp_helloworld(){ echo "hello ThinkCMF!"; } function _sp_helloworld2(){ echo "hello ThinkCMF2!"; } function _sp_helloworld3(){ echo "hello ThinkCMF3!"; } ?>
	<?php $portal_index_lastnews="2"; $portal_hot_articles="1"; $portal_last_post="1,2"; $tmpl=sp_get_theme_path(); $default_home_slides=array( array( "slide_name"=>"E酒店发布啦！", "slide_pic"=>$tmpl."Public/images/demo/1.jpg", "slide_url"=>"", ), array( "slide_name"=>"E酒店发布啦！", "slide_pic"=>$tmpl."Public/images/demo/2.jpg", "slide_url"=>"", ), array( "slide_name"=>"E酒店发布啦！", "slide_pic"=>$tmpl."Public/images/demo/3.jpg", "slide_url"=>"", ), ); ?>
	<meta name="author" content="ThinkCMF">
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    
    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">

   	<!-- No Baidu Siteapp-->
    <meta http-equiv="Cache-Control" content="no-siteapp"/>

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->
	<link rel="icon" href="/themes/simplebootx/Public/images/favicon.ico" type="image/x-icon">
	<link rel="shortcut icon" href="/themes/simplebootx/Public/images/favicon.ico" type="image/x-icon">
    <link href="/themes/simplebootx/Public/simpleboot/themes/simplebootx/theme.min.css" rel="stylesheet">
    <link href="/themes/simplebootx/Public/simpleboot/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="/themes/simplebootx/Public/simpleboot/font-awesome/4.4.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
	<!--[if IE 7]>
	<link rel="stylesheet" href="/themes/simplebootx/Public/simpleboot/font-awesome/4.4.0/css/font-awesome-ie7.min.css">
	<![endif]-->
	<link href="/themes/simplebootx/Public/css/style.css" rel="stylesheet">
	<style>
		/*html{filter:progid:DXImageTransform.Microsoft.BasicImage(grayscale=1);-webkit-filter: grayscale(1);}*/
		#backtotop{position: fixed;bottom: 50px;right:20px;display: none;cursor: pointer;font-size: 50px;z-index: 9999;}
		#backtotop:hover{color:#333}
		#main-menu-user li.user{display: none}
	</style>
	
		<!--link href='http://fonts.useso.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'-->
		<link rel="stylesheet" href="/themes/simplebootx/Public/css/jquery-ui.css" />
		<link href="/themes/simplebootx/Public/css/slippry/slippry.css" rel="stylesheet">
		<link href="/themes/simplebootx/Public/css/hotel.css" rel="stylesheet">
		
		<link type="text/css" rel="stylesheet" href="/themes/simplebootx/Public/css/JFFormStyle-1.css" />

		<link href="/themes/simplebootx/Public/js/yd/laydate/need/laydate.css" rel="stylesheet" />
		<link href="/themes/simplebootx/Public/js/yd/laydate/skins/molv/laydate.css" rel="stylesheet" />
		<script type="text/javascript" src="/themes/simplebootx/Public/js/yd/jquery/jquery.js"></script>
		<script type="text/javascript" src="/themes/simplebootx/Public/js/yd/common/base.js?v001"></script>
		<script src="/themes/simplebootx/Public/js/yd/laydate/laydate.js"></script>
		<script src="/themes/simplebootx/Public/js/yd/webscript/hotel/hotelcalendar.js?v=006"></script>
		<style>
			.caption-wraper {
				position: absolute;
				left: 50%;
				bottom: 2em;
			}
			.caption-wraper .caption {
				position: relative;
				left: -50%;
				background-color: rgba(0, 0, 0, 0.54);
				padding: 0.4em 1em;
				color: #fff;
				-webkit-border-radius: 1.2em;
				-moz-border-radius: 1.2em;
				-ms-border-radius: 1.2em;
				-o-border-radius: 1.2em;
				border-radius: 1.2em;
			}
			
			@media (max-width: 767px) {
				.sy-box {
					margin: 12px -20px 0 -20px;
				}
				.caption-wraper {
					left: 0;
					bottom: 0.4em;
				}
				.caption-wraper .caption {
					left: 0;
					padding: 0.2em 0.4em;
					font-size: 0.92em;
					-webkit-border-radius: 0;
					-moz-border-radius: 0;
					-ms-border-radius: 0;
					-o-border-radius: 0;
					border-radius: 0;
				}
			}
			table{
				background: rgba(16, 37, 60, 1);
			}
			select{
				height: auto !important;
			}
			.ui-datepicker-title{
				color:#fff;
			}
			#reserve{
				text-transform:capitalize;
				width: 100% !important;
				background: #32A2E3;
				/*font-family: 'Open Sans', sans-serif;*/
				color: #FFF;
				padding: 8px;
				border: none;
				font-size: 1em;
				transition: 0.5s all;
				-webkit-transition: 0.5s all;
				-moz-transition: 0.5s all;
				-o-transition: 0.5s all;
				outline: none;
				cursor: pointer;
			}
		</style>
	</head>

	<body class="body-white">
		<?php echo hook('body_start');?>
<style type="text/css">
	.navbar-inner2{
		min-height: 70px; 
    	padding-right: 20px;
    	padding-left: 20px; 
		background-image: url('/themes/simplebootx/Public/images/opacity_50.png');
	}
	.navbar .nav>li>a{
		color: #000000;
    	font-weight: bolder;
    	text-shadow: none;
	}
</style>
<div class="navbar navbar-fixed-top">
   <div class="navbar-inner2">
     <div class="container">
       <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
       </a>
       <a class="brand" href="/"><img src="/themes/simplebootx/Public/images/logo.png" style="width: 200px;"/></a>
       <div class="nav-collapse collapse" id="main-menu">
       	<?php
 $effected_id="main-menu"; $filetpl="<a href='\$href' target='\$target'>\$label</a>"; $foldertpl="<a href='\$href' target='\$target' class='dropdown-toggle' data-toggle='dropdown'>\$label <b class='caret'></b></a>"; $ul_class="dropdown-menu" ; $li_class="" ; $style="nav"; $showlevel=6; $dropdown='dropdown'; echo sp_get_menu("main",$effected_id,$filetpl,$foldertpl,$ul_class,$li_class,$style,$showlevel,$dropdown); ?>
		
		<ul class="nav pull-right" id="main-menu-user">
			<li class="dropdown user login">
	            <a class="dropdown-toggle user" data-toggle="dropdown" href="#">
	            <img src="/themes/simplebootx//Public/images/headicon.png" class="headicon"/>
	            <span class="user-nicename"></span><b class="caret"></b></a>
	            <ul class="dropdown-menu pull-right">
	               <li><a href="<?php echo U('user/center/index');?>"><i class="fa fa-user"></i> &nbsp;个人中心</a></li>
	               <li class="divider"></li>
	               <li><a href="<?php echo U('user/index/logout');?>"><i class="fa fa-sign-out"></i> &nbsp;退出</a></li>
	            </ul>
          	</li>
          	<li class="dropdown user offline">
	            <a class="dropdown-toggle user" data-toggle="dropdown" href="#">
	           		<img src="/themes/simplebootx//Public/images/headicon.png" class="headicon"/>登录<b class="caret"></b>
	            </a>
	            <ul class="dropdown-menu pull-right">
	               <!--<li><a href="<?php echo U('api/oauth/login',array('type'=>'sina'));?>"><i class="fa fa-weibo"></i> &nbsp;微博登录</a></li>-->
	               <!--<li><a href="<?php echo U('api/oauth/login',array('type'=>'qq'));?>"><i class="fa fa-qq"></i> &nbsp;QQ登录</a></li>-->
	               <li><a href="<?php echo leuu('user/login/index');?>"><i class="fa fa-sign-in"></i> &nbsp;登录</a></li>
	               <li class="divider"></li>
	               <li><a href="<?php echo leuu('user/register/index');?>"><i class="fa fa-user"></i> &nbsp;注册</a></li>
	            </ul>
          	</li>
		</ul>
		<div class="pull-right">
        	<!--<form method="post" class="form-inline" action="<?php echo U('portal/search/index');?>" style="margin:18px 0;">
				 <input type="text" class="" placeholder="Search" name="keyword" value="<?php echo I('get.keyword');?>"/>
				 <input type="submit" class="btn btn-info" value="Go" style="margin:0"/>
			</form>-->
		</div>
       </div>
     </div>
   </div>
 </div>
		<ul id="homeslider" class="unstyled">
			<?php if(is_array($slides)): foreach($slides as $key=>$vo): ?><li>
					<div class="caption-wraper">
						<div class="caption"><?php echo ($vo["slide_name"]); ?></div>
					</div>
					<a href="<?php echo ($vo["slide_url"]); ?>"><img src="http://image.yijiudian.cn<?php echo sp_get_asset_upload_path($vo['slide_pic']);?>" alt=""></a>
				</li><?php endforeach; endif; ?>
		</ul>
		
		<div class="main_bg">
			<div class="wrap">
				<div class="online_reservation">
				<div class="b_room">
					<div class="booking_room">
						<h4>客房预定</h4>
						<p>我们对您的承诺：如果您在入住酒店期间有任何不满，请一定告知我们，我们将竭尽所能加以改进。期待您的每一次光顾！</p>
					</div>
					<div class="reservation">
						<ul>
							<li class="span1_of_1">
								<h5>选择房型:</h5>
								<!----------start section_room----------->
								<div class="section_room">
									<select id="country" onchange="change_country(this.value)" class="frm-field required">
										<?php if(is_array($roomArr)): foreach($roomArr as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["room_name"]); ?></option><?php endforeach; endif; ?>
					        		</select>
								</div>	
							</li>
							<li  class="span1_of_1 left">
								<h5>入住时间:</h5>
								<div class="book_date">
									<form>
										<!--<input class="date" id="datepicker" type="text" value="DD/MM/YY" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'DD/MM/YY';}">-->
										<input class="date" id="CheckInDate" type="text" value="<?php echo ($begtime); ?>">
									</form>
			
								</div>					
							</li>
							<li  class="span1_of_1 left">
								<h5>离开时间:</h5>
								<div class="book_date">
									<form>
										<!--<input class="date" id="datepicker1" type="text" value="DD/MM/YY" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'DD/MM/YY';}">-->
										<input class="input" id="CheckOutDate" type="text" value="<?php echo ($endtime); ?>">
									</form>
								</div>		
							</li>
							<li class="span1_of_2 left">
								<h5>房间数:</h5>
								<!----------start section_room----------->
								<div class="section_room">
									<select id="country1" onchange="change_country(this.value)" class="frm-field required" style="width: 141px;">
										<option value="1">1</option>
							            <option value="2">2</option>         
							            <option value="3">3</option>
										<option value="4">4</option>
					        		</select>
								</div>					
							</li>
							<li class="span1_of_3">
								<div class="date_btn">
									<form>
										<input type="button" id="reserve" value="立即预定" />
									</form>
								</div>
							</li>
							<div class="clear"></div>
						</ul>
					</div>
					<div class="clear"></div>
					</div>
				</div>
				<!--start grids_of_3 -->
				<!--<div class="grids_of_3">
					<?php if(is_array($roomList)): foreach($roomList as $key=>$vo): $pic = json_decode($vo['pics'],true); ?>
						<a href="<?php echo U('Book/book',array('cid'=>$vo['id'],'begtime'=>$begtime,'endtime'=>$endtime));?>">
					<div class="grid1_of_3">
						<div class="grid1_of_3_img">
							<img src="<?php echo sp_get_asset_upload_path($pic['photo'][0]['url']);?>" alt="" />
						</div>
						<h4><?php echo ($vo['room_name']); ?><span>￥<?php if($vo['ctime'] == strtotime(date('Y-m-d',time()))): echo ($vo['price']); else: echo ($vo['clevel_price0']); endif; ?></span></h4>
						<p><?php echo ($vo["descp"]); ?></p>
					</div>
					</a><?php endforeach; endif; ?>
					<div class="clear"></div>
				</div>	-->
			</div>
		</div>
		<div class="main_bg">
			<div class="wrap">
				<?php if(is_array($roomList)): foreach($roomList as $key=>$vo): $pic = json_decode($vo['pics'],true); ?>
						
						<div class="span3" style="width:22.5%; margin-top: 50px;margin-left:2%;">
								<a href="/index.php?g=&m=Book&a=book&cid=<?php echo ($vo['id']); ?>&begtime=<?php echo ($begtime); ?>&endtime=<?php echo ($endtime); ?>">
									<img src="http://image.yijiudian.cn<?php echo sp_get_asset_upload_path($pic['photo'][0]['url']);?>" alt="" style="width:100%;" />
								</a>
							<h3><a style="color:#000;" href="/index.php?g=&m=Book&a=book&cid=<?php echo ($vo['id']); ?>&begtime=<?php echo ($begtime); ?>&endtime=<?php echo ($endtime); ?>"><?php echo ($vo['room_name']); ?><strong>￥<?php if($vo['ctime'] == strtotime(date('Y-m-d',time()))): echo ($vo['price']); else: echo ($vo['clevel_price0']); endif; ?></strong></a></h3>
							<p style="font-size: 0.8725em;color: #6b6b6b;line-height: 1.8em"><a style="color:#6b6b6b;" href="<?php echo U('Book/book',array('cid'=>$vo['id'],'begtime'=>$begtime,'endtime'=>$endtime));?>"><?php echo ($vo["descp"]); ?></a></p>
						</div><?php endforeach; endif; ?>
				<div class="clear"></div>
			</div>
		</div>
		
		<div class="container">
			
			
		</div>
		<br>
<br>
<br>

<link href="/themes/simplebootx/Public/css/yd/layout_normal_bak.css" rel="stylesheet" />
<?php echo hook('footer');?>
<div class="footer">
	<?php $footer = sp_footer(); ?>
    <div class="footer-group" style="width:1100px;">
        <div class="footer-logo left" style="float:left;">
            <img src="/themes/simplebootx/Public/images/code.jpg">
        </div>
        <div class="footer-links left">
            <ul>
                <a href="index.php?m=list&a=index&id=1" style="color: #000000;"><li>酒店新闻
                </li></a>
                <li><a href="index.php?m=list&a=index&id=1">酒店新闻</a></li>
                <!--<li>
                    <a href="#">产品介绍</a>
                </li>
                <li>
                    <a href="#">特许合作条件</a>
                </li>
                <li>
                    <a href="#">特许合作流程</a>
                </li>
                <li>
                    <a href="#">收费标准</a>
                </li>
                <li>
                    <a href="#">特许服务支持</a>
                </li>
                <li>
                    <a href="#">加盟申请</a>
                </li>-->
            </ul>
            <ul>
                <a href="http://company.zhaopin.com/CC397771624.htm" style="color: #000000;" target="_blank"><li>电谷招聘
                </li></a>
                <li>
                    <a href="http://www.ganji.com/gongsi/15509665/" target="_blank">酒店经理</a>
                </li>
                
            </ul>
            <ul>
                <a href="<?php echo U('Index/contact');?>" style="color: #000000;"><li>电谷why
                </li></a>
                <li>
                    <a href="http://www.pvhotel.cn/portal/page/index/id/29">电谷简介</a>
                </li>
                <li>
                    <a href="<?php echo U('Index/contact');?>">联系我们</a>
                </li>
            </ul>
            <ul>
                <a href="http://company.zhaopin.com/CC397771624.htm" style="color: #000000;"><li>人才招聘
                </li></a>
                <li><a href="http://company.zhaopin.com/CC397771624.htm">人才招聘</a></li>
                <!--<li>
                    <a href="#">会员权益</a>
                </li>
                <li>
                    <a href="#">入会须知</a>
                </li>
                <li>
                    <a href="#">加入及升级</a>
                </li>
                <li>
                    <a href="#">会员储值说明</a>
                </li>
                <li>
                    <a href="#">优惠券使用说明</a>
                </li>
                <li>
                    <a href="#">会员卡挂失与补办</a>
                </li>-->
            </ul>
            <div class="footer-wx">
                <a href="<?php echo U('Index/contact');?>" style="color: #000000;"><span style="font-size: 15px; font-weight: bold; margin-bottom: 5px;">联系我们</span></a>
                <span>客服热线：<b style="font-size: 15px;color:red;"><?php echo ($footer["hotel_tel"]); ?></b></span>
                <span>总部咨询：<?php echo ($footer["hotel_tel"]); ?></span>
                <span><?php echo ($footer["gps_address"]); ?></span>
                <br><br><br>
            </div>
        </div>
    </div>
    <div class="footer-rigts">
	<script type="text/javascript" src="http://www.hbwj.gov.cn:80/hbwjww/VieidServlet?webId=bd6adfcf36c22c8359947d79d3d0e551&width=50&heigth=65"></script>
        <span>Copyright 2016-2020 电谷国际酒店 备案号：冀ICP备19030742号 <a href="http://www.beian.miit.gov.cn">工信部</a></span>
	<!--<span style="float:left;">沪ICP备13021769</span>
        <span>
            <a href="https://www.sgs.gov.cn/lz/licenseLink.do?method=licenceView&amp;entyId=1u2xwmwzpxrk6u2rvor2928au92degmyr8rxc2y7jpk9gk7" target="_blank">
                <img src="/themes/simplebootx/Public/images/none.png" class="pdl10">
            </a>
        </span>-->
    </div>
</div>
<?php echo ($site_tongji); ?>

		<script type="text/javascript">
//全局变量
var GV = {
    DIMAUB: "/",
    JS_ROOT: "public/js/",
    TOKEN: ""
};
</script>
<!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/public/js/jquery.js"></script>
    <script src="/public/js/wind.js"></script>
    <script src="/themes/simplebootx/Public/simpleboot/bootstrap/js/bootstrap.min.js"></script>
    <script src="/public/js/frontend.js"></script>
	<script>
	$(function(){
		$('body').on('touchstart.dropdown', '.dropdown-menu', function (e) { e.stopPropagation(); });
		
		$("#main-menu li.dropdown").hover(function(){
			$(this).addClass("open");
		},function(){
			$(this).removeClass("open");
		});
		
		$.post("<?php echo U('user/index/is_login');?>",{},function(data){
			if(data.status==1){
				if(data.user.avatar){
					$("#main-menu-user .headicon").attr("src",data.user.avatar.indexOf("http")==0?data.user.avatar:"/data/upload/avatar/"+data.user.avatar);
				}
				
				$("#main-menu-user .user-nicename").text(data.user.user_nicename!=""?data.user.user_nicename:data.user.user_login);
				$("#main-menu-user li.login").show();
				
			}
			if(data.status==0){
				$("#main-menu-user li.offline").show();
			}
			
		});	
		;(function($){
			$.fn.totop=function(opt){
				var scrolling=false;
				return this.each(function(){
					var $this=$(this);
					$(window).scroll(function(){
						if(!scrolling){
							var sd=$(window).scrollTop();
							if(sd>100){
								$this.fadeIn();
							}else{
								$this.fadeOut();
							}
						}
					});
					
					$this.click(function(){
						scrolling=true;
						$('html, body').animate({
							scrollTop : 0
						}, 500,function(){
							scrolling=false;
							$this.fadeOut();
						});
					});
				});
			};
		})(jQuery); 
		
		$("#backtotop").totop();
		
		
	});
	</script>


		
		<script src="/themes/simplebootx/Public/js/slippry.min.js"></script>
		<script src="/themes/simplebootx/Public/js/jquery-ui.min.js"></script>
		<script src="/themes/simplebootx/Public/js/css3-mediaqueries.js"></script>
		<script type="text/javascript" src="/themes/simplebootx/Public/js/JFCore.js"></script>
		<script type="text/javascript" src="/themes/simplebootx/Public/js/JFForms.js"></script>
		<script>
			$(function() {
				//幻灯
				var demo1 = $("#homeslider").slippry({
					transition: 'fade',
					useCSS: true,
					captions: false,
					speed: 1000,
					pause: 3000,
					auto: true,
					preload: 'visible'
				});
				
				$.datepicker.regional["zh-CN"] = { closeText: "关闭", prevText: "&#x3c;上月", nextText: "下月&#x3e;", currentText: "今天", monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"], monthNamesShort: ["一", "二", "三", "四", "五", "六", "七", "八", "九", "十", "十一", "十二"], dayNames: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"], dayNamesShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六"], dayNamesMin: ["日", "一", "二", "三", "四", "五", "六"], weekHeader: "周", dateFormat: "yy-mm-dd", firstDay: 1, isRTL: !1, showMonthAfterYear: !0, yearSuffix: "年" }
            	$.datepicker.setDefaults($.datepicker.regional["zh-CN"]);
				$( "#datepicker,#datepicker1" ).datepicker();
			});
		</script>
		<script>
			$(function(){
				$("#reserve").on("click",function(){
					var id = $("#country").val();
					var CheckInDate = $("#CheckInDate").val();
					var CheckOutDate = $("#CheckOutDate").val();
					var num = $("#country1").val();
					var aa = "/index.php?g=Portal&m=Book&a=book&id="+id+"&CheckInDate="+CheckInDate+"&CheckOutDate="+CheckOutDate+"&num="+num;
					window.location.href= aa;
				})
			})
		</script>
		<?php echo hook('footer_end');?>
	</body>

</html>