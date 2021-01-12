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
			<li class="active"><a href="javascript:;">房型管理</a></li>
			<li><a href="<?php echo U('Hotel/fxadd');?>">添加房型</a></li>
			<li><a href="<?php echo U('Hotel/rpindex');?>">房型RP列表</a></li>
			<li><a href="<?php echo U('Hotel/fjindex');?>">房价管理</a></li>
		</ul>
        <form class="well form-search" method="post" action="<?php echo U('Hotel/fxindex');?>">
			<div class="search_type cc mb10">
				<div class="mb10">
					<span class="mr20">
						状态：
						<select class="select_2" name="iroom_status">
							<option value='1'>有效房型</option>
							<option value='-1' <?php echo ($iroom_status == -1 ? "selected" : ""); ?>>无效房型</option>
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
							<th>房型名称</th>
							<th width="120px">操作</th>
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($roomArr)): foreach($roomArr as $key=>$vo): ?><tr>
							<td><?php echo ($vo["room_name"]); ?></td>
							<td>
								<a href="<?php echo U('Hotel/fxedit',array('id'=>$vo['id']));?>">编辑房型</a>
							</td>
						</tr><?php endforeach; endif; ?>
					</tbody>
				</table>
				<div class="pagination"><?php echo ($page); ?></div>
			</form>
		</div>
	</div>
</body>
</html>