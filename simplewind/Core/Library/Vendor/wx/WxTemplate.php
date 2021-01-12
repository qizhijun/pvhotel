<?php
require_once "WxApi.php";

class WxTemplate{
		
	/**
	 * IT软件与服务
	 * 工资发放通知
	 */
	public static function salaryMsg($touser,$link,$content,$mon,$yingfa,$shifa,$gswx,$grwx,$remark){
		$temp=array(
			"touser"=>$touser,
			"template_id"=>"l-FnUygvsraKSa2h_7TIdM-BOnUh1d3GugwWttQn6Tg",
			"url"=>$link,
			"data"=>array(
				"first"=>array("value"=>urlencode($content)),//消息提示
				"keyword1"=>array("value"=>urlencode($mon)),//发放月份
				"keyword2"=>array("value"=>urlencode($yingfa)),//应发工资
				"keyword3"=>array("value"=>urlencode($shifa)),//实发工资
				"keyword4"=>array("value"=>urlencode($gswx)),//公司五险一金
				"keyword5"=>array("value"=>urlencode($grwx)),//个人五险一金
				"remark"=>array("value"=>urlencode($remark))//备注信息
			)
		);
		return self::sendMsg($temp);
	}
	
	/**
	 * 审核结果通知  OPENTM200656751
	 */
	public static function checkMsg($touser,$link,$content,$infoid,$info,$remark){
		$temp=array(
			"touser"=>$touser,
			"template_id"=>"Qfm4loHbZe__KIZKfYrWMqQVnFpJMvXJsO39BlWPSSM",
			"url"=>$link,
			"data"=>array(
				"first"=>array("value"=>urlencode($content)),//消息提示
				"keyword1"=>array("value"=>urlencode($infoid)),//信息ID
				"keyword2"=>array("value"=>urlencode($info)),//详情
				"remark"=>array("value"=>urlencode($remark))//备注信息
			)
		);
		return self::sendMsg($temp);
	}
	
	/**
	 * 订单状态通知
	 */
	public static function statusMsg($touser,$link,$content,$infoid,$info,$remark){
		$temp=array(
			"touser"=>$touser,
			"template_id"=>"PiYywNw33-S3L9CE3OuNUHz7DXgs-AIOkRn2Ui4hr8U",
			"url"=>$link,
			"data"=>array(
				"first"=>array("value"=>urlencode($content)),//消息提示
				"keyword1"=>array("value"=>urlencode($infoid)),//信息ID
				"keyword2"=>array("value"=>urlencode($info)),//详情
				"remark"=>array("value"=>urlencode($remark))//备注信息
			)
		);
		return self::sendMsg($temp);
	}
	
	public static function sendMsg($sendParam){
		$token=WxApi::getAccessToken();
		$apiurl="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token;
		$sendJson=urldecode(json_encode($sendParam));
		return WxApi::postJsonCurl($apiurl,$sendJson);
	}
}
