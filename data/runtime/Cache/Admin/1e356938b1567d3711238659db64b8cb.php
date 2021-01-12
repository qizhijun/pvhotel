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
			<li><a href="<?php echo U('Hotel/photo');?>">返回</a></li>
			<li  class="active"><a href="javascript:;">编辑图片</a></li>
		</ul>
		<form action="<?php echo U('Hotel/photoedit_post');?>" method="post" class="form-horizontal js-ajax-forms" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?php echo ($picArr["id"]); ?>">
			<fieldset>
				<div class="control-group">
					<label class="control-label">图片</label>
					<div class="controls">
						<fieldset>
							<ul id="photos" class="pic-list unstyled">
								<?php if(is_array($pics['photo'])): foreach($pics['photo'] as $key=>$vo): ?><li id="savedimage<?php echo ($key); ?>">
									<input type="hidden" name="id" value="<?php echo ($picArr["id"]); ?>">
									<input type="text" name="photos_url[]" value="<?php echo sp_get_asset_upload_path($vo['url']);?>" title="双击查看" style="width: 310px;" ondblclick="image_priview(this.value);" class="input image-url-input"> 
									<input type="text" name="photos_alt[]" value="<?php echo ($vo["alt"]); ?>" style="width: 160px;" class="input image-alt-input" onfocus="if(this.value == this.defaultValue) this.value = ''" onblur="if(this.value.replace(' ','') == '') this.value = this.defaultValue;">
									<a href="javascript:flashupload('replace_albums_images', '图片替换','savedimage<?php echo ($key); ?>',replace_image,'10,gif|jpg|jpeg|png|bmp,0','','','')">替换</a>
									<a href="javascript:remove_div('savedimage<?php echo ($key); ?>')">移除</a>
								</li><?php endforeach; endif; ?>
							</ul>
						</fieldset>
						<a href="javascript:;" onclick="javascript:flashupload('albums_images', '图片上传','photos',change_images,'10,gif|jpg|jpeg|png|bmp,0','','','')" class="btn btn-small">选择图片</a>
					</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<button type="submit" class="btn btn-primary js-ajax-submit">提交</button>
			</div>
		</form>
	</div>
	<script type="text/javascript" src="/public/js/common.js"></script>
	<script type="text/javascript" src="/public/js/content_addtop.js"></script>
	<script src="/public/js/chosen/chosen_jquery_min.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>