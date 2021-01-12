<?php
namespace Wechat\Controller;
use Common\Controller\WxBaseController; 
/**
 * 首页
 */
class UserController extends WxBaseController {
	
	
	function _initialize() {
		$this->openid = $_SESSION['fans']['openid'] ? $_SESSION['fans']['openid'] : $_SESSION['fans']['id'];
		vendor('wx.WxApi');//导入微信类库
		$this->wxapi= new \WxApi();
		parent::_initialize();
	}
	
	
	//会员详细资料
	public function member(){
		$openid = $_SESSION['fans']['id'] ? $_SESSION['fans']['id'] : $_SESSION['fans']['openid'];
		$fansList = M("fans")->where(array("id"=>$openid))->field("name,sex,birthday,email,address,city_address")->find();
		$this->assign("fansList",$fansList);
		$this->assign("user_curr","curr");
		$this->display();
	}
	//会员中心
	public function user_center(){
		vendor("wx.WxJsApi");
		$jsapi=new \WxJsApi();
		$signPackage=$jsapi->getSignPackage();
		$this->assign("signJson",json_encode($signPackage));
		$openid = $_SESSION['fans']['id'] ? $_SESSION['fans']['id'] : $_SESSION['fans']['openid'];
		if($_SESSION['fans']['phone']){
			$fans=M("fans")->where(array(
				"id"=>$openid
			))->find();
			if($fans['nickname'] || $fans['headimgurl']){
				$this->assign("fans",$fans);
			}else{
				$fansInfo=$this->wxapi->getFocusInfo($openid);
				if($fansInfo){
					$fansData["nickname"]=urlencode($fansInfo["nickname"]);
					$fansData["sex"]=$fansInfo["sex"]==1?"男":"女";
					$fansData["headimgurl"]=$fansInfo["headimgurl"];
					$fansData["country"]=$fansInfo["country"];
					$fansData["province"]=$fansInfo["province"];
					$fansData["city"]=$fansInfo["city"];
					$fansData["subscribe_time"]=$fansInfo["subscribe_time"];
					$fansData["subscribe"]=1;
					$fansData["unionid"]=$fansInfo["unionid"];
					if($fans['id']){
						$fansInfos = M("fans")->where(array("id" => $openid))->save($fansData);
						$fans=M("fans")->where(array(
							"id"=>$openid
						))->find();
						$this->assign("fans",$fans);
					}
					
				}
			}
			$phone = $_SESSION['fans']['phone'];
			$this->assign("phone",$phone);
			$phoneA = substr_replace($phone,"****",3,4);
			$this->assign("phoneA",$phoneA);
			$this->assign("user_curr","curr");
			$this->display();
		}else{
			header("Location:".U('Wechat/User/reg'));
		}
		
	}
//注册页面
	public function reg(){
		if($_SESSION["fans"]["phone"]){//不是会员才可以注册
			header("Location:".U('Wechat/User/user_center'));
		}
		$this->display();
	}
	//注册用户
	public function regSave(){
		$txt_tel = trim($_POST["txt_tel"]);
		$txt_yzm=trim($_POST["txt_yzm"]);
		$openid = $_SESSION['fans']['id'] ? $_SESSION['fans']['id'] : $_SESSION['fans']['openid'];
		if($this->checkVcode($txt_tel,$txt_yzm)){
			$fans=$_SESSION["fans"];
			if($fans["phone"]){
				$resArr=array(
					"success"=>false,
					"message"=>"已经注册，不必再注册。"
				);
				exit(json_encode($resArr));
			}
			$openidUser = M("fans")->where(array("id"=>$openid))->find();
			$oldphone=M("fans")->where(array(
				"phone"=>$txt_tel
			))->find();
			if($oldphone){
				$resArr = array(
					"success"=>false,
					"message"=>"这个手机号已经注册过了,不必再注册。"
				);
				$_SESSION['fans']['phone'] = $oldphone['phone'];
				exit(json_encode($resArr));
			}else{
				if(!$fans['phone']){
					
					if($openidUser){
						$data = array(
							"phone" => $txt_tel,
							"created" => time()
						);
						$resPhone = M("fans")->where(array("id"=>$openidUser['id']))->save($data);
						if($resPhone){
							$_SESSION['fans']['phone'] = $txt_tel;
							$resArr=array(
								"success" =>true,
								"message"=>"注册成功!"
							);
						}else{
							$resArr=array(
								"success" =>false,
								"message"=>"注册失败!"
							);
						}
						exit(json_encode($resArr));
					}else{
						$data = array(
							"id" => $_SESSION['fans']['id'] ? $_SESSION['fans']['id'] : $_SESSION['fans']['openid'],
							"phone" => $txt_tel,
							"created" => time()
						);
						$resPhone = M("fans")->add($data);
						if($resPhone){
							$_SESSION['fans']['phone'] = $txt_tel;
							$resArr=array(
								"success" =>true,
								"message"=>"注册成功!"
							);
						}else{
							$resArr=array(
								"success" =>false,
								"message"=>"注册失败!"
							);
						}
						exit(json_encode($resArr));
					}
				}
			}
		}else{
			$resArr=array(
				"success" =>false,
				"message"=>"验证码错误!"
			);
		}
		
		exit(json_encode($resArr));
	}
	//发送短信
	public function sendVcode(){
		
		$phone=trim($_POST['txt_tel']);
		$vcode=rand_string(4,1);
		$message="验证码为：".$vcode."，十分钟内有效。";
		
		$messageArr=array(
			"phone"=>$phone,
			"message"=>$vcode,
			"created"=>time()
		);
		//判断手机是否使用过
		$olduser=M("fans")->where(array(
			"phone"=>$phone
		))->find();
		if($olduser){
			$resArr=array(
				"success"=>false,
				"message"=>"手机号已经注册，请更换"
			);
			exit(json_encode($resArr));
		}
		$resArr=array(
			"success"=>false,
			"message"=>"发送失败"
		);
		if($this->_sendMsg($phone,$message)){
			$resArr=array(
				"success"=>true,
				"message"=>"发送成功"
			);
			$messageArr["status"]=1;
		}
		M("message")->add($messageArr);
		exit(json_encode($resArr));
	}
	public function sendVcode1(){
		$phone=trim($_POST['txt_tel']);
		$vcode=rand_string(4,1);
		$message="验证码为：".$vcode."，十分钟内有效。";
		
		$messageArr=array(
			"phone"=>$phone,
			"message"=>$vcode,
			"created"=>time()
		);
		$resArr=array(
			"success"=>false,
			"message"=>"发送失败"
		);
		if($this->_sendMsg($phone,$message)){
			$resArr=array(
				"success"=>true,
				"message"=>"发送成功"
			);
			$messageArr["status"]=1;
		}
		M("message")->add($messageArr);
		exit(json_encode($resArr));
	}
	
