<?php
namespace Wechat\Controller;
use Common\Controller\WxBaseController; 
/**
 * 首页
 */
class ShakeController extends WxBaseController {
	
	
	function _initialize() {
		parent::_initialize();
	}
	
	
	//摇奖页面
	public function index() {
		$this->success("活动已经结束");exit();
		//判断抽奖次数
		$openid=empty($_SESSION["fans"]["openid"])?$_SESSION["fans"]["id"]:$_SESSION["fans"]["openid"];
		$shakeList=M("shake_list")->where("openid='".$openid."'")->select();
		
		//判断中奖
		$iszhong=false;
		foreach($shakeList as $value){
			if($value["prizeid"]){
				$iszhong=true;
				break;
			}
		}
		if($iszhong){
			header("Location:".U("Wechat/Shake/res"));
			exit();
		}
		$yu=3-count($shakeList);
		$yu=$yu>0?$yu:0;
		$this->assign("shakenum",$yu);
		$this->display();
    }
	
	//判断是否获奖
	public function getPrize(){
		$xian=$_POST["xian"];
		$openid=empty($_SESSION["fans"]["openid"])?$_SESSION["fans"]["id"]:$_SESSION["fans"]["openid"];
		//判断次数够了吗
		$count=M("shake_list")->where("openid='".$openid."'")->count();
		if($count>=3){
			$resArr=array(
				"success"=>false,
				"shakenum"=>0,
				"message"=>"您的摇奖机会已经用完"
			);
			exit(json_encode($resArr));
		}
		
		//如果概率没对上，直接回复
		$gl=array(0,0,0,0,1,0,0,0,0,0);
		$iswin=$gl[rand(0,count($gl)-1)];//10%的中奖概率
		if(empty($iswin)){
			$this->setHis();
		}
		
		//查询奖品内容
		$prizeArr=M("shake_prize")->where("status=0")->select();
		if(count($prizeArr)>0){
			$prizeOne=$prizeArr[rand(0,count($prizeArr)-1)];
			
			//增加记录
			M("shake_list")->add(array(
				"openid"=>$openid,
				"prizeid"=>$prizeOne["id"],
				"created"=>time()
			));
			//修改奖品状态
			M("shake_prize")->where(array(
				"id"=>$prizeOne["id"]
			))->save(array(
				"status"=>1,
				"openid"=>$openid,
				"created"=>time()
			));
			
			$count=M("shake_list")->where("openid='".$openid."'")->count();
			$yu=3-$count;
			$resArr=array(
				"success"=>true,
				"message"=>"中奖了"
			);
			exit(json_encode($resArr));
		}else{
			$this->setHis();
		}
	}
	
	//添加摇奖记录
	public function setHis(){
		$openid=empty($_SESSION["fans"]["openid"])?$_SESSION["fans"]["id"]:$_SESSION["fans"]["openid"];
		M("shake_list")->add(array(
			"openid"=>$openid,
			"created"=>time()
		));
		$count=M("shake_list")->where("openid='".$openid."'")->count();
		$yu=3-$count;
		
		$resArr=array(
			"success"=>false,
			"message"=>"未中奖，谢谢参与",
			"shakenum"=>$yu>0?$yu:0
		);
		exit(json_encode($resArr));
	}
	
	//中奖页面
	public function res(){
		$openid=empty($_SESSION["fans"]["openid"])?$_SESSION["fans"]["id"]:$_SESSION["fans"]["openid"];
		//查询中奖项目
		$prizeOne=M("shake_prize")->where("openid='".$openid."' and status=1")->find();
		
		$this->assign("prize",$prizeOne);
		$this->display();
	}
	
	public function setData(){
		$data=array(
			array(
				"title"=>"一等奖",
				"name"=>"大千湖有机鲜鱼一条",
				"num"=>5
			),
			array(
				"title"=>"二等奖",
				"name"=>"电谷国际酒店手工月饼一包",
				"num"=>10
			),
			array(
				"title"=>"三等奖",
				"name"=>"低碳公园运动健身券",
				"num"=>15
			),
			array(
				"title"=>"纪念奖",
				"name"=>"麻辣烫20元代金券",
				"num"=>20
			)
		);
		
		//添加数据
		$baseData=array();
		foreach($data as $value){
			for($i=0;$i<$value["num"];$i++){
				$baseData[]=array(
					"title"=>$value["title"],
					"name"=>$value["name"],
				);
			}
		}
		
		$res=M("shake_prize")->addAll($baseData);
		var_dump($res);
	}
}
