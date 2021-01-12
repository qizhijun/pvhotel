<?php if (!defined('THINK_PATH')) exit();?><html>

	<head>
		<meta charset="utf-8">
		<title>电谷国际酒店相册</title>
		<link rel="stylesheet" type="text/css" href="/themes/simplebootx_wx/Public/css/photo.css?2013-11-12-2" media="all">
		<link rel="stylesheet" type="text/css" href="/themes/simplebootx_wx/Public/css/photoswipe.css?2013-11-12-2" media="all">
		<script type="text/javascript" src="/themes/simplebootx_wx/Public/js/photo/jQuery.js?2013-11-12-2"></script>
		<script type="text/javascript" src="/themes/simplebootx_wx/Public/js/photo/jquery_imagesloaded.js?2013-11-12-2"></script>
		<script type="text/javascript" src="/themes/simplebootx_wx/Public/js/photo/jquery_wookmark_min.js?2013-11-12-2"></script>
		<script type="text/javascript" src="/themes/simplebootx_wx/Public/js/photo/lazyload.min.js"></script>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
		<!-- Mobile Devices Support @begin -->
		<meta content="application/xhtml+xml;charset=UTF-8" http-equiv="Content-Type">
		<meta content="no-cache,must-revalidate" http-equiv="Cache-Control">
		<meta content="no-cache" http-equiv="pragma">
		<meta content="0" http-equiv="expires">
		<meta content="telephone=no, address=no" name="format-detection">
		<meta content="width=device-width, initial-scale=1.0" name="viewport">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<!-- apple devices fullscreen -->
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
		<!-- Mobile Devices Support @end -->
		<link rel="shortcut icon" href="img/favicon.ico">
		<style>
			img {
				width: 100%!important;
			}
		</style>
	</head>

	<body onselectstart="return true;" ondragstart="return false;" id="photo">

		<style>
			#Gallery li {
				display: block;
				width: inherit;
				margin: 5px;
			}
			
			.album li p>span,
			.album1 li p>span,
			.album2 li p>span {
				float: right;
				color: #aaa;
				position: absolute;
				right: 5px;
				background: #fff;
				padding-left: 5px;
			}
			
			#Gallery li p {
				display: inline-block;
				max-width: 100%;
			}
			
			#Gallery li img {
				min-height: 200px;
			}
		</style>

		<div class="body">
			<div class="qiandaobanner">
				<a href="javascript:history.go(-1)">
					<img src="/themes/simplebootx_wx/Public/img/albums_head_url.jpg" alt="" style="max-height:200px;">
				</a>
			</div>
			<div id="main" role="main" class="album">
				<ul id="Gallery" class="gallery">
					<?php if(is_array($photoArr)): foreach($photoArr as $key=>$vo): $photourl = json_decode($vo['picurl'],true);$count = count($photourl['photo']); ?>
						<?php if($count > 0): ?><li style="">
							<a href="<?php echo U('Index/photo_img',array('id'=>$vo['id']));?>">
								<img data-original="<?php echo sp_get_asset_upload_path($photourl['photo'][0]['url']);?>" class="lazy_img" src="<?php echo sp_get_asset_upload_path($photourl['photo'][0]['url']);?>" style="display: block;">
								<p>
									<?php echo ($vo["name"]); ?><span>(<?php echo ($count); ?>张)</span>
								</p>
							</a>
						</li><?php endif; endforeach; endif; ?>
				</ul>
			</div>
		</div>
		<footer style="text-align:center; color:#ffd800;margin-right:20px;margin-top:0px;">
			<!-- <a href="">技术支持：123互联</a> -->
		</footer>

		<script>
			(function($) {
				$(function() {
					$('.lazy_img').lazyload({
						effect: 'fadeIn'
					});
				});
			})(jQuery);
		</script>

		<div mark="stat_code" style="width:0px; height:0px; display:none;"></div>

	</body>

</html>