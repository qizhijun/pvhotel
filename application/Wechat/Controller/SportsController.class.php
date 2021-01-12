<?php
namespace Wechat\Controller;
use Common\Controller\WxBaseController; 
/**
 * 首页
 */
class SportsController extends WxBaseController {
	
	
	function _initialize() {
		parent::_initialize();
		$this->Sports_model = M("entertainment");
	}
	
	public function sports() {
		$Sports = $this->Sports_model->join("ejd_dict on ejd_dict.id = ejd_entertainment.etypeid","left")->where(array("isdel"=>0))->field("ejd_dict.name,ejd_entertainment.*")->select();
		$this->assign("Sports",$Sports);
		$this->assign("sports_curr","curr");
		$this->display();
	}
	public function sports_detail(){
		$id = I("get.id");
		$Sports_detail = $this->Sports_model
		->join("ejd_dict on ejd_dict.id = ejd_entertainment.etypeid","left")
		->where("ejd_entertainment.id='".$id."'")
		->field("ejd_dict.name,ejd_entertainment.ename,ejd_entertainment.picurls,ejd_entertainment.enaddress,ejd_entertainment.des,ejd_entertainment.entel,ejd_entertainment.begtime,ejd_entertainment.endtime,ejd_entertainment.perperson")
		->find();
		$picurls = json_decode($Sports_detail['picurls'],true);
		$this->assign("picurls",$picurls);
		$this->assign("Sports_detail",$Sports_detail);
		$this->assign("sports_curr","curr");
		$this->display();
	}
}
