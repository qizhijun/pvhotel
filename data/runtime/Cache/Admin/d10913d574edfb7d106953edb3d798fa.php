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
			<li class="active"><a href="javascript:;">会议宴会管理</a></li>
			<li><a href="<?php echo U('Hotel/hyyhadd');?>">添加宴会厅</a></li>
		</ul>
            <form class="well form-search" method="post" action="<?php echo U('Hotel/hyyhindex');?>">
			<div class="search_type cc mb10">
				<div class="mb10">
					<span class="mr20">
						<input type="text" name="keyname" style="width: 200px;" value="<?php echo ($keyname); ?>" placeholder="宴会厅名称">
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
							<th>宴会厅名称</th>
							<th width="200px">操作</th>
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($conferenceroom)): foreach($conferenceroom as $key=>$vo): ?><tr>
							<td><?php echo ($vo["crname"]); ?></td>
							<td>
								<a href="<?php echo U('Hotel/hyyhedit',array('id'=>$vo['id']));?>">编辑</a>|
								<?php if($vo['status'] == 0): ?><a href="<?php echo U('Hotel/hyyhstatus',array('id'=>$vo['id'],'status'=>'1'));?>">不可预约</a>
								<?php else: ?>
								<a href="<?php echo U('Hotel/hyyhstatus',array('id'=>$vo['id'],'status'=>'0'));?>">可预约</a><?php endif; ?>
								|
								<a href="<?php echo U('Hotel/hyyhdelete',array('id'=>$vo['id'],'isdel'=> 1));?>" class="js-ajax-delete">删除</a>
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