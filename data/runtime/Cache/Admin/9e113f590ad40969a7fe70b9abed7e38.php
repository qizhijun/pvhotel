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
			<li class="active"><a href="javascript:;">酒店信息</a></li>
		</ul>
		<form action="<?php echo U('Hotel/info_post');?>" method="post" class="form-horizontal js-ajax-forms" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?php echo ($hotel_info["id"]); ?>">
			<fieldset>
				<div class="control-group">
					<label class="control-label">酒店名称</label>
					<div class="controls">
						<input type="text" name="hotel_name" value="<?php echo ($hotel_info["hotel_name"]); ?>" style="width:300px;">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">排序</label>
					<div class="controls">
						<input type="text" name="sortindex" value="<?php echo ($hotel_info["sortindex"]); ?>" style="width:80px;">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">酒店类型</label>
					<div class="controls">
						<select name="hotel_type" style="width:150px;">
						<?php if(is_array($hotelType)): foreach($hotelType as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>" <?php echo ($hotel_info['hotel_type'] == $vo['id'] ? "selected" : ""); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">酒店星级</label>
					<div class="controls">
						<select name="hotel_star">
						<?php if(is_array($hotelStar)): foreach($hotelStar as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>" <?php echo ($hotel_info['hotel_star'] == $vo['id'] ? "selected" : ""); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">酒店电话</label>
					<div class="controls">
						<input type="text" name="hotel_tel" value="<?php echo ($hotel_info["hotel_tel"]); ?>" style="width:180px;">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">短信接收电话</label>
					<div class="controls">
						<input type="text" name="order_tel" value="<?php echo ($hotel_info["order_tel"]); ?>" required="required" maxlength="11" style="width:180px;">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">传真</label>
					<div class="controls">
						<input type="text" name="hotel_fax" value="<?php echo ($hotel_info["hotel_fax"]); ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">酒店网址</label>
					<div class="controls">
						<input type="text" name="hotel_site" value="<?php echo ($hotel_info["hotel_site"]); ?>" style="width:500px;">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">360全景图</label>
					<div class="controls">
						<input type="text" name="tshpanorama_url" value="<?php echo ($hotel_info["tshpanorama_url"]); ?>" style="width:500px;">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">开业时间</label>
					<div class="controls">
						<input type="text" name="hotel_open_time" class="js-date" value="<?php echo ($hotel_open_time); ?>" autocomplete="off" style="width:150px;">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">最近一次装修日期</label>
					<div class="controls">
						<input type="text" class="js-date" name="lastdecoratedate" value="<?php echo ($lastdecoratedate); ?>" autocomplete="off" style="width:150px;">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">添加客房设施</label>
					<div class="controls">
						<select class="acttype" name="facilities[]" data-placeholder="添加客房设施" multiple="multiple">
						
							<optgroup label="便利设施">
								<?php if(is_array($facilities1)): foreach($facilities1 as $k=>$vo): ?><option value="<?php echo ($vo); ?>" <?php echo ($facilities[$vo]); ?>><?php echo ($vo); ?></option><?php endforeach; endif; ?>
							</optgroup>
							<optgroup label="媒体/科技">
								<?php if(is_array($facilities3)): foreach($facilities3 as $k=>$vo): ?><option value="<?php echo ($vo); ?>" <?php echo ($facilities[$vo]); ?>><?php echo ($vo); ?></option><?php endforeach; endif; ?>
							</optgroup>
						</select>
					</div>
				</div>
				<hr>
				<h4>预定、入住</h4>
				<div class="control-group">
					<label class="control-label">总房量</label>
					<div class="controls">
						<input type="text" name="room_count" value="<?php echo ($hotel_info["room_count"]); ?>" style="width:120px;">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">最早可预定</label>
					<div class="controls">
					<?php $maxdays1=$hotel_info['maxdays']==1?"selected":""; ?>
					<?php $maxdays2=$hotel_info['maxdays']==2?"selected":""; ?>
					<?php $maxdays3=$hotel_info['maxdays']==3?"selected":""; ?>
					<?php $maxdays4=$hotel_info['maxdays']==4?"selected":""; ?>
					<?php $maxdays5=$hotel_info['maxdays']==5?"selected":""; ?>
						<select name="maxdays">
							<option value="1" <?php echo ($maxdays1); ?>>30天</option>
							<option value="2" <?php echo ($maxdays2); ?>>60天</option>
							<option value="3" <?php echo ($maxdays3); ?>>90天</option>
							<option value="4" <?php echo ($maxdays4); ?>>半年</option>
							<option value="5" <?php echo ($maxdays5); ?>>一年</option>
						</select>
						<p>客人最早提前预订的天数,默认90天 可以根据酒店的实际情况进行调整</p>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">客房保留时点</label>
					<div class="controls">
					<?php $liutime1=$hotel_info['liutime']==1?"selected":""; ?>
					<?php $liutime2=$hotel_info['liutime']==2?"selected":""; ?>
					<?php $liutime3=$hotel_info['liutime']==3?"selected":""; ?>
					<?php $liutime4=$hotel_info['liutime']==4?"selected":""; ?>
					<?php $liutime5=$hotel_info['liutime']==5?"selected":""; ?>
					<?php $liutime6=$hotel_info['liutime']==6?"selected":""; ?>
					<?php $liutime7=$hotel_info['liutime']==7?"selected":""; ?>
					<?php $liutime8=$hotel_info['liutime']==8?"selected":""; ?>
					<?php $liutime9=$hotel_info['liutime']==9?"selected":""; ?>
					<?php $liutime10=$hotel_info['liutime']==10?"selected":""; ?>
					<?php $liutime11=$hotel_info['liutime']==11?"selected":""; ?>
					<?php $liutime12=$hotel_info['liutime']==12?"selected":""; ?>
					<?php $liutime13=$hotel_info['liutime']==13?"selected":""; ?>
					<?php $liutime14=$hotel_info['liutime']==14?"selected":""; ?>
					<?php $liutime15=$hotel_info['liutime']==15?"selected":""; ?>
					<?php $liutime16=$hotel_info['liutime']==16?"selected":""; ?>
					<?php $liutime17=$hotel_info['liutime']==17?"selected":""; ?>
					<?php $liutime18=$hotel_info['liutime']==18?"selected":""; ?>
					<?php $liutime19=$hotel_info['liutime']==19?"selected":""; ?>
					<?php $liutime20=$hotel_info['liutime']==20?"selected":""; ?>
					<?php $liutime21=$hotel_info['liutime']==21?"selected":""; ?>
					<?php $liutime22=$hotel_info['liutime']==22?"selected":""; ?>
					<?php $liutime23=$hotel_info['liutime']==23?"selected":""; ?>
					<?php $liutime24=$hotel_info['liutime']==24?"selected":""; ?>
						<select name="liutime">
							<option value="1" <?php echo ($liutime1); ?>>1点钟</option>
							<option value="2" <?php echo ($liutime2); ?>>2点钟</option>
							<option value="3" <?php echo ($liutime3); ?>>3点钟</option>
							<option value="4" <?php echo ($liutime4); ?>>4点钟</option>
							<option value="5" <?php echo ($liutime5); ?>>5点钟</option>
							<option value="6" <?php echo ($liutime6); ?>>6点钟</option>
							<option value="7" <?php echo ($liutime7); ?>>7点钟</option>
							<option value="8" <?php echo ($liutime8); ?>>8点钟</option>
							<option value="9" <?php echo ($liutime9); ?>>9点钟</option>
							<option value="10" <?php echo ($liutime10); ?>>10点钟</option>
							<option value="11" <?php echo ($liutime11); ?>>11点钟</option>
							<option value="12" <?php echo ($liutime12); ?>>12点钟</option>
							<option value="13" <?php echo ($liutime13); ?>>13点钟</option>
							<option value="14" <?php echo ($liutime14); ?>>14点钟</option>
							<option value="15" <?php echo ($liutime15); ?>>15点钟</option>
							<option value="16" <?php echo ($liutime16); ?>>16点钟</option>
							<option value="17" <?php echo ($liutime17); ?>>17点钟</option>
							<option value="18" <?php echo ($liutime18); ?>>18点钟</option>
							<option value="19" <?php echo ($liutime19); ?>>19点钟</option>
							<option value="20" <?php echo ($liutime20); ?>>20点钟</option>
							<option value="21" <?php echo ($liutime21); ?>>21点钟</option>
							<option value="22" <?php echo ($liutime22); ?>>22点钟</option>
							<option value="23" <?php echo ($liutime23); ?>>23点钟</option>
							<option value="24" <?php echo ($liutime24); ?>>不限</option>
						</select>
						<p>针对到店付款的预订，客房可以设置最晚保留时点，如果客人在该时点以后才能到店，则强制客人在线支付</p>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">最早办理入住时间</label>
					<div class="controls">
					<?php $earlieintime1=$hotel_info['earlieintime']==1?"selected":""; ?>
					<?php $earlieintime2=$hotel_info['earlieintime']==2?"selected":""; ?>
					<?php $earlieintime3=$hotel_info['earlieintime']==3?"selected":""; ?>
					<?php $earlieintime4=$hotel_info['earlieintime']==4?"selected":""; ?>
					<?php $earlieintime5=$hotel_info['earlieintime']==5?"selected":""; ?>
					<?php $earlieintime6=$hotel_info['earlieintime']==6?"selected":""; ?>
					<?php $earlieintime7=$hotel_info['earlieintime']==7?"selected":""; ?>
					<?php $earlieintime8=$hotel_info['earlieintime']==8?"selected":""; ?>
					<?php $earlieintime9=$hotel_info['earlieintime']==9?"selected":""; ?>
					<?php $earlieintime10=$hotel_info['earlieintime']==10?"selected":""; ?>
					<?php $earlieintime11=$hotel_info['earlieintime']==11?"selected":""; ?>
					<?php $earlieintime12=$hotel_info['earlieintime']==12?"selected":""; ?>
					<?php $earlieintime13=$hotel_info['earlieintime']==13?"selected":""; ?>
					<?php $earlieintime14=$hotel_info['earlieintime']==14?"selected":""; ?>
					<?php $earlieintime15=$hotel_info['earlieintime']==15?"selected":""; ?>
					<?php $earlieintime16=$hotel_info['earlieintime']==16?"selected":""; ?>
					<?php $earlieintime17=$hotel_info['earlieintime']==17?"selected":""; ?>
					<?php $earlieintime18=$hotel_info['earlieintime']==18?"selected":""; ?>
					<?php $earlieintime19=$hotel_info['earlieintime']==18?"selected":""; ?>
					<?php $earlieintime20=$hotel_info['earlieintime']==20?"selected":""; ?>
					<?php $earlieintime21=$hotel_info['earlieintime']==21?"selected":""; ?>
					<?php $earlieintime22=$hotel_info['earlieintime']==22?"selected":""; ?>
					<?php $earlieintime23=$hotel_info['earlieintime']==23?"selected":""; ?>
					<?php $earlieintime24=$hotel_info['earlieintime']==24?"selected":""; ?>
						<select name="earlieintime">
							<option value="1" <?php echo ($earlieintime1); ?>>1点钟</option>
							<option value="2" <?php echo ($earlieintime2); ?>>2点钟</option>
							<option value="3" <?php echo ($earlieintime3); ?>>3点钟</option>
							<option value="4" <?php echo ($earlieintime4); ?>>4点钟</option>
							<option value="5" <?php echo ($earlieintime5); ?>>5点钟</option>
							<option value="6" <?php echo ($earlieintime6); ?>>6点钟</option>
							<option value="7" <?php echo ($earlieintime7); ?>>7点钟</option>
							<option value="8" <?php echo ($earlieintime8); ?>>8点钟</option>
							<option value="9" <?php echo ($earlieintime9); ?>>9点钟</option>
							<option value="10" <?php echo ($earlieintime10); ?>>10点钟</option>
							<option value="11" <?php echo ($earlieintime11); ?>>11点钟</option>
							<option value="12" <?php echo ($earlieintime12); ?>>12点钟</option>
							<option value="13" <?php echo ($earlieintime13); ?>>13点钟</option>
							<option value="14" <?php echo ($earlieintime14); ?>>14点钟</option>
							<option value="15" <?php echo ($earlieintime15); ?>>15点钟</option>
							<option value="16" <?php echo ($earlieintime16); ?>>16点钟</option>
							<option value="17" <?php echo ($earlieintime17); ?>>17点钟</option>
							<option value="18" <?php echo ($earlieintime18); ?>>18点钟</option>
							<option value="19" <?php echo ($earlieintime19); ?>>19点钟</option>
							<option value="20" <?php echo ($earlieintime20); ?>>20点钟</option>
							<option value="21" <?php echo ($earlieintime21); ?>>21点钟</option>
							<option value="22" <?php echo ($earlieintime22); ?>>22点钟</option>
							<option value="23" <?php echo ($earlieintime23); ?>>23点钟</option>
							<option value="24" <?php echo ($earlieintime24); ?>>不限</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">最晚办理离店时间</label>
					<div class="controls">
					<?php $lastouttime1=$hotel_info['lastouttime']==1?"selected":""; ?>
					<?php $lastouttime2=$hotel_info['lastouttime']==2?"selected":""; ?>
					<?php $lastouttime3=$hotel_info['lastouttime']==3?"selected":""; ?>
					<?php $lastouttime4=$hotel_info['lastouttime']==4?"selected":""; ?>
					<?php $lastouttime5=$hotel_info['lastouttime']==5?"selected":""; ?>
					<?php $lastouttime6=$hotel_info['lastouttime']==6?"selected":""; ?>
					<?php $lastouttime7=$hotel_info['lastouttime']==7?"selected":""; ?>
						<select name="lastouttime">
							<option value="1" <?php echo ($lastouttime1); ?>>10点钟</option>
							<option value="2" <?php echo ($lastouttime2); ?>>11点钟</option>
							<option value="3" <?php echo ($lastouttime3); ?>>12点钟</option>
							<option value="4" <?php echo ($lastouttime4); ?>>13点钟</option>
							<option value="5" <?php echo ($lastouttime5); ?>>14点钟</option>
							<option value="6" <?php echo ($lastouttime6); ?>>15点钟</option>
							<option value="7" <?php echo ($lastouttime7); ?>>16点钟</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">关房时点</label>
					<div class="controls">
					<?php $hotel_close1=$hotel_info['hotel_close']==1?"selected":""; ?>
					<?php $hotel_close2=$hotel_info['hotel_close']==2?"selected":""; ?>
					<?php $hotel_close3=$hotel_info['hotel_close']==3?"selected":""; ?>
					<?php $hotel_close4=$hotel_info['hotel_close']==4?"selected":""; ?>
					<?php $hotel_close5=$hotel_info['hotel_close']==5?"selected":""; ?>
					<?php $hotel_close6=$hotel_info['hotel_close']==6?"selected":""; ?>
					<?php $hotel_close7=$hotel_info['hotel_close']==7?"selected":""; ?>
					<?php $hotel_close8=$hotel_info['hotel_close']==8?"selected":""; ?>
						<select name="hotel_close">
							<option value="1" <?php echo ($hotel_close1); ?>>17点钟</option>
							<option value="2" <?php echo ($hotel_close2); ?>>18点钟</option>
							<option value="3" <?php echo ($hotel_close3); ?>>19点钟</option>
							<option value="4" <?php echo ($hotel_close4); ?>>20点钟</option>
							<option value="5" <?php echo ($hotel_close5); ?>>21点钟</option>
							<option value="6" <?php echo ($hotel_close6); ?>>22点钟</option>
							<option value="7" <?php echo ($hotel_close7); ?>>23点钟</option>
							<option value="8" <?php echo ($hotel_close8); ?>>不限</option>
						</select>
						<p>针对当天客房，在该时点以后就不再接受预订</p>
					</div>
				</div>
				<hr>
				<h4>联系人</h4>
				<div class="control-group">
					<label class="control-label">酒店联系人姓名(一)</label>
					<div class="controls">
					<input type="hidden" name="id1" value="<?php echo ($contactArr[0]['id']); ?>">
						<input type="text" name="name1" value="<?php echo ($contactArr[0]["name"]); ?>">
						<p>酒店微官网负责人，方便直订网与酒店的联系</p>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">电话</label>
					<div class="controls">
						<input type="text" name="phone1" value="<?php echo ($contactArr[0]["phone"]); ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">邮箱</label>
					<div class="controls">
						<input type="text" name="mail1" value="<?php echo ($contactArr[0]["mail"]); ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">酒店联系人姓名(二)</label>
					<div class="controls">
						<input type="hidden" name="id2" value="<?php echo ($contactArr[1]['id']); ?>">
						<input type="text" name="name2" value="<?php echo ($contactArr[1]["name"]); ?>">
						<p>酒店微官网负责人，方便直订网与酒店的联系(备用联系方式)</p>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">电话</label>
					<div class="controls">
						<input type="text" name="phone2" value="<?php echo ($contactArr[1][phone]); ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">邮箱</label>
					<div class="controls">
						<input type="text" name="mail2" value="<?php echo ($contactArr[1]["mail"]); ?>">
					</div>
				</div>
				<hr>
				<h4>地理位置</h4>
				<div class="control-group">
					<label class="control-label">省份</label>
					<div class="controls">
						<select name="province" id="province" onchange="cityajax('city', 'province');">
							<option value="0">选择省</option>
						<?php if(is_array($province)): foreach($province as $key=>$vo): $province_selected=$hotel_info['province']==$vo['id']?"selected":""; ?>
							<option value="<?php echo ($vo["id"]); ?>" <?php echo ($province_selected); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">城市</label>
					<div class="controls">
						<select name="city" id="city" onchange="cityajax('area', 'city');">
							<option value="0">选择市</option>
						<?php if(is_array($city)): foreach($city as $key=>$vo): $city_selected=$hotel_info['city']==$vo['id']?"selected":""; ?>
							<option value="<?php echo ($vo["id"]); ?>" <?php echo ($city_selected); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">区县</label>
					<div class="controls">
						<select name="area" id="area" onchange="cityajax('district', 'area');">
							<option value="0">选择区县</option>
						<?php if(is_array($area)): foreach($area as $key=>$vo): $area_selected=$hotel_info['area']==$vo['id']?"selected":""; ?>
							<option value="<?php echo ($vo["id"]); ?>" <?php echo ($area_selected); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">邮政编码</label>
					<div class="controls">
						<input type="text" name="zipcode" value="<?php echo ($hotel_info["zipcode"]); ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">街道</label>
					<div class="controls">
						<input type="text" name="hotel_address" value="<?php echo ($hotel_info["hotel_address"]); ?>" style="width:350px;">
						<p>如：建国门大街*号<p>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">酒店地址:</label>
					<div class="controls">
						<input type="text" class="input" id="gps_address" name="gps_address" value="<?php echo ($hotel_info["gps_address"]); ?>" style="width: 500px;">
						<button id="btnaddress" type="button" class="btn btn-primary">搜索定位</button>
						<input type="hidden" name="lng" id="lng" value="<?php echo ($hotel_info["lng"]); ?>"/>
						<input type="hidden" name="lat" id="lat" value="<?php echo ($hotel_info["lat"]); ?>"/>
						<div id="container" style="width: 620px;height: 400px;"></div>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Address:</label>
					<div class="controls">
						<input type="text" name="address" value="<?php echo ($hotel_info['address']); ?>" style="width: 800px;">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">酒店logo</label>
					<div class="controls">
						<input type="hidden" name="logourl" id="thumb" value="<?php echo ($hotel_info['logourl']); ?>">
							<a href="javascript:void(0);" onclick="flashupload('thumb_images', '附件上传','thumb',thumb_images,'1,jpg|jpeg|gif|png|bmp,1,,,1','','','');return false;">
							<?php if(empty($hotel_info['logourl'])): ?><img src="/admin/themes/simplebootx/Public/assets/images/default-thumbnail.png" id="thumb_preview" width="135" style="cursor: hand" />
							<?php else: ?>
								<img src="<?php echo sp_get_asset_upload_path($hotel_info['logourl']);?>" id="thumb_preview" width="135" style="cursor: hand" /><?php endif; ?>
							</a>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">酒店介绍头图</label>
					<div class="controls">
						<input type="hidden" name="headpic" id="thumb1" value="<?php echo ($hotel_info['headpic']); ?>">
							<a href='javascript:void(0);' onclick="flashupload('thumb_images', '附件上传','thumb1',thumb_images,'1,jpg|jpeg|gif|png|bmp,1,,,1','','','');return false;">
							<?php if(empty($hotel_info['headpic'])): ?><img src="/admin/themes/simplebootx/Public/assets/images/default-thumbnail.png" id="thumb1_preview" width="135" style="cursor: hand" />
							<?php else: ?>
								<img src="<?php echo sp_get_asset_upload_path($hotel_info['headpic']);?>" id="thumb1_preview" width="135" style="cursor: hand" /><?php endif; ?>
							</a>
					</div>
				</div>
				<hr>
				<h4>酒店介绍</h4>
				<div class="control-group">
					<div class="controls">
						<script type="text/plain" id="content" name="des" style="width:650px;height:400px;"><?php echo ($hotel_info["des"]); ?></script>
					</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<button type="submit" class="btn btn-primary js-ajax-submit">保存</button>
			</div>
		</form>
	</div>
	<script type="text/javascript" src="/public/js/common.js"></script>
	<script type="text/javascript" src="/public/js/content_addtop.js"></script>
	<script src="/public/js/chosen/chosen_jquery_min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=4388bca8d4e2cd9d13b9e1e91250348c&plugin=AMap.Geocoder"></script>
	<script src="/admin/themes/simplebootx/assets/js/mymap.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		$(function(){
			//初始化下拉框
			$(".acttype").chosen();
			//初始化地址控件
			window.mymap.init("container","gps_address","lng","lat","btnaddress");
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
													location = "<?php echo U('Hotel/info');?>";
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

		function cityajax(nextListName, _this){
			var id = $("#" + _this).val();
			if(id != 0){
				$("#" + nextListName).html("<option value='0'>正在加载</option>");
				$.post("<?php echo U('Admin/Hotel/cityListAjax');?>", {id:id, nextListName:nextListName}, function(data){
					console.log(data);
					if(data.code == 0){
						var htm = "<option value='0'>请选择</option>";
						for(x in data.list){
							htm += "<option value='" + data.list[x].id + "'>" + data.list[x].name + "</option>";
						}
						$("#" + nextListName).html(htm);
					}else{
						$("#" + nextListName).html("<option value='0'>请选择</option>");
					}
				}, "json");
			}
		}
	</script>
</body>
</html>