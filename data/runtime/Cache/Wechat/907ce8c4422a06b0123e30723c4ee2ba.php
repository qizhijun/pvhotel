<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<link rel="stylesheet" href="/themes/simplebootx_wx/Public/css/appReset.css" />
		<link rel="stylesheet" href="/themes/simplebootx_wx/Public/css/reg.css" />
		<link rel="stylesheet" href="/themes/simplebootx_wx/Public/js/myDialog/dialog.css" />
		<title>员工通道</title>
	</head>

	<body baseurl="">
		<div class="warp-body">
			<form>
				<div class="form-layout">
					<label class="bor-bom">
						<input type="text" name="" id="name" value="" class="text-1" placeholder="请输入姓名" />
					</label>
					<label class="bor-bom">
						<input type="tel" name="" id="phone" value="" class="text" placeholder="请输入手机号" />
					</label>
					<label>
						<input type="tel" name="" id="vcode" value="" class="text-2" placeholder="请输入验证码" />
						<span id="btn_vcode" class="yzm">获取验证码</span>
					</label>
				</div>
				<a href="javascript:;" id="btn_sub" class="btn">认证员工</a>
				<p class="text">通过管理员审核后，可以收到工资通知</p>
			</form>
		</div>
		
		<script src="/themes/simplebootx_wx/Public/js/amd/require.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript">
			var VERSION=20160914;
			requirejs.config({
			    baseUrl: '/themes/simplebootx_wx/Public/js',
			    shim: {},
			    paths: {
			        zepto: 'amd/zepto.all',
			        iDialog:'myDialog/dialog_min',
			        utils:'utils'
			    },
			    urlArgs: "_="+VERSION
			});
		</script>
		<script src="/themes/simplebootx_wx/Public/js/salary/reg.js" type="text/javascript" charset="utf-8"></script>
	</body>

</html>