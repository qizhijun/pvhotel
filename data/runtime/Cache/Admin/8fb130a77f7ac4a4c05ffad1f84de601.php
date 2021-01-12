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
</head>
<body class="J_scroll_fixed">
	<div class="wrap J_check_wrap">
		<ul class="nav nav-tabs">
			<li class="active"><a href="javascript:;">餐厅管理</a></li>
			<li><a href="<?php echo U('Hotel/ctadd');?>">添加餐厅</a></li>
			<li><a href="<?php echo U('Hotel/bjindex');?>">包间管理</a></li>
			<li><a href="<?php echo U('Hotel/cpindex');?>">菜品管理</a></li>
		</ul>
            <form class="well form-search" method="post" action="<?php echo U('Hotel/ctindex');?>">
			<div class="search_type cc mb10">
				<div class="mb10">
					<span class="mr20">
						营业状态：
						<select class="select_2" name="isdel"> 
							<option value=''>全部</option>
							<option value='-1' <?php echo ($isdel == -1 ? "selected" : ""); ?>>营业</option>
							<option value='1' <?php echo ($isdel == 1 ? "selected" : ""); ?>>停业</option>
						</select>
						<input type="submit" class="btn btn-primary" value="搜索" />
					</span>
				</div>
			</div>
		</form>
            
		<div class="common-form">
			<form method="post" class="J_ajaxForm" action="#">
				<table width="100%" class="table table-hover table-bordered table-list">
					<thead>
						<tr>
							<th>餐厅名称</th>
							<th>餐厅类型</th>
							<th>人均消费</th>
							<th>营业状态</th>
							<th width="120px">操作</th>
						</tr>
					</thead>
					<tbody>
						<?php $isdel = array("1"=>"<span style='color: red;'>已停业</span>","-1"=>"正常营业"); ?>
						<?php if(is_array($restaurant)): foreach($restaurant as $key=>$vo): ?><tr>
							<td><?php echo ($vo["resname"]); ?></td>
							<td><?php echo ($vo["name"]); ?></td>
							<td><?php echo ($vo["perperson"]); ?></td>
							<td><?php echo ($isdel[$vo['isdel']]); ?></td>
							<td>
								<a href="<?php echo U('Hotel/ctedit',array('id'=>$vo['id']));?>" >编辑</a>|
								<?php if($vo['isdel'] == 1): ?><a href="<?php echo U('Hotel/isdel',array('id'=>$vo['id'],'isdel'=>'-1'));?>" class="js-ajax-referer">开业</a>
								<?php else: ?>
								<a href="<?php echo U('Hotel/isdel',array('id'=>$vo['id'],'isdel'=>'1'));?>" class="js-ajax-delete">停业</a><?php endif; ?>
							</td>
						</tr><?php endforeach; endif; ?>
					</tbody>
				</table>
				<div class="pagination"><?php echo ($page); ?></div>
			</form>
		</div>
	</div>
</body>
<script src="/public/js/common.js"></script>
</html>