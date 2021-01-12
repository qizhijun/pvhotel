<?php
namespace Wechat\Controller;
use Common\Controller\WxBaseController; 
/**
 * 首页
 */
class ConferenceroomController extends WxBaseController {
	
	
	function _initialize() {
		parent::_initialize();
		$this->Conferenceroom_model = M("conferenceroom");
		$this->openid = $_SESSION['fans']['openid'] ? $_SESSION['fans']['openid'] : $_SESSION['fans']['id'];
	}
	
	public function meeting() {
		//查询所有的宴会厅信息
		$phone = $_SESSION['fans']['phone'];
		$this->assign("phone",$phone);
		$Conferenceroom = $this->Conferenceroom_model->where(array("isdel"=>0))->order("sortindex desc")->select();
		$this->assign("Conferenceroom",$Conferenceroom);
		$this->assign("meeting_curr","curr");
		$this->display();
	}
	
	public function meeting_book(){
		//订单宴会厅信息
		$phone = $_SESSION['fans']['phone'];
		$truename = M("fans")->where(array("phone"=>$phone))->field("name")->find();
		$this->assign("truename",$truename);
		$this->assign("phone",$phone);
		$id = I("get.id");
		$Conferenceroom = $this->Conferenceroom_model->where(array("id"=>$id))->field("id,crname")->find();
		$this->assign("Conferenceroom",$Conferenceroom);
		$this->display();
	}
	public function meeting_detail(){
		//获取单个宴会厅的id
		$id=I("get.id");
		//查询宴会厅的信息
		$Meeting = $this->Conferenceroom_model->where("id='".$id."'")->find();
		//宴会厅类型
		$jypersonnum = json_decode($Meeting['jypersonnum'],true);
		foreach($jypersonnum as $key=>$vo){
			if($vo > 0){
				$jype[] = $vo;
				$j[$key] = $key;
				$jyp[$key] = $vo;
			}
		}
		//转成字符串
		$jy = implode(",", $j);
		//查询宴会厅类型名称
		$tmp['id'] = array("in",$jy);
		$Name = M("dict")->where($tmp)->field("id,name")->select();
		$this->assign("Name",$Name);
		$this->assign("jype",$jype);
		$this->assign("jyp",$jyp);
		//宴会厅总面积
		$area = ceil($Meeting['clong']*$Meeting['cwide']);
		$this->assign("area",$area);
		$this->assign("Meeting",$Meeting);
		$this->assign("meeting_curr","curr");
		$this->display();
	}
	//订单
	public function meeting_post(){
		$yhid = $_POST['yhid'];
		$time = $_POST['time'];
		$meettype = $_POST['meettype'];
		$txtBanquetNum = $_POST['txtBanquetNum'];
		$txtRemark = $_POST['txtRemark'];
		$linkname = $_POST['linkname'];
		$linkphone = $_POST['linkphone'];
		$hdsure = $_POST['hdsure'];
		$data = array(
			"id" => gettableid("YH"),
			"cid" => $yhid,
			"uid" => $this->openid,
			"linkname" => $linkname,
			"linkphone" => $linkphone,
			"plantime" => strtotime($time),
			"meettype" => $meettype,
			"people" => $txtBanquetNum,
			"remark" => $txtRemark,
			"isphone" => $hdsure,
			"created" => time(),
			"isdel" => 0
		);
		$yhorder = M("order_yh")->add($data);
		if($yhorder){
			$resArr = array(
				"success" => true,
				"id" => $data["id"],
				"msg" => "成功！"
			);
		}else{
			$resArr = array(
				"success" => flase,
				"msg" => "数据错误！"
			);
		}
		exit(json_encode($resArr));
	}
	public function orderlist(){
		$id = I("get.id");
		$YHorder = M("order_yh")->where(array("ejd_order_yh.id"=>$id))->join("ejd_conferenceroom on ejd_conferenceroom.id=ejd_order_yh.cid","left")->field("ejd_conferenceroom.crname,ejd_order_yh.id")->find();
		$this->assign("YHorder",$YHorder);
		$this->display();
	}
}
