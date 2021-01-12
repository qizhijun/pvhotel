<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace Wechat\Controller;
use Think\Controller;

class WxRoomController extends Controller {
	
	/**
	 * 处理订房的逻辑
	 */
	public function index(){
		vendor("wx.WxNotify");
		$notify=new \WxNotify($this);
		$notify->Handle(true);
		exit();
	}
    /**
	 * 处理订单的逻辑
	 */
	public function updateOrder($openid,$orderid,$transactionid,$totalfee){
		\Think\Log::record("购买挂耳支付回调开始，[openid：" . $openid . "][订单号：" . $orderid . "][支付金额：" . $totalfee . "]".$orderid,'WARN',true);
		$order_id = substr($orderid , 0 , 20);
		$totalfee=round(floatval($totalfee)/100,2);
		//查询支付记录，如果已经处理，直接返回true，没有处理过，在进行下一步
		$orderOne = M("order")->find($order_id);
		\Think\Log::record("会员消费支付回调1，[" . json_encode($orderOne) . "]",'WARN',true);
		if($orderOne["status"] == 2){
			\Think\Log::record("会员消费支付已经处理过".$order_id,'WARN',true);
			return true;
		}else{
			$payres = M("order")->where(array(
				"id"=>$order_id,
			))->save(array(
				"paycost" => $totalfee,
				"pay_id" => $transactionid,
				"pay_time" => time(),
				"status" => 2
			));
			if($payres){
				\Think\Log::record("支付回调2，[修改记录成功：" . json_encode($payres) . "]",'WARN',true);
				$this->sendPayMsg($openid,$totalfee,$orderOne['vipid'],$transactionid);
				
				return true;
			}else{
				\Think\Log::record("支付回调2，[修改记录失败：error",'WARN',true);
				return false;
			}
		}
	}
	
	/**
	 * 发送付款通知
	 */
	private function sendPayMsg($payopenid,$cost,$shopname,$transactionid){
				
		$mess="[支付凭证]您成功预订[电谷酒店]房间，消费人民币" . $cost . "元。[微信交易单号：" . $transactionid . "][支付时间：" . date("Y-m-d H:i:s", time()) . "]";
		\Think\Log::record("购买挂耳支付回调3推送付款通知，您已经成功付款，支付了".$cost."元[openid:" . $openid . ",微信交易单号：" . $transactionid . "]",'WARN',true);
		vendor("wx.WxApi");
		\WxApi::sendWxKfMsg($payopenid,urlencode($mess));
	}
	
}


