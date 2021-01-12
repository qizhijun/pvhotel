<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<!-- Set render engine for 360 browser -->
	<meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->

	<link href="/public/simpleboot/themes/<?php echo C('SP_ADMIN_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/public/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/public/js/artDialog/skins/default.css" rel="stylesheet" />
    <link href="/public/simpleboot/font-awesome/4.4.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <style>
		.length_3{width: 180px;}
		form .input-order{margin-bottom: 0px;padding:3px;width:40px;}
		.table-actions{margin-top: 5px; margin-bottom: 5px;padding:0px;}
		.table-list{margin-bottom: 0px;}
	</style>
	<!--[if IE 7]>
	<link rel="stylesheet" href="/public/simpleboot/font-awesome/4.4.0/css/font-awesome-ie7.min.css">
	<![endif]-->
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
    <script src="/public/simpleboot/bootstrap/js/bootstrap.min.js"></script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
	</style><?php endif; ?>
<style>
	.home_info li em {
		float: left;
		width: 120px;
		font-style: normal;
	}
	
	li {
		list-style: none;
	}
</style>
<link rel="stylesheet" type="text/css" href="/admin/themes/simplebootx/Public/assets/css/style.css" />
<link rel="stylesheet" type="text/css" href="/admin/themes/simplebootx/Public/assets/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="/admin/themes/simplebootx/Public/assets/css/bootstrap-reset.css" />
<link rel="stylesheet" type="text/css" href="/admin/themes/simplebootx/Public/assets/css/clndr.css" />
<link rel="stylesheet" type="text/css" href="/admin/themes/simplebootx/Public/assets/css/custom-ico-fonts.css" />
<link rel="stylesheet" type="text/css" href="/admin/themes/simplebootx/Public/assets/css/style-responsive.css" />
</head>

