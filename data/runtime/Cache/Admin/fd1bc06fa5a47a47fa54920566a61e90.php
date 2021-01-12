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
			<li><a href="<?php echo U('import/upfile');?>">数据导入</a></li>
			<li class="active"><a href="<?php echo U('import/index');?>">导入的批次</a></li>
		</ul>
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th width="50">ID</th>
					<th>文件名称</th>
					<th>路径</th>
					<th>月份</th>
					<th>数据总数</th>
					<th>是否推送</th>
					<th>上传时间</th>
					<th>管理操作</th>
				</tr>
			</thead>
			<tbody>
				<?php $staArr=array("0"=>"否","1"=>"是"); ?>
				<?php if(is_array($lists)): foreach($lists as $key=>$vo): $datetime=date("Y-m-d H:i:s",$vo["created"]); $staname=array('0'=>"未推送","1"=>"已推送","2"=>"推送中"); $num=$vo['datanum']-$vo['errornum']; ?>
					<tr>
						<td><?php echo ($vo["id"]); ?></td>
						<td><?php echo ($vo["title"]); ?></td>
						<td><?php echo ($vo["fileurl"]); ?></td>
						<td><?php echo ($vo["mon"]); ?></td>
						<td><?php echo ($vo["rightnum"]); ?></td>
						<td><?php echo ($staname[$vo['status']]); ?></td>
						<td><?php echo ($datetime); ?></td>
						<td>
							<a href="<?php echo U('import/detail',array('id'=>$vo['id'],'mon'=>$vo['mon']));?>">明细</a> | 
							<?php if($vo['status'] == 0): ?><a href="javascript:;" data-id="<?php echo ($vo["id"]); ?>" class="btn_sendmsg" data-msg="您确定要发送吗？">发送通知</a> |<?php endif; ?>
							<?php if($vo['status'] == 2): ?><a href="javascript:;" class="J_ajax_dialog_btn">发送中</a> |<?php endif; ?>
							<?php if($vo['status'] == 1): ?><a href="javascript:;" class="J_ajax_dialog_btn">发送完毕</a> |<?php endif; ?>
							<a href="<?php echo U('import/delete',array('id'=>$vo['id']));?>" class="js-ajax-delete" data-msg="您确定要删除吗？">删除</a>
						</td>
					</tr><?php endforeach; endif; ?>
			</tbody>
		</table>
		<div class="pagination"><?php echo ($page); ?></div>
	</div>
	<script src="/public/js/common.js"></script>
	<script type="text/javascript">
		$(function(){
			Wind.use('artDialog', function () {
				//发送微信通知
				$(".btn_sendmsg").click(function(){
					var $this=$(this);
					art.dialog({
	                    title: false,
	                    icon: 'question',
	                    content: "是否发送通知",
	                    follow: this,
	                    close: function () {
	                        this.focus(); //关闭时让触发弹窗的元素获取焦点
	                        return true;
	                    },
	                    ok:function(){
	                    	this.content("正在发送通知").lock();
	                    	var tishi=this;
	                    	var dataid=$this.attr("data-id");
	                    	$.post("/index.php?g=Admin&m=Import&a=sendtice&id="+dataid,{},function(data){
	                    		if(data.success){
	                    			tishi.button({name:'确定',disabled:true}).content("发送中");
	                    			location.reload();
	                    		}else{
	                    			tishi.button({name:'确定',disabled:true}).content("发送错误");
	                    		}
	                    		setTimeout(function(){
	                    			tishi.close();
	                    		},1500);
	                    	},'json');
	                    	return false;
	                    }
	                });
				});
	        
	        });
			
		});
	</script>
</body>
</html>