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
			<li  class="active"><a href="javascript:;">客房订单</a></li>
		</ul>
            <form class="well form-search" method="post" action="<?php echo U('Order/kflist');?>">
			<div class="search_type cc mb10">
				<div class="mb10">
					状态:
					<select class="select_2" name="status">
							<option value="1" <?php echo ($status == 1 ? "selected" : ""); ?>>刚下单</option>
							<option value="2" <?php echo ($status == 2 ? "selected" : ""); ?>>已支付</option>
							<option value="3" <?php echo ($status == 3 ? "selected" : ""); ?>>确认订单</option>
							<option value="-1" <?php echo ($status == -1 ? "selected" : ""); ?>>取消订单</option>
					</select>
					订单分类:
					<select class="select_2" name="type">
							<option value="0" >全部订单</option>
							<option value="1" <?php echo ($type == 1 ? "selected" : ""); ?>>微信订单</option>
							<option value="2" <?php echo ($type == 2 ? "selected" : ""); ?>>网站订单</option>
					</select>
					<span class="mr20">
						<input type="text" name="keyname" style="width: 200px;" value="<?php echo ($keyname); ?>" placeholder="订单号、用户手机号">
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
							<th>订单编号</th>
							<th>用户姓名</th>
							<th>用户手机号</th>
							<th>客房名称</th>
							<th>房型名称</th>
							<th>到店时间</th>
							<th>订单总金额</th>
							<th>支付金额</th>
							<th>下单时间</th>
							<th>订单分类</th>
							<th>状态</th>
							<th width="180px">操作</th>
						</tr>
					</thead>
					<?php $status = array("1"=>"刚下单","2"=>"已支付","3"=>"已确认订单","-1"=>"已取消订单"); ?>
					<?php $type = array("1"=>"微信订单","2"=>"网站订单"); ?>
					<tbody>
						<?php if(is_array($kforderArr)): foreach($kforderArr as $key=>$vo): $vipname = json_decode($vo['vipname'],true); ?>
							<?php if($vo['status'] != -1): ?><tr>
							<td><?php echo ($vo["id"]); ?></td>
							<td><?php echo ($vipname['name']); ?></td>
							<td><?php echo ($vo["vipphone"]); ?></td>
							<td><?php echo ($vo["rateplanname"]); ?></td>
							<td><?php echo ($vo["room_name"]); ?></td>
							<td><?php echo (date("Y-m-d",$vo[begtime] )); ?></td>
							<td><?php echo ($vo["amount"]); ?></td>
							<td><?php echo ($vo["paycost"]); ?></td>
							<td><?php echo (date("Y-m-d H:i:s",$vo[created] )); ?></td>
							<td><?php echo ($type[$vo['type']]); ?></td>
							<td><?php echo ($status[$vo[status]]); ?></td>
							<td>
								<?php if($vo['status'] != 3): ?><a href="javascript:open_iframe_dialog('<?php echo U('order/kfdetail',array('openid'=>$vo['id']));?>','客房详情')">客房详情</a>|
									<a href="<?php echo U('Order/kfdelete',array('id'=>$vo['id'],'status'=>3));?>">确认订单</a>|
									<a href="<?php echo U('Order/kforderdelete',array('id'=>$vo['id'],'status'=>'-1'));?>">取消订单</a> 
								<?php else: ?>
									<a href="javascript:open_iframe_dialog('<?php echo U('order/kfdetail',array('openid'=>$vo['id']));?>','客房详情')">客房详情</a>|
									<a href="<?php echo U('Order/kforderdelete',array('id'=>$vo['id'],'status'=>'-1'));?>">取消订单</a> |
									<span>已确认订单</span><?php endif; ?>
							</td>
						</tr>
						<?php else: ?>
						<tr>
							<td><?php echo ($vo["id"]); ?></td>
							<td><?php echo ($vipname['name']); ?></td>
							<td><?php echo ($vo["vipphone"]); ?></td>
							<td><?php echo ($vo["rateplanname"]); ?></td>
							<td><?php echo ($vo["room_name"]); ?></td>
							<td><?php echo (date("Y-m-d",$vo[begtime] )); ?></td>
							<td><?php echo ($vo["amount"]); ?></td>
							<td><?php echo ($vo["paycost"]); ?></td>
							<td><?php echo (date("Y-m-d H:i:s",$vo[created] )); ?></td>
							<td><?php echo ($type[$vo['type']]); ?></td>
							<td><?php echo ($status[$vo[status]]); ?></td>
							<td>
								<a href="javascript:open_iframe_dialog('<?php echo U('order/kfdetail',array('openid'=>$vo['id']));?>','客房详情')">客房详情</a>|
								<span>已取消订单</span>
							</td>
						</tr><?php endif; endforeach; endif; ?>
					</tbody>
				</table>
				<div class="pagination"><?php echo ($page); ?><a href="#">一共<?php echo ($count); ?>个订单</a></div>
			</form>
		</div>
	</div>
</body>
<script src="/public/js/common.js"></script>
</html>