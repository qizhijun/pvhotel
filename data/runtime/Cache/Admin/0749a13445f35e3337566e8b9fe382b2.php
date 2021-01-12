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
			<li class='active'><a href="<?php echo U('member/index');?>">待审核员工</a></li>
			<li><a href="<?php echo U('member/yishen');?>">已审核员工</a></li>
		</ul>
		<form class="well form-search" method="post" action="<?php echo U('Member/index');?>">
			<div class="search_type cc mb10">
				<div class="mb10">
					<span class="mr20">
						<input type="text" name="keyname" style="width: 200px;" value="<?php echo ($keyname); ?>" placeholder="员工姓名/部门/手机号">
						<input type="submit" class="btn btn-primary" value="搜索" />
					</span>
				</div>

			</div>
		</form>
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th width="50">ID</th>
					<th>员工姓名</th>
					<th>部门</th>
					<th>手机号</th>
					<th>认证时间</th>
					<th>状态</th>
					<th width="120">管理操作</th>
				</tr>
			</thead>
			<tbody>
				<?php $user_statuses=array("0"=>"未审核","1"=>"已审核"); ?>
				<?php if(is_array($members)): foreach($members as $key=>$vo): $creattime=date("Y-m-d H:i:s",$vo["created"]) ?>
				<tr>
					<td><?php echo ($vo["id"]); ?></td>
					<td><?php echo ($vo["name"]); ?></td>
					<td><?php echo ($vo["postname"]); ?></td>
					<td><?php echo ($vo["phone"]); ?></td>
					<td><?php echo ($creattime); ?></td>
					<td><?php echo ($user_statuses[$vo['status']]); ?></td>
					<td>
						<a href='<?php echo U("member/edit",array("id"=>$vo["id"]));?>'>审核员工</a> | 
						<a class="js-ajax-delete" data-msg="您确定要删除吗？" href="<?php echo U('member/delete',array('id'=>$vo['id'],'isdel'=>1));?>">删除</a>
					</td>
				</tr><?php endforeach; endif; ?>
			</tbody>
		</table>
		<div class="pagination"><?php echo ($page); ?><a href="#">共<?php echo ($count); ?>个未审核</a></div>
	</div>
	<script src="/public/js/common.js"></script>
</body>
</html>