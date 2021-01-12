<?php
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);

require_once "WxPayApi.php";
require_once "WxPay.Notify.php";

class WxNotify extends WxPayNotify
{
	private $orderM;//操作订单的对象
	
	public function __construct($order){
		$this->orderM=$order;
	}
	
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);

		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			return true;
		}
		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			return false;
		}
		
		//如果订单确实存在，回调执行成功，需要修改订单的状态
		$openid=$data["openid"];//付款人
		$orderid=$data["out_trade_no"];//本系统订单号
		$transactionid=$data["transaction_id"];//支付流水号
		$totalfee=$data["total_fee"];//支付总金额
		$result=$this->orderM->updateOrder($openid,$orderid,$transactionid,$totalfee);
		
		return $result;
	}
}

