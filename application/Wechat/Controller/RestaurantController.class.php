<?php
namespace Wechat\Controller;
use Common\Controller\WxBaseController; 
/**
 * 首页
 */
class RestaurantController extends WxBaseController {
	
	
	function _initialize() {
		parent::_initialize();
		$this->Restaurant_model = M("restaurant");
		$this->openid = $_SESSION['fans']['openid'] ? $_SESSION['fans']['openid'] : $_SESSION['fans']['id'];
	}
	
	public function restaurant() {
		//查询餐厅信息
		$phone = $_SESSION['fans']['phone'];
		$this->assign("phone",$phone);
		$Restaurant = $this->Restaurant_model->join("ejd_dict on ejd_dict.id = ejd_restaurant.restype","left")->where(array("isdel"=>"-1"))->field("ejd_dict.val,ejd_dict.name,ejd_dict.id,ejd_restaurant.*")->order("ejd_restaurant.sortindex ASC")->select();
		$this->assign("Restaurant",$Restaurant);
		$this->assign("restaurant_curr","curr");
		$this->display();
	}
	

	public function restaurant_details(){
		$phone = $_SESSION['fans']['phone'];
		$this->assign("phone",$phone);
		$id = I("get.id");
		$Restaurant_details = $this->Restaurant_model->where("id='".$id."'")->find();
		$img = json_decode($Restaurant_details['picurl'],ture);
		$foodsend = json_decode($Restaurant_details['foodsend'],true);
		$this->assign("foodsend",$foodsend);
		$this->assign("img",$img);
		$this->assign("Restaurant_details",$Restaurant_details);
		$this->assign("restaurant_curr","curr");
		$this->display();
	}
	
	function restaurantdetail(){
		if(IS_POST){
			$foodid = $_POST['foodid'];
			$cplist = M("restaurant_food")->where("id=".$foodid)->find();
			if($cplist){
				$resArr = array(
					"code" => 0,
					"data" => $cplist
				);
			}else{
				$resArr = array(
					"code" => 1,
					"data" => ""
				);
			}
		}
		exit(json_encode($resArr));
	}
	//微信支付
	public function orderPay(){
		$openid = $_SESSION['fans']['openid'] ? $_SESSION['fans']['openid'] : $_SESSION['fans']['id'];
		$ctid = $_POST['ctid'];
		$ctime = strtotime($_POST['ctime']);
		$cdid = $_POST['cdid'];
		$jcaddress = $_POST['jcaddress'];
		$degreeval = $_POST['degreeval'];
		$address = trim($_POST['address']);
		$Numss = trim($_POST['Numss']);
		$dishes = $_POST['dishes'];
		$pep = trim($_POST['pep']);
		$tel = trim($_POST['tel']);
		$bz = $_POST['bz'];
		$hdsure = $_POST['hdsure'];
		$foodNum = $_POST['foodNum'];
		$CoFoodid = $_POST['CoFoodid'];
		//订的菜品数量
		$newstr = substr($foodNum,0,strlen($foodNum)-1);
		$foodnum = explode(",",$newstr);
		//订的菜品id
		$foodid = substr($CoFoodid,0,strlen($CoFoodid)-1);
		$tmp['id'] = array("in",$foodid);
		$foodlist = M("restaurant_food")->where($tmp)->select();
		//计算菜品总价
		foreach($foodlist as $key => $val){
			$Zprice += $val['price'] * $foodnum[$key];
		}
		//添加菜品详情
		foreach($foodlist as $key=>$val){
			if($val['id']){
				$cpdata[] = array(
					"cpid" => $val['id'],
					"openid" => $openid,
					"cp_num" => $foodnum[$key],
					"created" => time()
				);
			}
		}
		$cpArr = M("cp_list")->addAll($cpdata);
		$data = array(
			"id" => gettableid("CY"),
			"ctid" => $ctid,
			"ctime" => $ctime,
			"cdid" => $cdid,
			"jcaddress" => $jcaddress,
			"jcnum" => $Numss,
			"dishes" => $dishes,
			"vipname" => $pep,
			"vipphone" => $tel,
			"openid" => $openid,
			"special" => $bz,
			"paycost" => $Zprice,
			"tel" => $hdsure,
			"created" => time(),
			"status" => 1,
			"stime" => $degreeval,
			"address" => $address
		);
		$orderArr = M("order_cy")->add($data);
		if($orderArr){
			$reqparam = $this->requestPay($data['id'], $data['paycost']);
			\Think\Log::record("weixin购买挂耳参数：".json_encode($reqparam));
			$resArr = array(
				"success" => true,
				"id" => $data["id"], 
				"ctime" => $data['ctime'],
				"payparam" => $reqparam
			);
		}else{
			$resArr = array(
				"success" => flase,
				"msg" => "错误!"
			);
		}
		exit(json_encode($resArr));
	}
	
	private function requestPay($order_id, $amount){
		vendor('wx.WxPayApi');//导入微信类库
		vendor('wx.WxJsApiPay');
		
		$tools = new \WxJsApiPay();
		
		$input = new \WxPayUnifiedOrder();
		$input->SetBody("酒店餐饮");
		$input->SetAttach("保定电谷酒店");
		$input->SetOut_trade_no($order_id . time());
		$fee=floatval($amount)*100;
		$input->SetTotal_fee($fee);
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 600));
		$input->SetGoods_tag("");
		$input->SetNotify_url("http://diangu.yijiudian.cn/Wechat/WxRestaurant/index");
		$input->SetTrade_type("JSAPI");
		$input->SetOpenid($this->openid);
		
		$order = \WxPayApi::unifiedOrder($input);
		\Think\Log::record("挂耳咖啡生成订单，订单号：".$input->GetOut_trade_no());
		\Think\Log::record("参数：".json_encode($input->GetValues()));
		$jsApiParameters = $tools->GetJsApiParameters($order);
		\Think\Log::record("返回参数：".$jsApiParameters);
		return $jsApiParameters;
	}
	
	/*
	 * 就餐时段
	 */
	public function jctime(){
		$jctime = strtotime($_POST['jctime']);
		$time = strtotime(date("Y-m-d",time()));
		$dictArr = M("dict")->where("type = '餐段' and (val = 'breakfirst' or val = 'lunch' or val = 'dinner')")->select();
		if($jctime > $time){
			$resArr = array(
				"success" => true,
				"message" => $dictArr,
			);
		}else{
			$timeH = date("H",time());
			//餐段的显示与隐藏
			foreach($dictArr as $k=>$v){
				if($timeH > 9 && $v['name'] == '早餐'){
					unset($dictArr[$k]);
				}
				if($timeH > 15 && $v['name'] == "午餐"){
					unset($dictArr[$k]);
				}
				if($timeH >= 23 && $v['name'] == "晚餐"){
					unset($dictArr);
				}
			}
			$resArr = array(
				"success" => true,
				"message" => $dictArr
			);
		}
		exit(json_encode($resArr));
	}
}
