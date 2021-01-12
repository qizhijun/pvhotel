<?php
namespace User\Controller;
use Common\Controller\AdminbaseController;
class WxAdminController extends AdminbaseController{
	
	function _initialize() {
		parent::_initialize();
		$this->FOCUS = M("fans");
	}
	function index(){
		$timeorder = $_GET["timeorder"] ? $_GET["timeorder"] : "onlinetime";
		$csort = $_GET["csort"] ? $_GET["csort"] : "DESC";
		$osort = $_GET["osort"] ? $_GET["osort"] : "DESC";
		$sort = ($timeorder == "onlinetime") ? $osort : $csort;
		$count=$this->FOCUS->count();
		$page = $this->page($count, 20);
		$focus = $this->FOCUS
		->order("subscribe DESC,subscribe_time DESC," . $timeorder . " " . $sort)
		->limit($page->firstRow . ',' . $page->listRows)
		->select();
		
        $this->assign("count",$count);
		$this->assign("page", $page->show('Admin'));
		$this->assign("WxAdmin",$focus);
		$this->display();
	}
}