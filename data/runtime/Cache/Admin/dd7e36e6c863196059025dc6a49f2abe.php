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
<link rel="stylesheet" type="text/css" href="/admin/themes/simplebootx/assets/css/chosen/chosen.css"/>
<style type="text/css">
	.amap-layers div{
		width: 500px;
		height: 400px;
	}
</style>
</head>
<body>
	<div class="wrap">
		<ul class="nav nav-tabs">
			<li><a href="<?php echo U('Hotel/fjindex');?>">返回</a></li>
			<li class="active"><a href="javascript:;">房价修改</a></li>
		</ul>
		<form method="post" class="form-horizontal js-ajax-form" action="<?php echo U('Hotel/fjedit_post');?>">
			<fieldset>
				<div class="control-group">
					<label class="control-label">房型名称</label>
					<div class="controls">
						<select name="priceroomid">
						<?php if(is_array($roomArr)): foreach($roomArr as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>" id="room_id"><?php echo ($vo["room_name"]); ?></option><?php endforeach; endif; ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">开始时间</label>
					<div class="controls">
						<input type="text" name="startTime" class="js-date" value="" autocomplete="off" style="width:130px;">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">结束时间</label>
					<div class="controls">
						<input type="text" class="js-date" name="endTime" value="" autocomplete="off" style="width:130px;">
					</div>
				</div>
				<div class="control-group">
				<label class="control-label">有效日期</label>
					<div class="controls">
						全部<input id="controlAll" onclick="selectAll()" type="checkbox">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input id="chk1" type="checkbox" name="pweek[1]"  value="1"><label style="display:initial;" for="chk1">周一</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input id="chk2" type="checkbox" name="pweek[2]"  value="2"><label style="display:initial;" for="chk2">周二</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input id="chk3" type="checkbox" name="pweek[3]" value="3"><label style="display:initial;" for="chk3">周三</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input id="chk4" type="checkbox" name="pweek[4]"  value="4"><label style="display:initial;" for="chk4">周四</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input id="chk5" type="checkbox" name="pweek[5]" value="5"><label style="display:initial;" for="chk5">周五</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input id="chk6" type="checkbox" name="pweek[6]" value="6"><label style="display:initial;" for="chk6">周六</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input id="chk7" type="checkbox" name="pweek[7]" value="0"><label style="display:initial;" for="chk7">周日</label>
					</div>
				</div>
				<!--<div class="control-group">
					<label class="control-label">会员基础价</label>
					<div class="controls">
						<input type="text" name="price" value="" style="width:80px;">
						<span class="form-required">元(单位：元/每间)</span>
					</div>
				</div>-->
				<div class="control-group">
					<label class="control-label"><!--E享会员卡-->会员基础价</label>
					<div class="controls">
						<input type="text" name="vipprice" value="" style="width:80px;">
						<span class="form-required">元(单位：元/每间)</span>
					</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<button type="submit" class="btn btn-primary js-ajax-submit">保存</button>
				<a class="btn" href="<?php echo U('Hotel/fjindex');?>">返回</a>
			</div>
		</form>
	</div>
	<script type="text/javascript" src="/public/js/common.js"></script>
	<script type="text/javascript" src="/public/js/content_addtop.js"></script>
	<script src="/public/js/chosen/chosen_jquery_min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		function selectAll(){
		 var checklist = document.getElementsByTagName("input");
			if(document.getElementById("controlAll").checked)
			{
			    for(var i=0;i<checklist.length;i++)
			{
			    checklist[i].checked = 1;
			} 
			}else{
			    for(var j=0;j<checklist.length;j++)
			{
			     checklist[j].checked = 0;
			}
		}
	}
	$("#room_id").on("click",function(){})
	</script>
</body>
</html>