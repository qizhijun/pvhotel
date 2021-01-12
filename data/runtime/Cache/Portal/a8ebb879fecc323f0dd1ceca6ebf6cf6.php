<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
	<html>
	<head>
		<title><?php echo ($post_title); ?> <?php echo ($site_name); ?> </title>
		<meta name="keywords" content="<?php echo ($post_keywords); ?>" />
		<meta name="description" content="<?php echo ($post_excerpt); ?>">
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
	
		<style>
			#article_content img{height:auto !important}
		</style>
	</head>
<body class="">
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
<div class="container tc-main">
	<div class="row">
		<div class="span12">
			
			<div class="tc-box first-box article-box">
		    	<h2><?php echo ($post_title); ?></h2>
		    	<hr>
		    	<div id="article_content">
		    	<?php echo ($post_content); ?>
		    	</div>
		    	
		    	<?php echo hook('comment',array( 'post_id'=>$id, 'post_table'=>'posts', 'post_title'=>$post_title ));?>
		    </div>
		    
		</div>
		<!--<div class="span3">
			<div class="tc-box first-box">
				<div class="headtitle">
	          		<h2>分享</h2>
	          	</div>
	          	<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"2","bdSize":"32"},"share":{},"image":{"viewList":["weixin","tsina","qzone","tqq","renren"],"viewText":"分享到：","viewSize":"32"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["weixin","tsina","qzone","tqq","renren"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
        	</div>
        	
        	<div class="tc-box">
	        	<div class="headtitle">
	        		<h2>热门文章</h2>
	        	</div>
	        	<div class="ranking">
	        		<?php $hot_articles=sp_sql_posts("cid:$portal_index_lastnews;field:post_title,post_excerpt,tid,smeta;order:post_hits desc;limit:5;"); ?>
		        	<ul class="unstyled">
		        		<?php if(is_array($hot_articles)): foreach($hot_articles as $key=>$vo): $top=$key<3?"top3":""; ?>
							<li class="<?php echo ($top); ?>"><i><?php echo ($key+1); ?></i><a title="<?php echo ($vo["post_title"]); ?>" href="<?php echo leuu('article/index',array('id'=>$vo['tid']));?>"><?php echo ($vo["post_title"]); ?></a></li><?php endforeach; endif; ?>
					</ul>
				</div>
			</div>
			
			<?php $ad=sp_getad("portal_page_right_aside"); ?>
			<?php if(!empty($ad)): ?><div class="tc-box">
	        	<div class="headtitle">
	        		<h2>赞助商</h2>
	        	</div>
	        	<div>
		        	<?php echo ($ad); ?>
		        </div>
			</div><?php endif; ?>
			
			<div class="tc-box">
	        	<div class="headtitle">
	        		<h2>最新评论</h2>
	        	</div>
	        	<div class="comment-ranking">
	        		<?php $last_comments=sp_get_comments("field:*;limit:0,5;order:createtime desc;"); ?>
	        		<?php if(is_array($last_comments)): foreach($last_comments as $key=>$vo): ?><div class="comment-ranking-inner">
	                        <i class="fa fa-comment"></i>
	                        <a href="<?php echo U('user/index/index',array('id'=>$vo['uid']));?>"><?php echo ($vo["full_name"]); ?>:</a>
	                        <span><?php echo ($vo["content"]); ?></span>
	                        <a href="/<?php echo ($vo["url"]); ?>#comment<?php echo ($vo["id"]); ?>">查看原文</a>
	                        <span class="comment-time"><?php echo date('m月d日  H:i',strtotime($vo['createtime']));?></span>
	                    </div><?php endforeach; endif; ?>
                </div>
			</div>
        	
		</div>-->
		
	</div>
              

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


<!--<script>
	$(function(){
		$("#post-user").on("click",function(){
			$("#js_profile_qrcode").css({display:"block"})
			return false;
		})
		$(".activity-detail").on("click",function(){
			$("#js_profile_qrcode").css({display:"none"})
		})
	})
</script>-->
</body>
</html>