<?php
require_once "WxApi.php";
/**
 * 
 * JSAPI调用实现类
 * 该类实现了网页中调用微信js所需的参数
 * 
 * @author qizhijun
 *
 */
class WxJsApi
{
	public function getSignPackage() {
	    $jsapiTicket = $this->getJsApiTicket();
	    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	    $timestamp = time();
	    $nonceStr = $this->createNonceStr();
	
	    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
	    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
	
	    $signature = sha1($string);
	
	    $signPackage = array(
	      "appId"     => WxPayConfig::APPID,
	      "nonceStr"  => $nonceStr,
	      "timestamp" => $timestamp,
	      "url"       => $url,
	      "signature" => $signature,
	      "rawString" => $string
	    );
	    return $signPackage; 
	}
	
	private function createNonceStr($length = 16) {
	    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	    $str = "";
	    for ($i = 0; $i < $length; $i++) {
	      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
	    }
	    return $str;
	}
	
	private function getJsApiTicket() {
	    // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
	    $data = json_decode(file_get_contents("jsapi_ticket.json"));
	    if ($data->expire_time < time()) {
	      $accessToken = WxApi::getAccessToken();
	      
	      $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
	      $res = json_decode(WxApi::httpGet($url));
	      $ticket = $res->ticket;
	      if ($ticket) {
	        $data->expire_time = time() + 7000;
	        $data->jsapi_ticket = $ticket;
	        $fp = fopen("jsapi_ticket.json", "w");
	        fwrite($fp, json_encode($data));
	        fclose($fp);
	      }
	    } else {
	      $ticket = $data->jsapi_ticket;
	    }
	
	    return $ticket;
	}
}