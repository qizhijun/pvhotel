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
			<li><a href="<?php echo U('Hotel/fxindex');?>">房型管理</a></li>
			<li class="active"><a href="javascript:;">修改房型</a></li>
		</ul>
		<form method="post" class="form-horizontal js-ajax-form" action="<?php echo U('Hotel/fxedit_post');?>">
			<fieldset>
				<div class="control-group">
					<label class="control-label">房型名称</label>
					<div class="controls">
						<input type="hidden" name="id" value="<?php echo ($roomArr["id"]); ?>">
						<input type="text" name="room_name" value="<?php echo ($roomArr["room_name"]); ?>" style="width:300px;">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">排序</label>
					<div class="controls">
						<input type="text" name="sort_index" value="<?php echo ($roomArr["sort_index"]); ?>" style="width:80px;">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">面积</label>
					<div class="controls">
						<input type="text" name="room_area" value="<?php echo ($roomArr["room_area"]); ?>" style="width:80px;">
						<span class="form-required">平米</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">楼层</label>
					<div class="controls">
						<input type="text" name="floor" value="<?php echo ($roomArr["floor"]); ?>" style="width:120px;">
						<span class="form-required">层</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">床型</label>
					<div class="controls">
						<select name="category_type" style="width:100px;">
						<?php $category_type1=$roomArr['category_type']==1?"selected":""; ?>
						<?php $category_type2=$roomArr['category_type']==2?"selected":""; ?>
						<?php $category_type3=$roomArr['category_type']==3?"selected":""; ?>
							<option value="1" <?php echo ($category_type1); ?>>单人床</option>
							<option value="2" <?php echo ($category_type2); ?>>双床</option>
							<option value="3" <?php echo ($category_type3); ?>>大床</option>
						</select>
						<input type="text" name="bed_size" style="width:100px;" value="<?php echo ($roomArr["bed_size"]); ?>">
						<span class="form-required">米</span>
						<span class="form-required">（尺寸请填写宽度，例1.8米*2米，填写1.8）</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">最多可住</label>
					<div class="controls">
						<select name="imax_guestnum">
						<?php $imax_guestnum1=$roomArr['imax_guestnum']==1?"selected":""; ?>
						<?php $imax_guestnum2=$roomArr['imax_guestnum']==2?"selected":""; ?>
						<?php $imax_guestnum3=$roomArr['imax_guestnum']==3?"selected":""; ?>
						<?php $imax_guestnum4=$roomArr['imax_guestnum']==4?"selected":""; ?>
						<?php $imax_guestnum5=$roomArr['imax_guestnum']==5?"selected":""; ?>
						<?php $imax_guestnum6=$roomArr['imax_guestnum']==6?"selected":""; ?>
						<?php $imax_guestnum7=$roomArr['imax_guestnum']==7?"selected":""; ?>
						<?php $imax_guestnum8=$roomArr['imax_guestnum']==8?"selected":""; ?>
						<?php $imax_guestnum9=$roomArr['imax_guestnum']==9?"selected":""; ?>
						<?php $imax_guestnum10=$roomArr['imax_guestnum']==10?"selected":""; ?>
							<option value="1" <?php echo ($imax_guestnum1); ?>>1人</option>
							<option value="2" <?php echo ($imax_guestnum2); ?>>2人</option>
							<option value="3" <?php echo ($imax_guestnum3); ?>>3人</option>
							<option value="4" <?php echo ($imax_guestnum4); ?>>4人</option>
							<option value="5" <?php echo ($imax_guestnum5); ?>>5人</option>
							<option value="6" <?php echo ($imax_guestnum6); ?>>6人</option>
							<option value="7" <?php echo ($imax_guestnum7); ?>>7人</option>
							<option value="8" <?php echo ($imax_guestnum8); ?>>8人</option>
							<option value="9" <?php echo ($imax_guestnum9); ?>>9人</option>
							<option value="10" <?php echo ($imax_guestnum10); ?>>10人</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">是否能抽烟</label>
					<div class="controls">
						<input type="radio" id="no_smoking1" name="no_smoking" <?php echo ($roomArr[no_smoking] == 1 ? "checked" : ""); ?> value="1"><label style="display:initial;" for="no_smoking1">是</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" id="no_smoking2" name="no_smoking" <?php echo ($roomArr[no_smoking] == '-1' ? "checked" : ""); ?> value="-1"><label style="display:initial;" for="no_smoking2">否</label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">加床</label>
					<div class="controls">
						<input type="radio" id="max_addbed1" name="max_addbed" <?php echo ($roomArr[max_addbed] == 1 ? "checked" : ""); ?> value="1"><label for="max_addbed1" style="display:initial;">可以</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" id="max_addbed2" name="max_addbed" <?php echo ($roomArr[max_addbed] == '-1' ? "checked" : ""); ?> value="-1"><label style="display:initial;" for="max_addbed2">不可以</label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">房型图片</label>
					<div class="controls">
						<fieldset>
							<legend>图片列表</legend>
							<ul id="photos" class="pic-list unstyled">
								<?php if(is_array($pics['photo'])): foreach($pics['photo'] as $key=>$vo): ?><li id="savedimage<?php echo ($key); ?>">
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
					<label class="control-label">房型优惠促销信息</label>
					<div class="controls">
						<textarea name="descp" rows="6" cols="107" style="width:500px;"><?php echo ($roomArr["descp"]); ?></textarea>
						<span class="form-required">简短描述客房的优惠信息、优惠活动，经验证明这样可以更好的吸引客人订房。建议不要超过100字</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">房型信息</label>
					<div class="controls">
						<input type="radio" id="iroom_status1" name="iroom_status" <?php echo ($roomArr[iroom_status] == 1 ? "checked" : ""); ?> value="1"><label for="iroom_status1" style="display:initial;">有效</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" id="iroom_status2" name="iroom_status" <?php echo ($roomArr[iroom_status] == '-1' ? "checked" : ""); ?> value="-1"><label for="iroom_status2" style="display:initial;">无效</label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">添加客房设施</label>
					<div class="controls">
						<select class="acttype" name="facilities1[]" data-placeholder="添加客房设施" multiple="multiple">
						
							<optgroup label="便利设施">
								<?php if(is_array($facilities1)): foreach($facilities1 as $k=>$vo): ?><option value="<?php echo ($vo); ?>" <?php echo ($facilities[$vo]); ?>><?php echo ($vo); ?></option><?php endforeach; endif; ?>
							</optgroup>
							<optgroup label="媒体/科技">
								<?php if(is_array($facilities3)): foreach($facilities3 as $k=>$vo): ?><option value="<?php echo ($vo); ?>" <?php echo ($facilities[$vo]); ?>><?php echo ($vo); ?></option><?php endforeach; endif; ?>
							</optgroup>
						
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">房量</label>
					<div class="controls">
						<input type="text" name="total_number" value="<?php echo ($roomArr["total_number"]); ?>" style="width:120px;">
						<span class="form-required" style="color:red;">设置该房型每天默认的可订量，如果需要调整某天的可订量请在“价格管理”中修改房量</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">会员基础价</label>
					<div class="controls">
						<input type="text" name="clevel_price0" value="<?php echo ($roomArr["clevel_price0"]); ?>" style="width:120px;">
						<span class="form-required" style="color:red;">输入不高于OTA协议价，该价格用于普通用户的预订价格</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">价格类型</label>
					<div class="controls">
						<input type="radio" id="type1" name="pricetype" value="1" <?php echo ($roomArr[pricetype] == 1 ? "checked" : ""); ?> class="pricetype"><label for="type1" style="display:initial;">价格</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" id="type2" name="pricetype" value="2" class="pricetype1" <?php echo ($roomArr[pricetype] == 2 ? "checked" : ""); ?>><label style="display:initial;" for="type2">折扣</label>
						<span class="form-required" style="color:red;">注：当选择折扣时，填写10 表示无折扣</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">等级名称</label>
					<div id="jia" <?php if($roomArr['pricetype'] == 2): ?>style="display:none;"<?php endif; ?>>
					<div class="controls">
						E享会员卡<input type="text" name="levellst[1]" value="<?php echo ($levellst[1]); ?>" style="width:80px;">元
					</div>
					</div>
					<div id="zhe" <?php if($roomArr['pricetype'] == 1): ?>style="display:none;"<?php endif; ?>>
					<div class="controls">
						E享会员卡<input type="text" name="levellst[2]" value="<?php echo ($levellst[2]); ?>" style="width:80px;">折
					</div>
					</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<button type="submit" class="btn btn-primary js-ajax-submit">更新</button>
				<a class="btn" href="<?php echo U('Hotel/fxindex');?>">返回</a>
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
		$(".pricetype1").on("click",function(){
			var pricetype = $(this);
			if(pricetype[0].checked){
				$("#jia").hide();
				$("#zhe").show();
			}
		})
		$(".pricetype").on("click",function(){
			var pricetype = $(this);
			if(pricetype[0].checked){ 
				$("#zhe").hide();
				$("#jia").show();
			}
		})
	</script>
</body>
</html>