<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Bill <shkbill@qq.com>
// +----------------------------------------------------------------------
namespace Wechat\Controller;
use Common\Controller\WxBaseController; 
/**
 * 首页
 */
class SalaryController extends WxBaseController {
	
	function _initialize() {
		parent::_initialize();
		$this->Memeber = M("member");
		$this->SalaryFile = M("salary_file");
		$this->SalaryList = M("salary_list");
	}
	
    //工资明细
	public function index() {
		$openid=$_SESSION["fans"]["openid"] ? $_SESSION["fans"]["openid"] : $_SESSION["fans"]["id"];
		$id=$_GET["id"];
		if(empty($id)){
			$this->error("参数错误");
		}
		
		//查询职员信息
		$member=$this->Memeber->where("openid='".$openid."' and isdel=0")->find();
		if(empty($member)||empty($member["status"])){
			$this->error("请先认证员工信息",U("wechat/Salary/reg"));
		}
		//查询工资信息
		$salaryone=$this->SalaryList->where(array(
			"id"=>$id,
			"phone"=>$member["phone"]
		))->find();
		
		if(empty($salaryone)){
			$this->error("工资信息不存在",U("wechat/Salary/salarylist"));
		}
		
		$salaryone["postname"]=$member["postname"];
		$salaryone["name"]=$member["name"];
		$this->assign("salaryone",$salaryone);
		$this->display("info");
    }
	
	//工资列表
	public function salarylist(){
		$openid=$_SESSION["fans"]["openid"] ? $_SESSION["fans"]["openid"] : $_SESSION["fans"]["id"];
		
		$this->display();
	}
	
	//注册公司员工
	public function reg(){
		$openid=$_SESSION["fans"]["openid"] ? $_SESSION["fans"]["openid"] : $_SESSION["fans"]["id"];
		$memeberOne=$this->Memeber->where("openid='".$openid."' and isdel=0")->find();
		if($memeberOne){//如果已经注册过员工，不应该继续注册
			$this->success("您已经认证过员工，管理员审核后可收到通知。");
		}else{
			$this->display();
		}
	}
	
	//注册过程
	public function regSave(){
		$openid=$_SESSION["fans"]["openid"] ? $_SESSION["fans"]["openid"] : $_SESSION["fans"]["id"];
		$name=trim($_POST["name"]);
		$phone=trim($_POST["phone"]);
		$vcode=trim($_POST["vcode"]);
		$member = $this->Memeber->where("openid='".$openid."' and isdel=1")->find();
		if($member){
			$res=$this->Memeber->where(array("id"=>$member['id']))->save(array(
				"name"=>$name,
				"phone"=>$phone,
				"openid"=>$openid,
				"created"=>time(),
				"status"=>0,
				"isdel" => 0
			));
		}else{
			$res=$this->Memeber->add(array(
				"name"=>$name,
				"phone"=>$phone,
				"openid"=>$openid,
				"created"=>time(),
				"status"=>0
			));
		}
		if($res){
			$resArr=array(
				"success"=>true,
				"message"=>"操作成功",
				"url"=>U("wechat/Salary/reg")
			);
		}else{
			$resArr=array(
				"success"=>true,
				"message"=>"操作失败"
			);
		}
		exit(json_encode($resArr));
	}
	
	//发送验证码
	public function sendVcode(){
		$phone=trim($_POST['phone']);
		
		$vcode=rand_string(4,1);
		$message="验证码为：".$vcode."，十分钟内有效。";
		
		$messageArr=array(
			"phone"=>$phone,
			"message"=>$vcode,
			"created"=>time()
		);
		
		//判断手机是否使用过
		$olduser=M("member")->where(array(
			"phone"=>$phone,"isdel"=>0
		))->find();
		
		if($olduser){
			$resArr=array(
				"success"=>false,
				"message"=>"手机号已经认证过员工，请更换"
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
}


