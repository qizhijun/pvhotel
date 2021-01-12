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
			<li><a href="<?php echo U('Hotel/xyylindex');?>">休闲娱乐管理</a></li>
			<li  class="active"><a href="javascript:;">编辑娱乐场所</a></li>
		</ul>
		<form action="<?php echo U('Hotel/xyyledit_post');?>" method="post" class="form-horizontal js-ajax-forms" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?php echo ($xyylArr["id"]); ?>">
			<fieldset>
				<div class="control-group">
					<label class="control-label">名称</label>
					<div class="controls">
						<input type="text" name="ename" value="<?php echo ($xyylArr["ename"]); ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">排序</label>
					<div class="controls">
						<input type="text" name="sortindex" value="<?php echo ($xyylArr["sortindex"]); ?>" style="width:80px;">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">类别</label>
					<div class="controls">
						<select name="etypeid" style="width:150px;">
						<?php if(is_array($etypeid)): foreach($etypeid as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>" <?php echo ($xyylArr['etypeid'] == $vo['id'] ? "selected" : ""); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">电话</label>
					<div class="controls">
						<input type="text" name="entel" value="<?php echo ($xyylArr["entel"]); ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">地址</label>
					<div class="controls">
						<input type="text" name="enaddress" value="<?php echo ($xyylArr["enaddress"]); ?>" style="width:400px;">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">休闲娱乐介绍头图</label>
					<div class="controls">
						<fieldset>
							<legend>图片列表</legend>
							<ul id="photos" class="pic-list unstyled">
								<?php if(is_array($picurl['photo'])): foreach($picurl['photo'] as $key=>$vo): ?><li id="savedimage<?php echo ($key); ?>">
									<input type="text" name="photos_url[]" value="<?php echo sp_get_asset_upload_path($vo['url']);?>" title="双击查看" style="width: 310px;" ondblclick="image_priview(this.value);" class="input image-url-input"> 
									<input type="text" name="photos_alt[]" value="<?php echo ($vo["alt"]); ?>" style="width: 160px;" class="input image-alt-input" onfocus="if(this.value == this.defaultValue) this.value = ''" onblur="if(this.value.replace(' ','') == '') this.value = this.defaultValue;">
									<a href="javascript:flashupload('replace_albums_images', '图片替换','savedimage<?php echo ($key); ?>',replace_image,'10,gif|jpg|jpeg|png|bmp,0','','','')">替换</a>
									<a href="javascript:remove_div('savedimage<?php echo ($key); ?>')">移除</a>
								</li><?php endforeach; endif; ?>
							</ul>
						</fieldset>
						<a href="javascript:;" onclick="javascript:flashupload('albums_images', '图片上传','photos',change_images,'10,gif|jpg|jpeg|png|bmp,0','','','')" class="btn btn-small" style="background-color:blue;">选择图片</a>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">营业时间</label>
					<div class="controls">
					<?php $begtime1=$xyylArr['begtime']==1?"selected":""; ?>
					<?php $begtime2=$xyylArr['begtime']==2?"selected":""; ?>
					<?php $begtime3=$xyylArr['begtime']==3?"selected":""; ?>
					<?php $begtime4=$xyylArr['begtime']==4?"selected":""; ?>
					<?php $begtime5=$xyylArr['begtime']==5?"selected":""; ?>
					<?php $begtime6=$xyylArr['begtime']==6?"selected":""; ?>
					<?php $begtime7=$xyylArr['begtime']==7?"selected":""; ?>
					<?php $begtime8=$xyylArr['begtime']==8?"selected":""; ?>
					<?php $begtime9=$xyylArr['begtime']==9?"selected":""; ?>
					<?php $begtime10=$xyylArr['begtime']==10?"selected":""; ?>
					<?php $begtime11=$xyylArr['begtime']==11?"selected":""; ?>
					<?php $begtime12=$xyylArr['begtime']==12?"selected":""; ?>
					<?php $begtime13=$xyylArr['begtime']==13?"selected":""; ?>
					<?php $begtime14=$xyylArr['begtime']==14?"selected":""; ?>
					<?php $begtime15=$xyylArr['begtime']==15?"selected":""; ?>
					<?php $begtime16=$xyylArr['begtime']==16?"selected":""; ?>
					<?php $begtime17=$xyylArr['begtime']==17?"selected":""; ?>
					<?php $begtime18=$xyylArr['begtime']==18?"selected":""; ?>
					<?php $begtime19=$xyylArr['begtime']==19?"selected":""; ?>
					<?php $begtime20=$xyylArr['begtime']==20?"selected":""; ?>
					<?php $begtime21=$xyylArr['begtime']==21?"selected":""; ?>
					<?php $begtime22=$xyylArr['begtime']==22?"selected":""; ?>
					<?php $begtime23=$xyylArr['begtime']==23?"selected":""; ?>
					<?php $begtime24=$xyylArr['begtime']==24?"selected":""; ?>
					<?php $begtime25=$xyylArr['begtime']==25?"selected":""; ?>
					<?php $begtime26=$xyylArr['begtime']==26?"selected":""; ?>
					<?php $begtime27=$xyylArr['begtime']==27?"selected":""; ?>
					<?php $begtime28=$xyylArr['begtime']==28?"selected":""; ?>
					<?php $begtime29=$xyylArr['begtime']==29?"selected":""; ?>
					<?php $begtime30=$xyylArr['begtime']==30?"selected":""; ?>
					<?php $begtime31=$xyylArr['begtime']==31?"selected":""; ?>
					<?php $begtime32=$xyylArr['begtime']==32?"selected":""; ?>
					<?php $begtime33=$xyylArr['begtime']==33?"selected":""; ?>
					<?php $begtime34=$xyylArr['begtime']==34?"selected":""; ?>
					<?php $begtime35=$xyylArr['begtime']==35?"selected":""; ?>
					<?php $begtime36=$xyylArr['begtime']==36?"selected":""; ?>
					<?php $begtime37=$xyylArr['begtime']==37?"selected":""; ?>
					<?php $begtime38=$xyylArr['begtime']==38?"selected":""; ?>
					<?php $begtime39=$xyylArr['begtime']==39?"selected":""; ?>
					<?php $begtime40=$xyylArr['begtime']==40?"selected":""; ?>
					<?php $begtime41=$xyylArr['begtime']==41?"selected":""; ?>
					<?php $begtime42=$xyylArr['begtime']==42?"selected":""; ?>
					<?php $begtime43=$xyylArr['begtime']==43?"selected":""; ?>
					<?php $begtime44=$xyylArr['begtime']==44?"selected":""; ?>
					<?php $begtime45=$xyylArr['begtime']==45?"selected":""; ?>
					<?php $begtime46=$xyylArr['begtime']==46?"selected":""; ?>
					<?php $begtime47=$xyylArr['begtime']==47?"selected":""; ?>
					<?php $begtime48=$xyylArr['begtime']==48?"selected":""; ?>
					<?php $begtime49=$xyylArr['begtime']==49?"selected":""; ?>
						<select name="begtime" style="width:130px;">
							<option value="1" <?php echo ($begtime1); ?>>1点</option>
							<option value="2" <?php echo ($begtime2); ?>>1点半</option>
							<option value="3" <?php echo ($begtime3); ?>>2点</option>
							<option value="4" <?php echo ($begtime4); ?>>2点半</option>
							<option value="5" <?php echo ($begtime5); ?>>3点</option>
							<option value="6" <?php echo ($begtime6); ?>>3点半</option>
							<option value="7" <?php echo ($begtime7); ?>>4点</option>
							<option value="8" <?php echo ($begtime8); ?>>4点半</option>
							<option value="9" <?php echo ($begtime9); ?>>5点</option>
							<option value="10" <?php echo ($begtime10); ?>>5点半</option>
							<option value="11" <?php echo ($begtime11); ?>>6点</option>
							<option value="12" <?php echo ($begtime12); ?>>6点半</option>
							<option value="13" <?php echo ($begtime13); ?>>7点</option>
							<option value="14" <?php echo ($begtime14); ?>>7点半</option>
							<option value="15" <?php echo ($begtime15); ?>>8点</option>
							<option value="16" <?php echo ($begtime16); ?>>8点半</option>
							<option value="17" <?php echo ($begtime17); ?>>9点</option>
							<option value="18" <?php echo ($begtime18); ?>>9点半</option>
							<option value="19" <?php echo ($begtime19); ?>>10点</option>
							<option value="20" <?php echo ($begtime20); ?>>10点半</option>
							<option value="21" <?php echo ($begtime21); ?>>11点</option>
							<option value="22" <?php echo ($begtime22); ?>>11点半</option>
							<option value="23" <?php echo ($begtime23); ?>>12点</option>
							<option value="24" <?php echo ($begtime24); ?>>12点半</option>
							<option value="25" <?php echo ($begtime25); ?>>13点</option>
							<option value="26" <?php echo ($begtime26); ?>>13点半</option>
							<option value="27" <?php echo ($begtime27); ?>>14点</option>
							<option value="28" <?php echo ($begtime28); ?>>14点半</option>
							<option value="29" <?php echo ($begtime29); ?>>15点</option>
							<option value="30" <?php echo ($begtime30); ?>>15点半</option>
							<option value="31" <?php echo ($begtime31); ?>>16点</option>
							<option value="32" <?php echo ($begtime32); ?>>16点半</option>
							<option value="33" <?php echo ($begtime33); ?>>17点</option>
							<option value="34" <?php echo ($begtime34); ?>>17点半</option>
							<option value="35" <?php echo ($begtime35); ?>>18点</option>
							<option value="36" <?php echo ($begtime36); ?>>18点半</option>
							<option value="37" <?php echo ($begtime37); ?>>19点</option>
							<option value="38" <?php echo ($begtime38); ?>>19点半</option>
							<option value="39" <?php echo ($begtime39); ?>>20点</option>
							<option value="40" <?php echo ($begtime40); ?>>20点半</option>
							<option value="41" <?php echo ($begtime41); ?>>21点</option>
							<option value="42" <?php echo ($begtime42); ?>>21点半</option>
							<option value="43" <?php echo ($begtime43); ?>>22点</option>
							<option value="44" <?php echo ($begtime44); ?>>22点半</option>
							<option value="45" <?php echo ($begtime45); ?>>23点</option>
							<option value="46" <?php echo ($begtime46); ?>>23点半</option>
							<option value="47" <?php echo ($begtime47); ?>>0点</option>
							<option value="48" <?php echo ($begtime48); ?>>0点半</option>
						</select>
						到
						<?php $endtime1=$xyylArr['endtime']==1?"selected":""; ?>
						<?php $endtime2=$xyylArr['endtime']==2?"selected":""; ?>
						<?php $endtime3=$xyylArr['endtime']==3?"selected":""; ?>
						<?php $endtime4=$xyylArr['endtime']==4?"selected":""; ?>
						<?php $endtime5=$xyylArr['endtime']==5?"selected":""; ?>
						<?php $endtime6=$xyylArr['endtime']==6?"selected":""; ?>
						<?php $endtime7=$xyylArr['endtime']==7?"selected":""; ?>
						<?php $endtime8=$xyylArr['endtime']==8?"selected":""; ?>
						<?php $endtime9=$xyylArr['endtime']==9?"selected":""; ?>
						<?php $endtime10=$xyylArr['endtime']==10?"selected":""; ?>
						<?php $endtime11=$xyylArr['endtime']==11?"selected":""; ?>
						<?php $endtime12=$xyylArr['endtime']==12?"selected":""; ?>
						<?php $endtime13=$xyylArr['endtime']==13?"selected":""; ?>
						<?php $endtime14=$xyylArr['endtime']==14?"selected":""; ?>
						<?php $endtime15=$xyylArr['endtime']==15?"selected":""; ?>
						<?php $endtime16=$xyylArr['endtime']==16?"selected":""; ?>
						<?php $endtime17=$xyylArr['endtime']==17?"selected":""; ?>
						<?php $endtime18=$xyylArr['endtime']==18?"selected":""; ?>
						<?php $endtime19=$xyylArr['endtime']==19?"selected":""; ?>
						<?php $endtime20=$xyylArr['endtime']==20?"selected":""; ?>
						<?php $endtime21=$xyylArr['endtime']==21?"selected":""; ?>
						<?php $endtime22=$xyylArr['endtime']==22?"selected":""; ?>
						<?php $endtime23=$xyylArr['endtime']==23?"selected":""; ?>
						<?php $endtime24=$xyylArr['endtime']==24?"selected":""; ?>
						<?php $endtime25=$xyylArr['endtime']==25?"selected":""; ?>
						<?php $endtime26=$xyylArr['endtime']==26?"selected":""; ?>
						<?php $endtime27=$xyylArr['endtime']==27?"selected":""; ?>
						<?php $endtime28=$xyylArr['endtime']==28?"selected":""; ?>
						<?php $endtime29=$xyylArr['endtime']==29?"selected":""; ?>
						<?php $endtime30=$xyylArr['endtime']==30?"selected":""; ?>
						<?php $endtime31=$xyylArr['endtime']==31?"selected":""; ?>
						<?php $endtime32=$xyylArr['endtime']==32?"selected":""; ?>
						<?php $endtime33=$xyylArr['endtime']==33?"selected":""; ?>
						<?php $endtime34=$xyylArr['endtime']==34?"selected":""; ?>
						<?php $endtime35=$xyylArr['endtime']==35?"selected":""; ?>
						<?php $endtime36=$xyylArr['endtime']==36?"selected":""; ?>
						<?php $endtime37=$xyylArr['endtime']==37?"selected":""; ?>
						<?php $endtime38=$xyylArr['endtime']==38?"selected":""; ?>
						<?php $endtime39=$xyylArr['endtime']==39?"selected":""; ?>
						<?php $endtime40=$xyylArr['endtime']==40?"selected":""; ?>
						<?php $endtime41=$xyylArr['endtime']==41?"selected":""; ?>
						<?php $endtime42=$xyylArr['endtime']==42?"selected":""; ?>
						<?php $endtime43=$xyylArr['endtime']==43?"selected":""; ?>
						<?php $endtime44=$xyylArr['endtime']==44?"selected":""; ?>
						<?php $endtime45=$xyylArr['endtime']==45?"selected":""; ?>
						<?php $endtime46=$xyylArr['endtime']==46?"selected":""; ?>
						<?php $endtime47=$xyylArr['endtime']==47?"selected":""; ?>
						<?php $endtime48=$xyylArr['endtime']==48?"selected":""; ?>
						<select name="endtime" style="width:130px;">
							<option value="1" <?php echo ($endtime1); ?>>1点</option>
							<option value="2" <?php echo ($endtime2); ?>>1点半</option>
							<option value="3" <?php echo ($endtime3); ?>>2点</option>
							<option value="4" <?php echo ($endtime4); ?>>2点半</option>
							<option value="5" <?php echo ($endtime5); ?>>3点</option>
							<option value="6" <?php echo ($endtime6); ?>>3点半</option>
							<option value="7" <?php echo ($endtime7); ?>>4点</option>
							<option value="8" <?php echo ($endtime8); ?>>4点半</option>
							<option value="9" <?php echo ($endtime9); ?>>5点</option>
							<option value="10" <?php echo ($endtime10); ?>>5点半</option>
							<option value="11" <?php echo ($endtime11); ?>>6点</option>
							<option value="12" <?php echo ($endtime12); ?>>6点半</option>
							<option value="13" <?php echo ($endtime13); ?>>7点</option>
							<option value="14" <?php echo ($endtime14); ?>>7点半</option>
							<option value="15" <?php echo ($endtime15); ?>>8点</option>
							<option value="16" <?php echo ($endtime16); ?>>8点半</option>
							<option value="17" <?php echo ($endtime17); ?>>9点</option>
							<option value="18" <?php echo ($endtime18); ?>>9点半</option>
							<option value="19" <?php echo ($endtime19); ?>>10点</option>
							<option value="20" <?php echo ($endtime20); ?>>10点半</option>
							<option value="21" <?php echo ($endtime21); ?>>11点</option>
							<option value="22" <?php echo ($endtime22); ?>>11点半</option>
							<option value="23" <?php echo ($endtime23); ?>>12点</option>
							<option value="24" <?php echo ($endtime24); ?>>12点半</option>
							<option value="25" <?php echo ($endtime25); ?>>13点</option>
							<option value="26" <?php echo ($endtime26); ?>>13点半</option>
							<option value="27" <?php echo ($endtime27); ?>>14点</option>
							<option value="28" <?php echo ($endtime28); ?>>14点半</option>
							<option value="29" <?php echo ($endtime29); ?>>15点</option>
							<option value="30" <?php echo ($endtime30); ?>>15点半</option>
							<option value="31" <?php echo ($endtime31); ?>>16点</option>
							<option value="32" <?php echo ($endtime32); ?>>16点半</option>
							<option value="33" <?php echo ($endtime33); ?>>17点</option>
							<option value="34" <?php echo ($endtime34); ?>>17点半</option>
							<option value="35" <?php echo ($endtime35); ?>>18点</option>
							<option value="36" <?php echo ($endtime36); ?>>18点半</option>
							<option value="37" <?php echo ($endtime37); ?>>19点</option>
							<option value="38" <?php echo ($endtime38); ?>>19点半</option>
							<option value="39" <?php echo ($endtime39); ?>>20点</option>
							<option value="40" <?php echo ($endtime40); ?>>20点半</option>
							<option value="41" <?php echo ($endtime41); ?>>21点</option>
							<option value="42" <?php echo ($endtime42); ?>>21点半</option>
							<option value="43" <?php echo ($endtime43); ?>>22点</option>
							<option value="44" <?php echo ($endtime44); ?>>22点半</option>
							<option value="45" <?php echo ($endtime45); ?>>23点</option>
							<option value="46" <?php echo ($endtime46); ?>>23点半</option>
							<option value="47" <?php echo ($endtime47); ?>>0点</option>
							<option value="48" <?php echo ($endtime48); ?>>0点半</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">人均消费</label>
					<div class="controls">
						<input type="text" name="perperson" value="<?php echo ($xyylArr["perperson"]); ?>" style="width:130px;">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">预定方式</label>
					<div class="controls">
						<input type="radio" id="suppre1" name="suppretype" value="1" <?php echo ($xyylArr['suppretype'] == 1 ? "checked" : ""); ?>><label style="display:initial;" for="suppre1">电话预定</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" id="suppre2" name="suppretype" value="2" <?php echo ($xyylArr['suppretype'] == 2 ? "checked" : ""); ?>><label style="display:initial;" for="suppre2">在线预订</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" id="suppre3" name="suppretype" value="3" <?php echo ($xyylArr['suppretype'] == 3 ? "checked" : ""); ?>><label style="display:initial;" for="suppre3">全部支持</label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">是否能抽烟</label>
					<div class="controls">
						<input type="radio" id="issmoking1" name="issmoking" value="1" <?php echo ($xyylArr['issmoking'] == 1 ? "checked" : ""); ?>><label style="display:initial;" for="issmoking1">有</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" id="issmoking2" name="issmoking" value="-1" <?php echo ($xyylArr['issmoking'] == '-1' ? "checked" : ""); ?>><label style="display:initial;" for="issmoking2">没有</label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">360度全景</label>
					<div class="controls">
						<input type="text" name="tshpanoramaurl" value="<?php echo ($xyylArr["tshpanoramaurl"]); ?>" style="width:500px;">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">休闲娱乐介绍</label>
					<div class="controls">
						<script type="text/plain" id="content" name="des" style="width:650px;height:400px;"><?php echo ($xyylArr["des"]); ?></script>
					</div>
				</div>
				<hr>
				<div class="control-group">
					<h4>会员等级折扣注册</h4>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="checkbox" id="saled" name="saledisontime" value="1" <?php echo ($xyylArr['saledisontime'] == 1 ? "checked" : ""); ?>>
						<label style="display:initial;" for="saled"><span class="form-required">是否支持优惠券与折扣策略同时使用</span></label><br><br>
						<input type="checkbox" id="scored" name="scoredisontime" value="1" <?php echo ($xyylArr['scoredisontime'] == 1 ? "checked" : ""); ?>>
						<label style="display:initial;" for="scored"><span class="form-required">是否支持积分抵扣与折扣策略同时使用</span></label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">默认折扣</label>
					<div class="controls">
						<input type="text" name="clevelprice" value="<?php echo ($xyylArr["clevelprice"]); ?>" style="width:80px;">折
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">E享会员卡</label>
					<div class="controls">
						<input type="text" name="leveldiscount" value="<?php echo ($xyylArr["leveldiscount"]); ?>" style="width:80px;">折
					</div>
				</div>
				<hr>
				<div class="control-group">
					<h4>取消订单条款</h4>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="checkbox" id="isrefund" name="isrefund" value="1" <?php echo ($xyylArr['isrefund'] == 1 ? "checked" : ""); ?>>
						<label style="display:initial;" for="isrefund"><span class="form-required">在线支付是否支持取消订单</span></label><br>
				</div>
				</div>
				<div class="control-group">
				<div class="controls">
					提前<input type="text" name="beforehour" value="<?php echo ($xyylArr["beforehour"]); ?>" style="width:80px;">小时
					&nbsp;退款比例<input type="text" name="refundper" value="<?php echo ($xyylArr["beforehour"]); ?>" style="width:80px;">%<br>
					<span class="form-required">例如：提前12小时，100%退款，12小时内0%退款。</span>
				</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<button type="submit" class="btn btn-primary js-ajax-submit">更新</button>
				<a class="btn" href="<?php echo U('Hotel/xyylindex');?>">返回</a>
			</div>
		</form>
	</div>
	<script type="text/javascript" src="/public/js/common.js"></script>
	<script type="text/javascript" src="/public/js/content_addtop.js"></script>
	<script src="/public/js/chosen/chosen_jquery_min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		$(function(){
			//初始化下拉框
			$(".acttype").chosen();
		});
	</script>
	<script type="text/javascript">
		//编辑器路径定义
		var editorURL = GV.DIMAUB;
	</script>
	<script type="text/javascript" src="/public/js/ueditor/ueditor.config.js"></script>
	<script type="text/javascript" src="/public/js/ueditor/ueditor.all.min.js"></script>
	<script type="text/javascript">
		$(function() {
			//setInterval(function(){public_lock_renewal();}, 10000);
			$(".js-ajax-close-btn").on('click', function(e) {
				e.preventDefault();
				Wind.use("artDialog", function() {
					art.dialog({
						id : "question",
						icon : "question",
						fixed : true,
						lock : true,
						background : "#CCCCCC",
						opacity : 0,
						content : "您确定需要关闭当前页面嘛？",
						ok : function() {
							setCookie("refersh_time", 1);
							window.close();
							return true;
						}
					});
				});
			});
			/////---------------------
			Wind.use('validate', 'ajaxForm', 'artDialog', function() {
				//javascript

				//编辑器
				editorcontent = new baidu.editor.ui.Editor();
				editorcontent.render('content');
				try {
					editorcontent.sync();
				} catch (err) {
				}
				//增加编辑器验证规则
				jQuery.validator.addMethod('editorcontent', function() {
					try {
						editorcontent.sync();
					} catch (err) {
					}
					;
					return editorcontent.hasContents();
				});
				var form = $('form.js-ajax-forms');
				//ie处理placeholder提交问题
				if ($.browser.msie) {
					form.find('[placeholder]').each(function() {
						var input = $(this);
						if (input.val() == input.attr('placeholder')) {
							input.val('');
						}
					});
				}
				//表单验证开始
				form.validate({
					//是否在获取焦点时验证
					onfocusout : false,
					//是否在敲击键盘时验证
					onkeyup : false,
					//当鼠标掉级时验证
					onclick : false,
					//验证错误
					showErrors : function(errorMap, errorArr) {
						//errorMap {'name':'错误信息'}
						//errorArr [{'message':'错误信息',element:({})}]
						try {
							$(errorArr[0].element).focus();
							art.dialog({
								id : 'error',
								icon : 'error',
								lock : true,
								fixed : true,
								background : "#CCCCCC",
								opacity : 0,
								content : errorArr[0].message,
								cancelVal : '确定',
								cancel : function() {
									$(errorArr[0].element).focus();
								}
							});
						} catch (err) {
						}
					},
					//验证规则
					rules : {
						'post[post_title]' : {
							required : 1
						},
						'post[post_content]' : {
							editorcontent : true
						}
					},
					//验证未通过提示消息
					messages : {
						'post[post_title]' : {
							required : '请输入标题'
						},
						'post[post_content]' : {
							editorcontent : '内容不能为空'
						}
					},
					//给未通过验证的元素加效果,闪烁等
					highlight : false,
					//是否在获取焦点时验证
					onfocusout : false,
					//验证通过，提交表单
					submitHandler : function(forms) {
						$(forms).ajaxSubmit({
							url : form.attr('action'), //按钮上是否自定义提交地址(多按钮情况)
							dataType : 'json',
							beforeSubmit : function(arr, $form, options) {

							},
							success : function(data, statusText, xhr, $form) {
								if (data.status) {
									setCookie("refersh_time", 1);
									//添加成功
									Wind.use("artDialog", function() {
										art.dialog({
											id : "succeed",
											icon : "succeed",
											fixed : true,
											lock : true,
											background : "#CCCCCC",
											opacity : 0,
											content : data.info,
											button : [ {
												name : '继续编辑？',
												callback : function() {
													//reloadPage(window);
													return true;
												},
												focus : true
											}, {
												name : '返回列表页',
												callback : function() {
													location = "<?php echo U('Hotel/xyylindex');?>";
													return true;
												}
											} ]
										});
									});
								} else {
									isalert(data.info);
								}
							}
						});
					}
				});
			});
			////-------------------------
		});
	</script>
</body>
</html>