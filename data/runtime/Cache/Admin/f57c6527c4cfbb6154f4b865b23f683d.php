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
			<li><a href="<?php echo U('Hotel/rpindex');?>">房型RP列表</a></li>
			<li class="active"><a href="javascript:;">添加客房产品规则</a></li>
		</ul>
		<form method="post" class="form-horizontal js-ajax-form" action="<?php echo U('Hotel/rpadd_post');?>">
			<fieldset>
			<h4>基本信息</h4><br>
				<div class="control-group">
					<label class="control-label">客房产品名称</label>
					<div class="controls">
						<input type="text" name="RatePlanName" value="" placeholder="根据客房产品建立相关的名称" style="width:250px;">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">排序</label>
					<div class="controls">
						<input type="text" name="SortIndex" value="" style="width:80px;">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">开始时间</label>
					<div class="controls">
						<input type="text" name="StartDate" class="js-date" value="" autocomplete="off" style="width:130px;">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">结束时间</label>
					<div class="controls">
						<input type="text" class="js-date" name="EndDate" value="" autocomplete="off" style="width:130px;">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">支付类型</label>
					<div class="controls">
						<input type="radio" name="PaymentType" id="pay1" value="1"><label style="display:initial;" for="pay1">在线预付</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="PaymentType" id="pay2" value="-1"><label style="display:initial;" for="pay2">到付</label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">客房产品状态</label>
					<div class="controls">
						<input type="radio" id="status1" name="Status" value="1" checked="checked"><label for="status1" style="display:initial;">有效</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" id="status2" name="Status" value="-1"><label for="status2" style="display:initial;">无效</label>
					</div>
				</div>
				<hr/>
				<h4>规则信息</h4><br>
				<div class="control-group">
					<label class="control-label"><h5>服务项目</h5></label>
				</div><br>
				<div class="control-group">
					<label class="control-label" for="chk1">早餐</label>
					<div class="controls">
						<input id="chk1" type="checkbox" class="bfservice">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input style="margin-bottom:5px;width:80px;" type="text" name="bfservice[1]" readonly="readonly">元
					</div>
					<label class="control-label" for="chk2">午餐</label>
					<div class="controls">
						<input type="checkbox" id="chk2" class="bfservice">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input style="margin-bottom:5px;width:80px;" type="text" name="bfservice[2]" readonly="readonly">元
					</div>
					<label class="control-label" for="chk3">晚餐</label>
					<div class="controls">
						<input type="checkbox" id="chk3" class="bfservice">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input style="margin-bottom:5px;width:80px;" type="text" name="bfservice[3]" readonly="readonly">元
					</div>
					<label class="control-label" for="chk4">宽带上网</label>
					<div class="controls">
						<input type="checkbox" id="chk4" class="bfservice">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input style="margin-bottom:5px;width:80px;" type="text" name="bfservice[4]" readonly="readonly">元
					</div>
					<label class="control-label" for="chk5">服务费</label>
					<div class="controls">
						<input type="checkbox" id="chk5" class="bfservice">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="text" name="bfservice[5]" readonly="readonly" style="width:80px;" value="0">% 注:每间夜优惠后的%多少
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><h5>预定项目</h5></label>
				</div><br>
				<div class="control-group">
					<div class="controls">
						<input type="radio" id="pric1" name="pricetype" value="1" checked="checked" class="pricetype"><label style="display:initial;" for="pric1">按价格优惠</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" id="pric2" name="pricetype" value="-1" class="pricetype1"><label for="pric2" style="display:initial;">按百分比优惠</label>
					</div>
				</div>
				<div id="jiage">
				<div class="control-group">
					<div class="controls">
						<input type="radio" name="reserveitem" id="res1" value="1" class="reserveitem"><label style="display:initial;" for="res1">平日价，每晚优惠/加价</label>
						<span class="form-required" style="color:red;">(如果想在基础价格上增加费用，可填写负数)</span><br></br>
						<input type="text" name="pricerule[1]" class="reserveitem1" value="" style="width:80px;" readonly="readonly">元
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="radio" name="reserveitem" id="res2" value="2" class="reserveitem"><label style="display:initial;" for="res2">提前X天预定，每间优惠</label><br><br>
						<input type="text" name="pricerule[2]" class="reserveitem1" placeholder="提前多少" value="" style="width:80px;" readonly="readonly">天&nbsp;
						<input type="text" name="pricerule[3]" class="reserveitem1" placeholder="每间优惠" value="" style="width:80px;" readonly="readonly">元
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="radio" name="reserveitem" id="res3" value="3" class="reserveitem"><label for="res3" style="display:initial;">连住X晚起，每间优惠</label><br><br>
						<input type="text" name="pricerule[4]" class="reserveitem1" placeholder="连住多少" value="" style="width:80px;" readonly="readonly">天&nbsp;
						<input type="text" name="pricerule[5]" class="reserveitem1" placeholder="每间优惠" value="" style="width:80px;" readonly="readonly">元
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="radio" name="reserveitem" id="res4" value="4" class="reserveitem"><label style="display:initial;" for="res4">连住X晚起，最后Y晚优惠</label><br><br>
						<input type="text" name="pricerule[6]" class="reserveitem1" placeholder="连住多少" value="" style="width:80px;" readonly="readonly">天&nbsp;
						<input type="text" name="pricerule[7]" class="reserveitem1" placeholder="最后多少" value="" style="width:80px;" readonly="readonly">晚&nbsp;
						<input type="text" name="pricerule[8]" class="reserveitem1" placeholder="优惠多少" value="" style="width:80px;" readonly="readonly">元
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="radio" name="reserveitem" id="res5" value="5" class="reserveitem"><label style="display:initial;" for="res5">连住X晚起，第Y晚及以后优惠</label><br><br>
						<input type="text" name="pricerule[9]" class="reserveitem1" placeholder="连住多少" value="" style="width:80px;" readonly="readonly">天&nbsp;
						<input type="text" name="pricerule[10]" class="reserveitem1" placeholder="第多少" value="" style="width:80px;" readonly="readonly">晚&nbsp;
						<input type="text" name="pricerule[11]" class="reserveitem1" placeholder="优惠多少" value="" style="width:80px;" readonly="readonly">元
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="radio" name="reserveitem" id="res6" value="6" class="reserveitem"><label style="display:initial;" for="res6">连住X晚起，最后Y晚优惠</label><br><br>
						<input type="text" name="pricerule[12]" class="reserveitem1" placeholder="每连住多少" value="" style="width:80px;" readonly="readonly">天&nbsp;
						<input type="text" name="pricerule[13]" class="reserveitem1" placeholder="最后多少" value="" style="width:80px;" readonly="readonly">晚&nbsp;
						<input type="text" name="pricerule[14]" class="reserveitem1" placeholder="优惠多少" value="" style="width:80px;" readonly="readonly">元
					</div>
				</div><hr>
				</div>
				<div id="baifenbi" style="display:none;">
					<div class="control-group">
					<div class="controls">
						<input type="radio" name="reserveitem" id="tem1" value="-1" class="reserveitem"><label style="display:initial;" for="tem1">平日价，每晚优惠/加价</label>
						<span class="form-required" style="color:red;">(如果想在基础价格上增加费用，可填写负数)</span><br></br>
						<input type="text" name="pricerule[-1]" class="reserveitem1" value="" style="width:80px;" readonly="readonly">%
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="radio" name="reserveitem" id="tem2" value="-2" class="reserveitem"><label style="display:initial;" for="tem2">提前X天预定，每间优惠</label><br><br>
						<input type="text" name="pricerule[-2]" class="reserveitem1" placeholder="提前多少" value="" style="width:80px;" readonly="readonly">天&nbsp;
						<input type="text" name="pricerule[-3]" class="reserveitem1" placeholder="每间优惠" value="" style="width:80px;" readonly="readonly">%
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="radio" name="reserveitem" id="tem3" value="-3" class="reserveitem"><label style="display:initial;" for="tem3">连住X晚起，每间优惠</label><br><br>
						<input type="text" name="pricerule[-4]" class="reserveitem1" placeholder="连住多少" value="" style="width:80px;" readonly="readonly">天&nbsp;
						<input type="text" name="pricerule[-5]" class="reserveitem1" placeholder="每间优惠" value="" style="width:80px;" readonly="readonly">%
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="radio" name="reserveitem" id="tem4" value="-4" class="reserveitem"><label style="display:initial;" for="tem4">连住X晚起，最后Y晚优惠</label><br><br>
						<input type="text" name="pricerule[-6]" class="reserveitem1" placeholder="连住多少" value="" style="width:80px;" readonly="readonly">天&nbsp;
						<input type="text" name="pricerule[-7]" class="reserveitem1" placeholder="最后多少" value="" style="width:80px;" readonly="readonly">晚&nbsp;
						<input type="text" name="pricerule[-8]" class="reserveitem1" placeholder="优惠多少" value="" style="width:80px;" readonly="readonly">%
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="radio" name="reserveitem" id="tem5" value="-5" class="reserveitem"><label style="display:initial;" for="tem5">连住X晚起，第Y晚及以后优惠</label><br><br>
						<input type="text" name="pricerule[-9]" class="reserveitem1" placeholder="连住多少" value="" style="width:80px;" readonly="readonly">天&nbsp;
						<input type="text" name="pricerule[-10]" class="reserveitem1" placeholder="第多少" value="" style="width:80px;" readonly="readonly">晚&nbsp;
						<input type="text" name="pricerule[-11]" class="reserveitem1" placeholder="优惠多少" value="" style="width:80px;" readonly="readonly">%
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="radio" name="reserveitem" id="tem6" value="-6" class="reserveitem"><label style="display:initial;" for="tem6">连住X晚起，最后Y晚优惠</label><br><br>
						<input type="text" name="pricerule[-12]" class="reserveitem1" placeholder="每连住多少" value="" style="width:80px;" readonly="readonly">天&nbsp;
						<input type="text" name="pricerule[-13]" class="reserveitem1" placeholder="最后多少" value="" style="width:80px;" readonly="readonly">晚&nbsp;
						<input type="text" name="pricerule[-14]" class="reserveitem1" placeholder="优惠多少" value="" style="width:80px;" readonly="readonly">%
					</div>
				</div><hr>
				</div>
				<h4>使用房型</h4><br>
				<div class="control-group">
					<div class="controls">
						<?php if(is_array($roomArr)): foreach($roomArr as $key=>$vo): ?><input type="checkbox" id="room[<?php echo ($vo["id"]); ?>]" name="roomid[]" value="<?php echo ($vo['id']); ?>"><label style="display:initial;" for="room[<?php echo ($vo["id"]); ?>]"><?php echo ($vo["room_name"]); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php endforeach; endif; ?>
					</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<button type="submit" class="btn btn-primary js-ajax-submit">添加</button>
				<a class="btn" href="<?php echo U('Hotel/rpindex');?>">返回</a>
			</div>
		</form>
	</div>
	<script type="text/javascript" src="/public/js/common.js"></script>
	<script type="text/javascript" src="/public/js/content_addtop.js"></script>
	<script src="/public/js/chosen/chosen_jquery_min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		$(".bfservice").on("click", function (){ 
			var bfservice1 = $(this);
				if(bfservice1[0].checked){ 
					bfservice1.next().attr("readonly",false);
				}else{ 
					bfservice1.next().attr("readonly",true);
				}
		});
		$(".reserveitem").on("click",function(){ 
			$(".reserveitem1").attr("readonly",true);
			var reserveitem1 = $(this);
			if(reserveitem1[0].checked){ 
				reserveitem1.nextAll().attr("readonly",false);
			}
		})
		$(".pricetype").on("click",function(){
			var pricetype = $(this);
			if(pricetype[0].checked){ 
				$("#baifenbi").hide();
				$("#jiage").show();
			}
		})
		$(".pricetype1").on("click",function(){
			var pricetype = $(this);
			if(pricetype[0].checked){ 
				$("#jiage").hide();
				$("#baifenbi").show();
			}
		})
	</script>
</body>
</html>