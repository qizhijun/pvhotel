<?php
require_once "WxPay.Config.php";
require_once "WxPayApi.php";
require_once "WxApi.php";
require_once 'log.php';

//初始化日志
$logHandler= new CLogFileHandler("data/runtime/Logs/Wechat/pay".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);
/**
 * 
 * 微信用户类，用来获取当前微信的用户信息
 * @author qizhijun
 *
 */
class WxUser
{
	/**
	 * 获取微信页面上的用户信息
	 */
	public function getWxUser(){
		$nowurl1='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
		$nowurl2='http://'.$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"];
		if($_GET['code']){
			Log::DEBUG("获取openid后的url1".$nowurl1);
			Log::DEBUG("获取openid后的url2".$nowurl2);
			$wxcode=$_GET['code'];
			$wxurl="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".WxPayConfig::APPID."&secret=".WxPayConfig::APPSECRET."&code=".$wxcode."&grant_type=authorization_code";
			$jsonStr=WxApi::httpGet($wxurl);
			$wxdata=json_decode($jsonStr,true);
			$openid=$wxdata['openid'];
			return $openid;
		}else{
			Log::DEBUG("获取openid前的url1".$nowurl1);
			$rurl=urlencode($nowurl2);
			header('Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid='.WxPayConfig::APPID.'&redirect_uri='.$rurl.'&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect');
			exit;
		}
	}
}

