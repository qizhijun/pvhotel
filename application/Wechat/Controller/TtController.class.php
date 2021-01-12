<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace Wechat\Controller;
use Common\Controller\WxBaseController; 
/**
 * 首页
 */
class TtController extends WxBaseController {
	
    //首页
	public function index() {
		$openid=$_SESSION["fans"]["openid"];
		
//		$this->noticeFocus("哈");
		
		//发送图文消息 
		vendor("wx.WxApi");
		$res=\WxApi::sendWxKfMsg($openid,urlencode("你好帅啊"));
		dump($res);
		/*$news[]=array(
			"title"=>urlencode("你好帅"),
			"description"=>urlencode("这是为什么呢"),
			"url"=>"http://www.kafeibang.com",
			"picurl"=>"http://img.diandao.org/ser_photo/srv_img/srv/sdqs.jpg"
		);
		$res=\WxApi::sendWxKfMsg($openid,$news,true);
		echo json_encode($res);
		*/
		/*
		//生成二维码
		vendor('phpqrcode.phpqrcode');//导入类库
		$qrcode = new \QRcode();
		$url = urldecode($_GET["data"]);
		
		$qrcode->png("http://dwz.cn/2bPaSC",false,H,6,false);
		*/ 
		$fansinfo=\WxApi::getFocusInfo($openid);
		dump($fansinfo);
		
		echo $openid;
		vendor("wx.WxTemplate");
		$url=urlencode("http://diangu.yijiudian.cn/index.php?g=Wechat&m=Salary");
		
		//$res=\WxTemplate::bookingMsg($openid,$url,"服务","保养",time(),"已预约","请资讯80爱车微信客服");
		//$res=\WxTemplate::saleMsg($openid,$url,"消费项目","洗车服务",time(),"点击评论服务商家");
		$res=\WxTemplate::salaryMsg($openid,$url,"祁志军，您的工资已经发放完毕","9月份","5000元","4600元","200元","200元","如果疑问，请联系公司财务部");
		dump($res);
		
    }

	//支付页面
	public function pay() {
		var_dump($_SESSION);
		echo "hh";
    	$this->display("pay");
    }

	//支付参数
	public function payparam(){
		vendor('wx.WxPayApi');//导入微信类库
		vendor('wx.WxJsApiPay');
		
		$tools = new \WxJsApiPay();
		$openId = $_SESSION["fans"]["openid"];
		\Think\Log::record("生成预付订单，openid:".$openId);
		$input = new \WxPayUnifiedOrder();
		$input->SetBody("test");
		$input->SetAttach("test");
		$input->SetOut_trade_no(\WxPayConfig::MCHID.date("YmdHis"));
		$input->SetTotal_fee("1");
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 600));
		$input->SetGoods_tag("test");
		$input->SetNotify_url("http://wx.kafeibang.com/Wechat/treatNotify/index");
		$input->SetTrade_type("JSAPI");
		$input->SetOpenid($openId);
		
		$order = \WxPayApi::unifiedOrder($input);
		\Think\Log::record("生成预付订单".json_encode($order)."订单号：".$input->GetOut_trade_no());
		$jsApiParameters = $tools->GetJsApiParameters($order);
		exit($jsApiParameters);
	}
	
	public function updateOrder($orderid){
		
	}
	
	//生成支付链接
	public function scanpay(){
		vendor('wx.WxPayApi');//导入微信类库
		$input = new \WxPayUnifiedOrder();
		$input->SetBody("test");
		$input->SetAttach("test");
		$input->SetOut_trade_no(\WxPayConfig::MCHID.date("YmdHis"));
		$input->SetTotal_fee("1");
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 600));
		$input->SetGoods_tag("test");
		$input->SetNotify_url("http://wx.kafeibang.com/Wechat/treatNotify/index");
		$input->SetTrade_type("NATIVE");
		$input->SetProduct_id("123456789");
		$result = \WxPayApi::unifiedOrder($input);
		$payurl = $result["code_url"];
		
		echo "<img src='http://paysdk.weixin.qq.com/example/qrcode.php?data=".$payurl."'>";
	}
	
	public function creatQrcode(){
		vendor('phpqrcode.phpqrcode');//导入类库
		$qrcode = new \QRcode();
		$url = urldecode($_GET["data"]);
		$qrcode->png($url);
	}
	
	public function testcode(){
		vendor('wx.WxApi');//导入微信类库
		$imgurl=\WxApi::createQrcode("1");
		echo "<img src='$imgurl'>";
	}
	
	public function addindex(){
		vendor('xun.Xun');//导入微信类库
		$xun=new \Xun();
		
		$inarr=array(
			"pid"=>2,
			"subject"=>"你是谁？",
			"message"=>"我是80客服"
		);
		$res=$xun->addindex($inarr);
		var_dump($res);
	}
	
	public function tt(){
		//vendor('wx.WxApi');//导入微信类库
		//$param="oid=DD145322281803909543";
		//\WxApi::postDataCurl("http://merchant.80car.cn/Api/index/orderOk",$param);
		echo "<meta charset='UTF-8'>";
		vendor('xun.Xun');//导入微信类库
		$xun=new \Xun();
		$res=$xun->search($_GET["k"]);
		echo $_GET["k"];
		var_dump($res);
	}
}


