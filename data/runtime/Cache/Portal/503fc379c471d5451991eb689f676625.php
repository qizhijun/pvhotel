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
		<script type="text/javascript" src="/themes/simplebootx/Public/js/index.js"></script>

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
		
		<div class="container">

	<script src="/themes/simplebootx/Public/js/yd/common/city_data.js?v=005"></script>
	<script src="/themes/simplebootx/Public/js/yd/common/citySelf.js"></script>

	<script>
		var params = new Common.Query.M();
		params.setParameters("AdvertisementType", 2); //在线预订AdvertisementType为2
		//获取广告
		Atour.Ajax.Get({
			Url: "",
			DataParam: params.getString(false),
			FuncName: "changeAdvertisement"
		});
		//显示广告
		function changeAdvertisement(result) {
			if(result.State == 1) {
				if(result.Data.ImageUrl != null && result.Data.ImageUrl != "") { //该位置有广告上线，没有则使用默认的
					var Advertisement = $("#Advertisement");
					Advertisement.attr("src", result.Data.ImageUrl);
					if(result.Data.PageUrl != null && result.Data.PageUrl != "") { //该广告有链接
						Advertisement.attr("onclick", 'location.href =' + "'" + result.Data.PageUrl + "'" + '');
					} else { //该广告没有链接，则不设页面跳转
						Advertisement.removeAttr("onclick");
						Advertisement.attr("style", "width: 100%;");
					}
					return;
				} else {
					var Advertisement = $("#Advertisement");
					Advertisement.attr("src", "/Skin/images/banner001.jpg");
				}
			}
			return;
		}
	</script>
	<script>
		function book_room(id,rid){
			var begtime = $("#begtime").val();
			var endtime = $("#endtime").val();
			var aa = "/index.php?g=Portal&m=Book&a=book&rmid="+id+"&begtime="+begtime+"&endtime="+endtime+"&id="+rid;
					window.location.href= aa;
		}		
	</script>
	<style>
		.item_hotels {
			margin-bottom: 30px;
		}
	</style>

	
	<!-- 酒店列表 开始-->
	<div class="hotel_list">
		<?php $category_type = array("1"=>"单人床","2"=>"双床","3"=>"大床"); ?>
		<?php if(is_array($RoomArr)): foreach($RoomArr as $key=>$vo): $pic = json_decode($vo['pics'],ture); ?>
		<div class="hotel_item">
			<div class="left item_img"><img class="lazy-load" src="<?php echo sp_get_asset_upload_path($pic['photo'][0]['url']);?>"></div>
			<div class="left item_details">
				<div><span class="item_icon left"><img src="/themes/simplebootx/Public/images/layer/LOGO1.png"></span><span class="item_title"><a href="#"><?php echo ($vo["room_name"]); ?></a></span></div>
				<div class="item_address"><span><?php echo ($vo["room_area"]); ?>平米/可住<?php echo ($vo["imax_guestnum"]); ?>人 <?php echo ($category_type[$vo['category_type']]); ?></span>
					<br><span><?php echo ($vo["descp"]); ?></span></div>
				<div class="item_hotels" id="item_hotels630101">
					<table border="0" cellspacing="0" cellpadding="0" class="tblhotels">
						<thead>
							<tr>
								<th>套餐</th>
								<th>官网预订价</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($RoomRpArr[$vo['id']])): foreach($RoomRpArr[$vo['id']] as $key=>$v): ?><tr>
								<td><?php echo ($v["rateplanname"]); ?></td>
								<td><?php echo ($v["Zprice"]); ?></td>
								<?php if(is_array($newdate)): foreach($newdate as $key=>$n): if($room_N[$vo['id']][$n] < $NumArr[$vo['id']][$n]): ?><td><input type="button" value="预订" class="btn normal" onclick="book_room(<?php echo ($v["rpid"]); ?>,<?php echo ($vo["id"]); ?>)"></td>
								<?php else: ?>
								<td><input type="button" value="已满" class="btn" style="background-color:#757575;"></td><?php endif; endforeach; endif; ?>
							</tr><?php endforeach; endif; ?>
							
						</tbody>
						
					</table>
				</div>
			</div><input type="hidden" id="chainname630101" value="西宁夏都亚朵酒店"></div><?php endforeach; endif; ?>
		<!--<div class="pages"><b class="disabled"><a href="javascript:void(0);">上一页</a></b><span class="active"><a href="javascript:void(0);">1</a></span><span><a href="javascript:void(0);">2</a></span><span><a href="javascript:void(0);">3</a></span><span><a href="javascript:void(0);">4</a></span><span><a href="javascript:void(0);">5</a></span><b><a href="javascript:void(0);">下一页</a></b></div>-->
	</div>
	<!-- 酒店列表 结束-->
	<input type="hidden" id="MebTypeID" value="0">
	<input type="hidden" id="tableHeradName" value="官网预订价">
	<input type="hidden" id="begtime" value="<?php echo ($begtime); ?>">
	<input type="hidden" id="endtime" value="<?php echo ($endtime); ?>">

</div>
		
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
		
	</body>

</html>