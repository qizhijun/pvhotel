<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<title>在线预订</title>
		<meta name="keywords" content="<?php echo ($seo_keywords); ?>" />
		<meta name="description" content="<?php echo ($seo_description); ?>">
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
	
		
		<link href="/themes/simplebootx/Public/css/yd/layout_normal.css" rel="stylesheet" />
		<link href="/themes/simplebootx/Public/css/yd/style.css?v=002" rel="stylesheet" />
		<link href="/themes/simplebootx/Public/css/yd/layer.css" rel="stylesheet" />
		<link href="/themes/simplebootx/Public/js/yd/laydate/need/laydate.css" rel="stylesheet" />
		<link href="/themes/simplebootx/Public/js/yd/laydate/skins/molv/laydate.css" rel="stylesheet" />
		<script type="text/javascript" src="/themes/simplebootx/Public/js/yd/jquery/jquery.js"></script>
		<script type="text/javascript" src="/themes/simplebootx/Public/js/yd/jquery/jquery.nicescroll.js"></script>
		<script type="text/javascript" src="/themes/simplebootx/Public/js/yd/jquery/jquery.pagination.js"></script>
		<script type="text/javascript" src="/themes/simplebootx/Public/js/yd/jquery/jquery.lazy.js"></script>
		<script type="text/javascript" src="/themes/simplebootx/Public/js/yd/layer/layer.js"></script>
		<script type="text/javascript" src="/themes/simplebootx/Public/js/yd/common/base.space.js"></script>
		<script type="text/javascript" src="/themes/simplebootx/Public/js/yd/common/base.js?v001"></script>
		<script type="text/javascript" src="/themes/simplebootx/Public/js/yd/common/base.extend.js?v001"></script>
		<script type="text/javascript" src="/themes/simplebootx/Public/js/yd/common/mesignout.js"></script>

		<script src="/themes/simplebootx/Public/js/yd/laydate/laydate.js"></script>
		<script src="/themes/simplebootx/Public/js/yd/webscript/hotel/hotelcalendar.js?v=006"></script>
		
		<style type="text/css">
			select,input[type="text"]{
				padding: 0px;
			    padding-left: 5px;
			    height: 33px;
			    line-height: 33px;
			    margin: 0px;
			    border: 1px solid #d4d4d4;
			    background: #fff;
			    color: #333;
			    font-size: 100%;
			    -moz-border-radius: 3px;
			    -webkit-border-radius: 3px;
			    border-radius: 3px;
			}
		</style>
	</head>

	<body style="background: url(/themes/simplebootx/Public/images/sec_bg.jpg) no-repeat center top fixed; background-size: cover;">
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
		
		<div class="container" style="width: 1170px;">
			<!-- 酒店预订日历 开始-->
			<div class="hotel_calendar">
				<div class="hotel_calendar_box">
					<div class="left m_calendar">
						<div class="m_citem">
							<b class="title" id="bTitle"></b>
							<table border="0" cellspacing="5" cellpadding="0" class="tblcalendar">
								<thead>
									<tr>
										<th class="lftselect"><</th>
										<th colspan="5">
											<?php if(is_array($MonthArr)): foreach($MonthArr as $key=>$vo): ?><b class="tmonth"><?php echo ($vo); ?></b><?php endforeach; endif; ?>
										</th>
											
										<th class="rghselect">></th>
									</tr>
									<tr>
										<th>日</th>
										<th>一</th>
										<th>二</th>
										<th>三</th>
										<th>四</th>
										<th>五</th>
										<th>六</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<td colspan="7" style="font-weight: initial;">
											房态查询中... 请稍后!
										</td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
					<div class="left m_bookuser m_bookuser_login hide">
						<b class="log_title">会员登录</b>
						<span>
				            <b class="left wth60">会员号</b><b class="left"><input type="text" class="input" placeholder="输入手机/邮箱/证件号码" id="tbCode" value="" /></b>
				            <b class="left clear wth60">密码</b><b class="left">
				                <input type="password" class="input" id="tbPwd" value="" />
				            </b>
				        </span>
						<span class="right mrgt10">
				            <input id="btn_login" type="button" class="btn normal left" value="登录" />
				            <input id="btn_return" type="button" class="btn orange left mrgl0" value="返回" />
				        </span>
					</div>
					<div class="left m_bookuser m_bookuser_book">
						<b class="title">预订信息</b>
						<span class="roomtype" id="tbRoomTypeName" ref="<?php echo ($roomList["id"]); ?>"><?php echo ($roomList["room_name"]); ?></span>
						<span style="padding: 5px 0px;font-weight: initial;">
							入住日期：<input class="input" id="CheckInDate" placeholder="请输入入住日期" value="<?php echo ($CheckInDate); ?>" readonly="true" style="width: 200px;width: 190px;" />
            				<span class="" style="width: 80px;text-align: right;display: inline;font-size: 18px;position: absolute;padding-top:25px;">共<span id="tbTotalDays" style="color:#f75b08;margin :0 7px;display: inline;font-size: 18px;"><?php echo ($time); ?></span>天</span>
						</span>
						<span style="padding: 5px 0px 10px;font-weight: initial;">
							离店日期：<input class="input" id="CheckOutDate" placeholder="请输入离店日期" value="<?php echo ($CheckOutDate); ?>" readonly="true" style="width: 200px;width: 190px;" />
						</span>
						<span>
				            <!--b class="pdl90 pdb20" id="tbTips"></b-->
				        </span>
						<span>
			            <b class="left wth60">房间数</b><b class="left">
			            	<?php $selected1 = $num == 1 ? "selected" : ""; $selected2 = $num == 2 ? "selected" : ""; $selected3 = $num == 3 ? "selected" : ""; $selected4 = $num == 4 ? "selected" : ""; $selected5 = $num == 5 ? "selected" : ""; ?>
			                <select id="selRooms" style="width: 280px;" class="input">
			                    <option value="1" <?php echo ($selected1); ?>>1</option>
			                    <option value="2" <?php echo ($selected2); ?>>2</option>
			                    <option value="3" <?php echo ($selected3); ?>>3</option>
			                    <option value="4" <?php echo ($selected4); ?>>4</option>
			                    <option value="5" <?php echo ($selected5); ?>>5</option>
			                </select>
			            </b>
			            <b class="left clear wth60">预订手机</b><b class="left">
			                <input type="text" id="tbTel" class="input" value="" style="width: 273px;" />
			                <a href="javascript:void(0);" style="display:none;" class="m_help">会员登录</a>
			            </b>
			            <b class="left clear wth60">预订人</b><b class="left"><input type="text" id="tbName" class="input" value="" style="width: 273px;" /></b>
			            <b class="left clear wth60">协议码</b><b class="left"><input type="text" id="xymcode" class="input" value="" style="width: 273px;" /></b>
			            <b class="left clear wth60">备&nbsp;&nbsp;&nbsp;注</b><b class="left"><input type="text" id="tbRemark" class="input" style="width: 273px;" maxlength="50" /></b>
			            <b class="left clear wth60">选择套餐</b>
			           		<select id="selRoom" style="width: 280px;" class="input">
			           			<option value="-1">请选择套餐</option>
			           		<?php if(is_array($TaoCan)): foreach($TaoCan as $key=>$vo): $selected = $rmid == $vo['id'] ? "selected" : ""; ?>
			                    <option value="<?php echo ($vo["id"]); ?>" <?php echo ($selected); ?>><?php echo ($vo['rateplanname']); ?></option><?php endforeach; endif; ?>
			                </select>
						<span class="clear"></span>
						<span class="clear point" style="color:#ec6923;padding-top:5px;display:none;">您当前可用的积分：<span style="display:inline;color:#ec6923;" id="keyon">0</span></span>
						<span class="clear point" style="color:#ec6923;padding-top:5px;display:none;">所需积分：<span style="display:inline;color:#ec6923;" id="suoxu">0</span></span>
						<!--<b class="left clear wth60">发票信息</b>
						<span style="line-height:45px;">
			                <b class="coupon" id="OpenInvoice" onclick="QueryInvoice()" style="border:1px solid #FF0000;color:#f75b08;cursor: pointer; width: 80px;height:13px;display:inline-block;text-align:center;line-height:13px;margin-top:5px;">
			                    开发票
			                </b>
			            </span>-->
						</span>
						<span class="clear" id="tbMebDesc" style="margin-top:5px;"></span>
						<span>
				            <b class="left lineh22" id="tbShowRate">门市：￥0</b>
				            <b class="left fthrough pdr20 lineh22" style="min-width: 10px;"></b><b class="left pdr20 lineh22" id="tbCardMeb">官网预订：￥0</b><b class="left lineh22">会员享更多优惠</b>
				        </span>
						<span class="clear left">
				            <b class="left lineh22">订单总额：</b><b class="left font18 c_orange pdr20 lineh22" id="tbPay">￥0元</b><b class="left c_orange lineh22" style="display: none" id="tbJie">已节省0元</b><br />
				        </span>
						<span class="right mrgt10 mrgb10">
				            <input type="button" class="btn orange" id="btBook"  value="提交订单" />
				        </span>
					</div>
				</div>
			</div>
			
			
			
			<!--传过来的参数
			<input type="hidden" id="id" value="<?php echo ($id); ?>" />
			<input type="hidden" id="CheckIn" value="<?php echo ($CheckInDate); ?>" />
			<input type="hidden" id="CheckOut" value="<?php echo ($CheckOutDate); ?>" />
			<input type="hidden" id="num" value="<?php echo ($num); ?>" />-->
			<!-- 酒店预订日历 结束-->
			
			<input type="hidden" id="hidCurrSelect" value="<?php echo ($BeginDate); ?>" />
			<input type="hidden" id="hidChainID" value="1" />
			<input type="hidden" id="hidRoomType" value="<?php echo ($id); ?>" />
			<input type="hidden" id="hidMebType" value="0" />
			<input type="hidden" id="hidStart" value="<?php echo ($CheckInDate); ?>" />
			<input type="hidden" id="hidDays" value="<?php echo ($date); ?>" />
			<input type="hidden" id="hidMebID" value="0" />
			<input type="hidden" id="hidChainName" value="E酒店" />
			<input type="hidden" id="hidMebTypeName" value="" />
			<input type="hidden" id="hidServDate" value="" />
			<input type="hidden" id="hidRooms" value="" />
			<input type="hidden" id="hidDisID" value="0" />
			<input type="hidden" id="hidDisType" value="0" />
			<input type="hidden" id="hidDisValue" value="0" />
			<input type="hidden" id="hidDisCount" value="0" />
			<input type="hidden" id="hidCode" value="" />

			<form id="fsub" action="" method="post">
				<input type="hidden" name="type" value="1" />
				<input type="hidden" name="pid" id="pid" value="610114" />
				<input type="hidden" name="folioid" id="folioid" value="0" />
				<input type="hidden" name="posttime" id="posttime" value="2016/7/12 15:18:10" />
			</form>
		</div>
		<br>
		<br>
		<br>
		<br>
		<div style="background-color: #fff;padding: 0 150px;">
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

		</div>
		
		<script>
			$(function(){
				
				$("#selRoom").change(function(){
					var start = $("#CheckInDate").val();
					var dt_start = new Date().StringToDate(start.substring(0, 8) + "01");
					var e=dt_start.Format("yyyy-MM-dd");
					//console.log(e);
					var printDate = new Date(e.replace(/-/g, "/"))
				    printDate = new Date(printDate.getFullYear(), printDate.getMonth(), 1);
				    var id = printDate.Format("yyyyMM");
				    //$("#tbody_0" + id).remove();
				    $("tbody[id*='tbody_0']").remove();
					InitCander(dt_start);
					$(".tmonth").css({ "color": "#000" });
    				$("#"+id).css({ "color": "red" });
				});
				
				$("#xymcode").keyup(function(){
					var xymcode = $("#xymcode").val();
					if(xymcode.length == 11 && xymcode > 13000000000 && xymcode < 19000000000){
						var HDSDate = $("#CheckInDate").val();
						var HDEDate = $("#CheckOutDate").val();
						var id = $("#tbRoomTypeName").attr("ref");
						var selRooms = $("#selRooms").val();
						var sel = $("#selRoom").val();
						var tbPay = $("#tbPay").html();
						var pay = tbPay.replace("元","");
						$.post("<?php echo U('Book/bookajax');?>",{Zprice:pay,HDSDate:HDSDate,HDEDate:HDEDate,id:id,selRooms:selRooms,xymcode:xymcode,sel:sel},function(data){
							if(data.success){
								$("#tbShowRate").html("门市："+data.data);
								$("#tbPay").html(data.data+"元");
								$("#tbCardMeb").html("官网预定：￥"+data.data);
							}else{
								return false;
							}
						},"json")
					}
				})
				
				$("#btBook").on("click",function(){
					var id = $("#tbRoomTypeName").attr("ref");
					var CheckInDate = $("#CheckInDate").val();
					var CheckOutDate = $("#CheckOutDate").val();
					var selRooms = $("#selRooms").val();
					var tbTel = $("#tbTel").val();
					var tbName = $("#tbName").val();
					var tbRemark = $("#tbRemark").val();
					var sel = $("#selRoom").val();
					var tbPay = $("#tbPay").html();
					var pay = tbPay.replace("元","");
					var tbTotalDays = $("#tbTotalDays").html();
					var xymcode = $("#xymcode").val();
					
					if(tbName == ""){
						Atour.Ui.Alert("请填写联系人名称");
						$("#tbName").focus();
        				return false;
					}
					
					if(tbTel == ""){
						Atour.Ui.Alert("联系人手机未填写");
				        $("#tbTel").focus();
				        return false;
					}
					$.post("<?php echo U('Book/book_order');?>",{xymcode:xymcode,id:id,CheckInDate:CheckInDate,CheckOutDate:CheckOutDate,selRooms:selRooms,tbTel:tbTel,tbName:tbName,tbRemark:tbRemark,sel:sel,pay:pay,tbTotalDays:tbTotalDays},function(data){
						if(data.code == 0){
							alert("下单成功");
							location.reload();
						}
						if(data.code == "-2"){
							alert(data.data);
							location.reload();
						}
						if(data.code == "-3"){
							alert(data.data);
							location.reload();
						}
					},"json")
				})
			})
		</script>
	</body>

</html>