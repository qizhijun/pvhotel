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
			<li><a href="<?php echo U('Hotel/fxindex');?>">返回</a></li>
			<li class="active"><a href="javascript:;">房价管理</a></li>
		</ul>
        <form class="well form-search" method="post" action="<?php echo U('Hotel/fjindex');?>">
			<div class="search_type cc mb10">
				<div class="mb10">
					<span class="mr20">
						<a href="<?php echo U('Hotel/fjedit');?>"><input type="button" class="btn btn-success" value="修改房价" /></a>
						<a href="<?php echo U('Hotel/fledit');?>"><input type="button" class="btn btn-success" value="修改房量" /></a>
						<select class="select_2" name="priceroomid">
								<option value="0">全部</option>
							<?php if(is_array($roomid)): foreach($roomid as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>" <?php echo ($priceroomid == $vo[id] ? "selected" : ""); ?>><?php echo ($vo["room_name"]); ?></option><?php endforeach; endif; ?>
						</select>
						<input type="submit" class="btn btn-primary" value="搜索" />
						<span style="display: inline-block; background-color: red; height: 10px; width: 10px; opacity: 0.5; border: 1px solid black"></span>
						<span>满房</span>
						<span style="background: rgba(23,151,237,0.2); display: inline-block; height: 10px; width: 10px; opacity: 0.5; border: 1px solid black"></span>
						<span>房量/房价未生效</span>
						<div style="float:right;">
						<?php $detime = str_replace("/","-",$time[10]); ?>
						<a href="<?php echo U('Hotel/fjindex',array('time' => date('m-d',strtotime($time[0] . '-' . 10 . 'day'))));?>"><input type='button' value='前十天' class="btn btn-success"></a>
						<a href="<?php echo U('Hotel/fjindex',array('time'=>$detime ? $detime : date('m-d')));?>"><input type='button' value='后十天' class="btn btn-success"></a>
						</div>
					</span>
				</div>
			</div>
		</form>
            
		<div class="common-form">
			<form method="post" class="J_ajaxForm" action="#">
				<table width="100%" class="table table-hover table-bordered table-list">
					<thead>
						<tr>
							<th style="width:150px;white-space: nowrap;">房型名称</th>
							<th style="width:80px;white-space: nowrap;">项目</th>
							<?php if(is_array($time)): foreach($time as $key=>$i): ?><th><?php echo ($i); ?></th><?php endforeach; endif; ?>
							
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($roomArr)): foreach($roomArr as $key=>$vo): ?><tr>
							<td rowspan="2"><?php echo ($vo["room_name"]); ?></td>
							<td>价格</td>
							<?php if(is_array($time)): foreach($time as $key=>$v): ?><td><?php echo ($a[$vo[id]][strtotime($v)]); ?></td><?php endforeach; endif; ?>
						</tr>
						<tr>
							<td>房量</td>
							<?php if(is_array($time)): foreach($time as $key=>$i): if($d[$vo['id']][strtotime($i)] >= $b[$vo[id]][strtotime($i)]): ?><td style="background-color:red!important;opacity:0.5;color:white;">满</td>
								<?php else: ?>
									<td><?php echo ($d[$vo['id']][strtotime($i)]); ?>/<?php echo ($b[$vo[id]][strtotime($i)]); ?></td><?php endif; endforeach; endif; ?>
						</tr><?php endforeach; endif; ?>
					</tbody>
				</table>
				<div class="pagination"><?php echo ($page); ?></div>
			</form>
		</div>
	</div>
</body>
</html>