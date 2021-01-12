<?php
require_once "WxPay.Exception.php";
require_once "WxPay.Config.php";
require_once "WxPay.Data.php";

/**
 * 
 * 接口访问类，包含所有微信支付API列表的封装，类中方法为static方法，
 * 每个接口有默认超时时间（除提交被扫支付为10s，上报超时时间为1s外，其他均为6s）
 * @author widyhu
 *
 */
class WxApi
{
	
	/**
	 * 验证开发这url的方法
	 */
	public static function validUrl($token)
    {
    	$echoStr = $_GET["echostr"];
    	if ($echoStr) {
    		$signature = $_GET["signature"];
	        $timestamp = $_GET["timestamp"];
	        $nonce = $_GET["nonce"];
			$tmpArr = array($token, $timestamp, $nonce);
			sort($tmpArr);
			$tmpStr = implode( $tmpArr );
			$tmpStr = sha1( $tmpStr );
			
			if( $tmpStr == $signature ){
				exit($echoStr);
	        }
    	}
    }
	
	/**
	 * 公众号消息响应
	 */
	public static function responseMsg(){
		//获取请求数据
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		//判断请求数据是否为空
		if (!empty($postStr)){
          	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			return $postObj;
		}else{
			return null;
		}
	}
	
	/**
	 * 获取token
	 * 缓存这个值
	 */
	public static function getAccessToken() {
	    $data = json_decode(file_get_contents("ssb_token.json"));
	    if ($data->expire_time < time()) {
		  	$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".WxPayConfig::APPID."&secret=".WxPayConfig::APPSECRET;
		  	$res = json_decode(self::httpGet($url));
		  	$access_token = $res->access_token;
		  	if ($access_token) {
		    	$data->expire_time = time() + 7000;
		    	$data->access_token = $access_token;
		    	$fp = fopen("ssb_token.json", "w");
		    	fwrite($fp, json_encode($data));
		    	fclose($fp);
		  	}
	    } else {
	      	$access_token = $data->access_token;
	    }
	    return $access_token;
	}
	
	/**
	 * 获取粉丝的详细信息
	 */
	public static function getFocusInfo($openid){
		$token=self::getAccessToken();
		$url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$token."&openid=".$openid."&lang=zh_CN";
		$res = json_decode(self::httpGet($url),true);
		if($res["errcode"]){
			//var_dump($res);
			return null;
		}else{
			return $res;
		}
	}
	
	/**
	 * 生成微信带参二维码
	 */
	public static function createQrcode($sceneStr){
		$token=self::getAccessToken();
		$jsondata='{"action_name": "QR_LIMIT_STR_SCENE", "action_info": {"scene": {"scene_str": "'.$sceneStr.'"}}}';
		$qcodeurl="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$token;
		list($expire_seconds, $ticketjson)=self::postJsonCurl($qcodeurl, $jsondata);
		$ticketArr=json_decode($ticketjson,true);
		return "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$ticketArr['ticket'];
	}
	
	/**
	 * 设置微信菜单
	 */
	public static function setMenu($menuArr){
		$token=self::getAccessToken();
		$url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$token;
		$menuJson=urldecode(stripslashes(json_encode($menuArr)));
		return self::postJsonCurl($url,$menuJson);
	}
	
	/**
	 * 获取微信菜单
	 */
	public static function getMenu(){
		$token=self::getAccessToken();
		$url="https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".$token;
		$menuJson=self::httpGet($url);
		return $menuJson;
	}
	
	/**
	 * 文本消息模版
	 */
    public static function texttpl($openid,$wxid,$contentStr){
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    <FuncFlag>0</FuncFlag>
                    </xml>";
        $msgType = "text";
        return sprintf($textTpl,$openid, $wxid, time(), $msgType, $contentStr);
    }

    /**
	 * 图文内容模版
	 * $content 图文内容 title、description、pic_url,url
	 */
    public static function newstpl($openid,$wxid,$content){
        global $_SC;
        $newsTpl=" <item>
                <Title><![CDATA[%s]]></Title> 
                <Description><![CDATA[%s]]></Description>
                <PicUrl><![CDATA[%s]]></PicUrl>
                <Url><![CDATA[%s]]></Url>
                </item>";
        $newsxml=sprintf($newsTpl,$content['title'],$content['description'],$content['pic_url'],$content['url']);
        $newsnum=1;
        //如果有相关新闻，一起拼接，最多9个
        if(count($content['news'])>0&&count($content['news'])<=9){
            foreach ($content['news'] as $value) {
                $newsxml.=sprintf($newsTpl,$value['title'],$value['description'],$value['pic_url'],$value['url']);
                $newsnum++;
            }
        }
        $returnTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <ArticleCount>%s</ArticleCount>
                    <Articles>
                    ";
        $msgType = "news";
        return sprintf($returnTpl, $openid, $wxid, time(), $msgType, $newsnum).$newsxml."</Articles></xml>";
    }
    