	//检查验证码
	private function checkVcode($phone,$vcode){
		$vcodeArr=M("message")->where(array(
			"phone"=>$phone
		))->order("id desc")->find();
		if($vcodeArr){
			$suff=time()-$vcodeArr["created"];
			$fen=$suff/60;
			\Think\Log::record($vcode."最新验证码".$suff."秒".$fen."分".json_encode($vcodeArr),'WARN');
			if($fen<10&&$vcode==$vcodeArr["message"]){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	//修改用户名称
	function nameSave(){
		if(IS_POST){
			$openid = $_SESSION['fans']['id'] ? $_SESSION['fans']['id'] : $_SESSION['fans']['openid'];
			$nickname = $_POST['nickname'];
			$data = array(
				"nickname" => urlencode($nickname)
			);
			$nickRes = M("fans")->where(array("id"=>$openid))->save($data);
			if($nickRes){
				$resArr = array(
					"code" => 0,
					"data" => "修改成功！"
				);
			}else{
				$resArr = array(
					"code" => 1,
					"data" => "修改失败！"
				);
			}
		}
		exit(json_encode($resArr));
	}
	//修改手机号
	function phoneSave(){
		if(IS_POST){
			$openid = $_SESSION['fans']['id'] ? $_SESSION['fans']['id'] : $_SESSION['fans']['openid'];
			$phone = $_POST['txt_tel'];
			$data = array(
				"phone" => $phone
			);
			$phoneRes = M("fans")->where(array("id"=>$openid))->save($data);
			if($phoneRes){
				$_SESSION['fans']['phone'] = $phone;
				$resArr = array(
					"success" => true,
					"message" => "修改成功！"
				);
			}else{
				$resArr = array(
					"success" => false,
					"message" => "修改失败！"
				);
			}
		}
		exit(json_encode($resArr));
	}
	//客房订单
	function roomorder(){
		$openid = $_SESSION['fans']['id'] ? $_SESSION['fans']['id'] : $_SESSION['fans']['openid'];
		$roomList = M("order")
		->join("ejd_room on ejd_room.id = ejd_order.roomid","left")
		->join("ejd_room_rp on ejd_room_rp.id = ejd_order.rpid","left")
		->where(array("ejd_order.vipid"=>$openid))
		->field("ejd_room.room_name,ejd_room_rp.rateplanname,ejd_order.id,ejd_order.created,ejd_order.status,ejd_order.amount,ejd_order.begtime,ejd_order.endtime")
		->select();
		$this->assign("roomList",$roomList);
		$this->assign("user_curr","curr");
		$this->display();
	}
	function roomorderlist(){
		$orderid = I("get.id");
		$orderList = M("order")
		->join("ejd_room on ejd_room.id = ejd_order.roomid","left")
		->join("ejd_room_rp on ejd_room_rp.id = ejd_order.rpid","left")
		->where(array("ejd_order.id"=>$orderid))
		->field("ejd_order.*,ejd_room.room_name,ejd_room.category_type,ejd_room_rp.bfservice,ejd_room_rp.rateplanname")
		->find();
		$vipname = json_decode($orderList['vipname'],true);
		$this->assign("vipname",$vipname);
		$infoList = M("hotel_info")->field("hotel_tel,hotel_address")->find();
		$this->assign("infoList",$infoList);
		$this->assign("orderList",$orderList);
		$this->display();
	}
	function delete(){
		$orderid = $_POST["id"];
		$status = $_POST['status'];
		if (M("order")->where("id='" . $orderid . "'")->setField('status',$status)!==false) {
            $resArr = array(
            	"code" => 0,
            	"data" => "取消订单成功!"
            );
        } else {
            $resArr = array(
            	"code" => 1,
            	"data" => "取消订单失败!"
            );
        }
		exit(json_encode($resArr));
		
	}
	//餐饮订单
	public function cyorder(){
		$openid = $_SESSION['fans']['id'] ? $_SESSION['fans']['id'] : $_SESSION['fans']['openid'];
		$cyList = M("order_cy")
		->join("ejd_restaurant on ejd_restaurant.id = ejd_order_cy.ctid","left")
		->where("ejd_order_cy.openid = '".$openid."' and ejd_order_cy.status != 1")
		->field("ejd_restaurant.resname,ejd_order_cy.paycost,ejd_order_cy.created,ejd_order_cy.status,ejd_order_cy.ctime,ejd_order_cy.id")
		->order("ejd_order_cy.created desc")
		->select();
		$this->assign("cyList",$cyList);
		$this->assign("user_curr","curr");
		$this->display();
	}
	
	function cydelete(){
		$orderid = $_POST["id"];
		$status = $_POST['status'];
		if (M("order_cy")->where("id='" . $orderid . "'")->setField('status',$status)!==false) {
            $resArr = array(
            	"code" => 0,
            	"data" => "取消订单成功!"
            );
        } else {
            $resArr = array(
            	"code" => 1,
            	"data" => "取消订单失败!"
            );
        }
		exit(json_encode($resArr));
		
	}
	//餐饮微信支付
	function cyorderPay(){
		$openid = $_SESSION['fans']['openid'] ? $_SESSION['fans']['openid'] : $_SESSION['fans']['id'];
		$cyid = $_POST['cyid'];
		$orderArr = M("order_cy")->where(array("id"=>$cyid))->find();
		if($orderArr){
			$reqparam = $this->requestPay($orderArr['id'], $orderArr['paycost']);
			\Think\Log::record("weixin购买挂耳参数：".json_encode($reqparam));
			$resArr = array(
				"success" => true,
				"id" => $orderArr["id"], 
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
	//休闲娱乐订单
	public function ylorder(){
		$this->assign("user_curr","curr");
		$this->display();
	}
	//会议订单
	public function hyorder(){
		$yhList = M("order_yh")
		->join("ejd_conferenceroom on ejd_conferenceroom.id = ejd_order_yh.cid","left")
		->where(array("ejd_order_yh.uid"=>$this->openid))
		->order("ejd_order_yh.created desc")
		->field("ejd_conferenceroom.crname,ejd_conferenceroom.crprice,ejd_order_yh.*")
		->select();
		$this->assign("yhList",$yhList);
		$this->assign("user_curr","curr");
		$this->display();
	}
	public function hyorderlist(){
		$id=I("get.id");
		$YHlist = M("order_yh")->join("ejd_conferenceroom on ejd_conferenceroom.id = ejd_order_yh.cid","left")->where(array("ejd_order_yh.id"=>$id))->field("ejd_conferenceroom.crname,ejd_conferenceroom.crprice,ejd_order_yh.*")->find();
		$infoList = M("hotel_info")->field("hotel_tel,hotel_address")->find();
		$this->assign("infoList",$infoList);
		$this->assign("YHlist",$YHlist);
		$this->display();
	}
	function yhdelete(){
		$orderid = $_POST["id"];
		$status = $_POST['status'];
		if (M("order_yh")->where("id='" . $orderid . "'")->setField('isdel',$status)!==false) {
            $resArr = array(
            	"code" => 0,
            	"data" => "作废!"
            );
        } else {
            $resArr = array(
            	"code" => 1,
            	"data" => "取消订单失败!"
            );
        }
		exit(json_encode($resArr));
		
	}
	//积分
	public function jifen(){
		$this->assign("user_curr","curr");
		$this->display();
	}
	//付款记录
	public function paylist(){
		$this->assign("user_curr","curr");
		$this->display();
	}
	//全员畅销
	public function changxiao(){
		$this->display();
	}
	//完善资料
	public function changeinfo(){
		
		$openid = $_SESSION['fans']['id'] ? $_SESSION['fans']['id'] : $_SESSION['fans']['openid'];
		$name = $_POST['name'];
		$sex = $_POST['sex'] == 1 ? "男" : "女";
		$birthday = $_POST['birthday'];
		$email = $_POST['email'];
		$addressval = $_POST['addressval'];
		$txtaddress = $_POST['txtaddress'];
		$data = array(
			"name" => $name,
			"sex" => $sex,
			"birthday" => $birthday,
			"email" => $email,
			"address" => $addressval,
			"city_address" => $txtaddress
		);
		$fansList = M("fans")->where(array("id"=>$openid))->save($data);
		if($fansList){
			$resArr = array(
				"code" => 0,
				"data" => "成功更新资料"
			);
		}else{
			$resArr = array(
				"code" => 1,
				"data" => "更新资料失败"
			);
		}
		exit(json_encode($resArr));
	}
	//修改头像
		
	/**
	 * 保存信息
	 */
	public function signsave(){
		$openid = $_SESSION['fans']['id'] ? $_SESSION['fans']['id'] : $_SESSION['fans']['openid'];
		$imageid = $_POST['imageid'];
		if(!empty($imageid)){
			vendor('wx.WxApi');
			$filename = "Uploads/img/".time().".jpg";
			\WxApi::downImg($imageid,$filename);
			$data = array(
				"headimgurl" => "/" . $filename, 
			);
			if(M("fans")->where(array("id"=>$openid))->save($data)){
				$resArr=array(
					"success"=>true,
					"msg" => "/".$filename
				);
			}else{
				$resArr=array(
					"success" => false, 
					"msg" => "图片修改失败"
				);
			}
		}else{
			$resArr=array(
				"success" => false, 
				"msg" => "图片上传失败，请重试。"
			);
		}
		exit(json_encode($resArr));
	}

}
