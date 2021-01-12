<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class MainController extends AdminbaseController {
	
    public function index(){
    	
    	$mysql= M()->query("select VERSION() as version");
    	$mysql=$mysql[0]['version'];
    	$mysql=empty($mysql)?L('UNKNOWN'):$mysql;
    	
    	//server infomaions
    	$info = array(
    			L('OPERATING_SYSTEM') => PHP_OS,
    			L('OPERATING_ENVIRONMENT') => $_SERVER["SERVER_SOFTWARE"],
    			L('PHP_RUN_MODE') => php_sapi_name(),
    			L('MYSQL_VERSION') =>$mysql,
    			L('PROGRAM_VERSION') => SIMPLEWIND_CMF_VERSION . "&nbsp;&nbsp;&nbsp; [<a href='http://www.thinkcmf.com' target='_blank'>ThinkCMF</a>]",
    			L('UPLOAD_MAX_FILESIZE') => ini_get('upload_max_filesize'),
    			L('MAX_EXECUTION_TIME') => ini_get('max_execution_time') . "s",
    			L('DISK_FREE_SPACE') => round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M',
    	);
		$kfOrder = M("order")->where("status <3 and status > 0 and amount > 1")->count();
		$this->assign("kfOrder",$kfOrder);
		$cyOrder = M("order_cy")->where("status <3 and status > 0")->count();
		$this->assign("cyOrder",$cyOrder);
		$yhOrder = M("order_yh")->where("isdel = 0")->count();
		$this->assign("yhOrder",$yhOrder);
		$fans = M("fans")->where("subscribe = 1")->order("created desc")->limit(5)->select();
		$this->assign("fans",$fans);
    	$this->assign('server_info', $info);
    	$this->display();
    }
	function orderPrompt(){
		$time = date("Y-m-d",time());
		$roomOrder = M("order")->join("ejd_room on ejd_room.id = ejd_order.roomid","left")->where("ejd_order.status <3 and ejd_order.status > 0  and ejd_order.amount > 1")->field("ejd_room.room_name,ejd_order.roomid")->select();
		$cyOrder = M("order_cy")->join("ejd_restaurant on ejd_restaurant.id = ejd_order_cy.ctid" ,"left")->where("ejd_order_cy.status < 3 and ejd_order_cy.status > 1")->field("ejd_order_cy.ctid,ejd_restaurant.resname")->select();
		$yhOrder = M("order_yh")->join("ejd_conferenceroom on ejd_conferenceroom.id = ejd_order_yh.cid","left")->where("ejd_order_yh.isdel = 0")->field("ejd_conferenceroom.crname")->select();
		$data = array(
			"kforder" => $roomOrder,
			"cyorder" => $cyOrder,
			"yhorder" => $yhOrder
		);
		if($data){
			$resArr = array(
				"code" => 0,
				"data" => $data
			);
		}else{
			$resArr = array(
				"code" => 1,
				"data" => ""
			);
		}
		exit(json_encode($resArr));
	}
}