<body id="ccc" onload="lxfEndtime()">
	<div class="wrap">
		<div class="row states-info">
			<div class="col-md-3">
				<div class="panel red-bg">
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-4">
								<i class="fa fa-money"></i>
							</div>
							<div class="col-xs-8">
								<span class="state-title"> 客房订单 </span>
								<h4><?php echo ($kfOrder); ?></h4>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="panel blue-bg">
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-4">
								<i class="fa fa-tag"></i>
							</div>
							<div class="col-xs-8">
								<span class="state-title">  餐饮订单  </span>
								<h4><?php echo ($cyOrder); ?></h4>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="panel green-bg">
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-4">
								<i class="fa fa-gavel"></i>
							</div>
							<div class="col-xs-8">
								<span class="state-title">  休闲娱乐订单  </span>
								<h4>0</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="panel yellow-bg">
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-4">
								<i class="fa fa-eye"></i>
							</div>
							<div class="col-xs-8">
								<span class="state-title">  会议宴会问询  </span>
								<h4><?php echo ($yhOrder); ?></h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8">
				<section class="panel">
					<header class="panel-heading">
						网站访问量
					</header>
					<div class="panel-body">
						<div id="visitors-chart">
							<div id="visitors-container" style="width: 100%;height:374px; text-align: center; margin:0 auto;">
							</div>
						</div>
					</div>
				</section>
			</div>
			<div class="col-md-4">
				<section class="panel">
					<header class="panel-heading">最新关注的粉丝</header>
					<div class="panel-body">
						<div class="dir-info">
							<?php if(is_array($fans)): foreach($fans as $key=>$vo): $nickname = urldecode($vo['nickname']); ?>
								<div class="row">
									<div class="col-xs-3">
										<div class="avatar">
											<img src="<?php echo ($vo["headimgurl"]); ?>" alt="" />
										</div>
									</div>
									<div class="col-xs-6">
										<h5><?php echo ($nickname); ?></h5>
										<!--<span>
                                        <a href="#" class="small"> katy Perry</a>
                                    </span>-->
									</div>
									<div class="col-xs-3">
										<a class="dir-like" href="#">
											<span class="small"><?php echo (date("Y-m-d",$vo['created'] )); ?></span>
											<i class="fa fa-heart"></i>
										</a>
									</div>
								</div><?php endforeach; endif; ?>
							
						</div>

					</div>
				</section>
			</div>
		</div>
	</div>
	<style>
		.black_overlay {
			display: none;
			position: absolute;
			top: 0%;
			left: 0%;
			width: 100%;
			height: 100%;
			background-color: black;
			z-index: 1001;
			-moz-opacity: 0.8;
			opacity: .80;
			filter: alpha(opacity=80);
		}
		
		.white_content {
			display: none;
			position: absolute;
			top: 25%;
			left: 25%;
			width: 50%;
			height: 50%;
			padding: 16px;
			border: 16px solid orange;
			background-color: white;
			z-index: 1002;
		}
	</style>
	<!--<audio id="m_bg_music" hidden=true src="/admin/themes/simplebootx/Public/assets/images/zhangjie.mp3"></audio>-->
	<div id="light" class="white_content" style="display:none;">
		<img id="bbb" src="/admin/themes/simplebootx/Public/assets/images/3.png" style="position: absolute;right: 0px; top: -35px;right: -25px;">
		<form method="post" class="J_ajaxForm" action="#">
			<table width="100%" class="table table-hover table-bordered table-list">
				<thead>
					<tr>
						<th>名称</th>
						<th width="200px">操作</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						
					</tr>
				</tbody>
			</table>
			<div class="pagination"><?php echo ($page); ?></div>
		</form>
	</div>
	<div id="fade" class="black_overlay" style="display:none;">
	<script src="/admin/themes/simplebootx/Public/assets/js/flot-chart/jquery.flot.js"></script>
	<script src="/admin/themes/simplebootx/Public/assets/js/flot-chart/jquery.flot.tooltip.js"></script>
	<script src="/admin/themes/simplebootx/Public/assets/js/flot-chart/jquery.flot.resize.js"></script>
	<script src="/admin/themes/simplebootx/Public/assets/js/flot-chart/jquery.flot.pie.resize.js"></script>
	<script src="/admin/themes/simplebootx/Public/assets/js/flot-chart/jquery.flot.selection.js"></script>
	<script src="/admin/themes/simplebootx/Public/assets/js/flot-chart/jquery.flot.stack.js"></script>
	<script src="/admin/themes/simplebootx/Public/assets/js/flot-chart/jquery.flot.time.js"></script>
	<script src="/admin/themes/simplebootx/Public/assets/js/main-chart.js"></script>
	<script>
		function lxfEndtime() {
		    $.post("<?php echo U('Main/orderPrompt');?>",function(data){
		    	if(data.code == 0 && (data.data['kforder'] != "" || data.data['cyorder'] != "" || data.data['yhorder'] != "")){
		    		$("#light").css("display","block");
		    		$("#fade").css("display","block");
		    		var table_htm;
		    		if(data.data['kforder']){
		    			var kforder = data.data['kforder'];
		    			for(var i =0;i<kforder.length;i++){
		    				table_htm += "<tr><td>"+kforder[i]["room_name"]+"</td><td><a href='<?php echo U('Order/kflist');?>'>去处理</a></td></tr>";
		    			}
		    		}
		    		if(data.data['cyorder']){
		    			var cyorder = data.data['cyorder'];
		    			for(var i =0;i<cyorder.length;i++){
		    				table_htm +="<tr><td>"+cyorder[i]["resname"]+"</td><td><a href='<?php echo U('Order/cylist');?>'>去处理</a></td></tr>";
		    			}
		    		}
		    		if(data.data['yhorder']){
		    			var yhorder = data.data['yhorder'];
		    			for(var i =0;i<yhorder.length;i++){
		    				table_htm +="<tr><td>"+yhorder[i]["crname"]+"</td><td><a href='<?php echo U('Order/hyyhlist');?>'>去处理</a></td></tr>";
		    			}
		    		}
		    		$("#light tbody").html(table_htm)
//		    		var audio = document.getElementById('m_bg_music')
//		    		audio.play();
		    	}else{
		    		$("#light").css("display","none");
		    		$("#fade").css("display","none");
		    	}
		    },"json")
		    setTimeout("lxfEndtime()", 1000*60*5); 
		}
		$("#bbb").on("click",function(){
//			var audio = document.getElementById('m_bg_music')
//		    audio.pause();
//		    audio.currentTime = 0;
			$("#light").css("display","none");
			$("#fade").css("display","none");
		})
		
	</script>
</body>

</html>