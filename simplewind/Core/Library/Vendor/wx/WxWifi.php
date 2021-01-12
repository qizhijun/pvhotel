<?php
require_once "WxApi.php";

class WxWifi{
	
	/**
	 * 提交数据
	 */
	public static function wxHttpsRequest($url,$data = null){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
	
	/**
	 * 上传图片
	 * $imgurl 图片的绝对路径
	 */
	public static function uploadImg($imgurl){
		$token=WxApi::getAccessToken();
		$apiurl="https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token=".$token;
		$data["buffer"]="@".$imgurl;
		
		$res=self::wxHttpsRequest($apiurl,$data);
		return $res;
	}
	
	/**
	 *上传门店信息，参数个数如下json 
	 * 
	 * $shopinfo 门店信息数组
	 
	 *{
	 * 	"business":{
	 *	   	"base_info":{
	 *          "sid":"33788392",
	 *           "business_name":"麦当劳",
	 *           "branch_name":"艺苑路店",
	 *           "province":"广东省",
	 *           "city":"广州市",
	 *           "district":"海珠区",
	 *           "address":"艺苑路11 号",
	 *           "telephone":"020-12345678",
	 *           "categories":["美食,小吃快餐"], 
	 *           "offset_type":1,
	 *           "longitude":115.32375,
	 *           "latitude":25.097486,
	 *           "photo_list":[{"photo_url":"https:// XXX.com"}，{"photo_url":"https://XXX.com"}],
	 *           "recommend":"麦辣鸡腿堡套餐，麦乐鸡，全家桶",
	 *           "special":"免费wifi，外卖服务",
	 *           "introduction":"麦当劳是全球大型跨国连锁餐厅，1940 年创立于美国，在世界上大约拥有3 万间分店。主要售卖汉堡包，以及薯条、炸鸡、汽水、冰品、沙拉、 水果等快餐食品",
	 *           "open_time":"8:00-20:00",
	 *           "avg_price":35
	 *     	}
	 *	}
	 *}
	 */
	public static function createShop($shopinfo){
		$token=WxApi::getAccessToken();
		$apiurl="http://api.weixin.qq.com/cgi-bin/poi/addpoi?access_token=".$token;
		$postJson=urldecode(json_encode($shopinfo));
		
		$res=WxApi::postJsonCurl($apiurl,$postJson);
		return $res;
	}
	
	/**
	 * 查询门店详情
	 * $poid 门店编号
	 */
	public static function getShopInfo($poid){
		$token=WxApi::getAccessToken();
		$apiurl="http://api.weixin.qq.com/cgi-bin/poi/getpoi?access_token=".$token;
		$postJson=json_encode(array("poi_id"=>$poid));
		
		$res=WxApi::postJsonCurl($apiurl,$postJson);
		return $res;
	}
	
	/**
	 * 添加wifi设备
	 * $shop_id 门店编号
	 * $ssid 设备号
	 * $password 设备密码
	 */
	public static function addWifi($shop_id,$ssid,$password){
		$token=WxApi::getAccessToken();
		$apiurl="https://api.weixin.qq.com/bizwifi/device/add?access_token=".$token;
		$postJson=json_encode(array(
			"shop_id"=>$shop_id,
			"ssid"=>$ssid,
			"password"=>$password
		));
		
		$res=WxApi::postJsonCurl($apiurl,$postJson);
		return $res;
	}
	
	/**
	 * 获取wifi设备列表
	 * $shop_id 门店编号
	 * $pageindex 页数
	 * $pagesize 页大小
	 */
	public static function getWifilist($shop_id, $pageindex = 1, $pagesize = 20){
		$token=WxApi::getAccessToken();
		$apiurl="https://api.weixin.qq.com/bizwifi/device/list?access_token=".$token;
		$postJson=json_encode(array(
			"shop_id"=>$shop_id,
			"pagesize"=>$pagesize,
			"pageindex"=>$pageindex
		));
		
		$res=WxApi::postJsonCurl($apiurl,$postJson);
		return $res;
	}
	
	/**
	 * 查询店面wifi详情
	 */
	public static function getWifiInfo($shop_id){
		$token=WxApi::getAccessToken();
		$apiurl="https://api.weixin.qq.com/bizwifi/shop/get?access_token=".$token;
		$postJson=json_encode(array("shop_id"=>$shop_id));
		
		$res=WxApi::postJsonCurl($apiurl,$postJson);
		echo $res;
	}
	
	/**
	 * 获取连接wifi的二维码
	 * $shop_id 门店编号
	 * $img_id 0-纯二维码  1-二维码物料
	 */
	public static function getQrcode($shop_id,$img_id=1){
		$token=WxApi::getAccessToken();
		$apiurl="https://api.weixin.qq.com/bizwifi/qrcode/get?access_token=".$token;
		$postJson=json_encode(array(
			"shop_id"=>$shop_id,
			"img_id"=>$img_id
		));
		
		$res=WxApi::postJsonCurl($apiurl,$postJson);
		return $res;
	}
	
	/**
	 * 设置店面首页连接
	 * $shop_id 店面编号
	 * $homeurl 商户首页连接地址
	 */
	public static function setHomePage($shop_id,$homeurl){
		$token=WxApi::getAccessToken();
		$apiurl="https://api.weixin.qq.com/bizwifi/homepage/set?access_token=".$token;
		$postJson=json_encode(array(
			"shop_id"=>$shop_id,
			"template_id"=>1,
			"struct"=>array(
				"url"=>$homeurl
			)
		));
		
		$res=WxApi::postJsonCurl($apiurl,$postJson);
		return $res;
	}
	
	/**
	 * 获取店面首页连接
	 * $shop_id 店面编号
	 * 返回值格式
	 * {
	 *	   "errcode": 0,
	 *	   "data": {
	 *	     	"shop_id": 429620,
	 *	     	"template_id": 1,
	 *	     	"url": " http://wifi.weixin.qq.com/"
	 *	  	}
	 *	}
	 */
	public static function getHomePage($shop_id){
		$token=WxApi::getAccessToken();
		$apiurl="https://api.weixin.qq.com/bizwifi/homepage/get?access_token=".$token;
		$postJson=json_encode(array(
			"shop_id"=>$shop_id
		));
		
		$res=WxApi::postJsonCurl($apiurl,$postJson);
		return $res;
	}
	
	/**
	 * 设置常驻入口文案
	 * $shop_id 门店编号
	 * $bar_type 0--欢迎光临+公众号名称；1--欢迎光临+门店名称；2--已连接+公众号名称+WiFi；3--已连接+门店名称+Wi-Fi。
	 */
	public static function setBar($shop_id,$bar_type){
		$token=WxApi::getAccessToken();
		$apiurl="https://api.weixin.qq.com/bizwifi/bar/set?access_token=".$token;
		$postJson=json_encode(array(
			"shop_id"=>$shop_id,
			"bar_type"=>$bar_type
		));
		
		$res=WxApi::postJsonCurl($apiurl,$postJson);
		return $res;
	}
}