    /**
	 * 发送客服文字消息,48小时内的活跃用户可使用
	 * 如果isnews为true,$msg为数组需要参数title,description,url,picurl
	 */
    public static function sendWxKfMsg($openid,$msg,$isnews=false){
    	$token=self::getAccessToken();
		$url="https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$token;
		$sendMsg=array(
			"touser"=>$openid
		);
		
		if($isnews){
			$sendMsg["msgtype"]="news";
			$sendMsg["news"]=array(
				"articles"=>$msg
			);
		}else{
			$sendMsg["msgtype"]="text";
			$sendMsg["text"]=array(
				"content"=>$msg
			);
		}
		$sendJson=urldecode(json_encode($sendMsg));
		return self::postJsonCurl($url,$sendJson);
    }
    
    /**
	 * 以get方式请求
	 */
    public static function httpGet($url,$second = 30) {
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_TIMEOUT, $second);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	    curl_setopt($curl, CURLOPT_URL, $url);
	
	    $res = curl_exec($curl);
	    curl_close($curl);
	
	    return $res;
	}
	
	/**
	 * 以post方式提交json文件
	 */
	public static function postJsonCurl($url, $data_string,$timeout=10){
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_TIMEOUT,$timeout);  
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	        'Content-Type: application/json; charset=utf-8',
	        'Content-Length: ' . strlen($data_string))
	    );
	    ob_start();
	    curl_exec($ch);
	    $return_content = ob_get_contents();
	    ob_end_clean();
	    $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		$edtime=time();
	    return array($return_code, $return_content);
	}
	
	//模拟post提交参数数据格式：a=1&b=2&c=3
	public static function postDataCurl($url, $data, $optional_headers = null){
	     $params = array('http' => array(
	                  'method' => 'POST',
	                  'content' => $data
	               ));
	     if ($optional_headers !== null) {
	        $params['http']['header'] = $optional_headers;
	     }
	     $ctx = stream_context_create($params);
	     $fp = @fopen($url, 'rb', false, $ctx);
	     if (!$fp) {
	        throw new Exception("访问地址有误。");
	     }
	     $response = @stream_get_contents($fp);
	     if ($response === false) {
	        throw new Exception("返回数据时出现错误。");
	     }
	     return $response;
	}

	/**
	 * 获取毫秒级别的时间戳
	 */
	private static function getMillisecond()
	{
		//获取毫秒的时间戳
		$time = explode ( " ", microtime () );
		$time = $time[1] . ($time[0] * 1000);
		$time2 = explode( ".", $time );
		$time = $time2[0];
		return $time;
	}
		/**
	 * 从微信服务器下载图片
	 */
		
	public static function downloadWeixinFile($url){
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_HEADER, 0);    
	    curl_setopt($ch, CURLOPT_NOBODY, 0);    //只取body头
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    $package = curl_exec($ch);
	    $httpinfo = curl_getinfo($ch);
		\Think\Log::record("价格：".json_encode($httpinfo));
		\Think\Log::record("价格：".json_encode($package));
	    curl_close($ch);
	    $imageAll = array_merge(array('header' => $httpinfo), array('body' => $package)); 
	    return $imageAll;
	}
	 
	public static function saveWeixinFile($filename, $filecontent){
	    $local_file = fopen($filename, 'w');
	    if (false !== $local_file){
	        if (false !== fwrite($local_file, $filecontent)) {
	            fclose($local_file);
	        }
	    }
	}
	/**
	 * 从微信服务器下载图片
	 */
	public static function downImg($mediaid,$filename){
		$access_token=self::getAccessToken();
		$url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=$access_token&media_id=$mediaid";
		$fileInfo = self::downloadWeixinFile($url);
		self::saveWeixinFile($filename, $fileInfo["body"]);
	}

	
}

