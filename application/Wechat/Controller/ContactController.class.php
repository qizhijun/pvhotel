<?php
namespace Wechat\Controller;
use Common\Controller\WxBaseController; 
/**
 * 首页
 */
class ContactController extends WxBaseController {
	
	
	function _initialize() {
		parent::_initialize();
		$this->Hotel_Info_model = M("hotel_info");
	}
	
	public function info() {
		$where = "isdel = 0";
		$Hotel_Info = $this->Hotel_Info_model->where($where)->find();
		$this->assign("Hotel_Info",$Hotel_Info);
		$this->display();
	}
}
