<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class XymCodeController extends AdminbaseController{ 

	function _initialize(){ 
		parent::_initialize();
		$this->xymcode_model = M("xymcode");
	}
	
	function index(){
		//查询有效房型
		$roomArr = M("room")->where("iroom_status= 1")->field("id,room_name")->select();
		$this->assign("roomArr",$roomArr);
		$where = "ejd_xymcode.isdel = 1";
		$roomid=$_GET['roomid']=$_REQUEST["roomid"];
    	if($roomid){
    		$this->assign("roomid",$roomid);
    		$where .=" and ejd_xym_code.roomid=".$roomid;
    	}
    	$xymArr = $this->xymcode_model->join("ejd_xym_code on ejd_xym_code.xymid = ejd_xymcode.id","left")
		->where($where)
		->group("ejd_xymcode.id")
		->field("ejd_xym_code.roomid,ejd_xymcode.id,ejd_xymcode.starttime,ejd_xymcode.endtime,ejd_xymcode.type,ejd_xymcode.disprice")
		->select();
		$xymname = M("xym_code")->join("ejd_room on ejd_room.id = ejd_xym_code.roomid","left")->field("ejd_room.room_name,ejd_xym_code.xymid")->select();
		foreach($roomArr as $v){
			$arr[]=$v["room_name"];
		}
		foreach($xymArr as $k=>$v){
			$nameArr=array();
			foreach($xymname as $r){
				if($v["id"]==$r["xymid"]){ 
					$nameArr[]=$r["room_name"];
				}
			}
			$arr1 = array_diff($arr,$nameArr);
			$xymArr[$k]["room"]=implode(",",$arr1);
			$xymArr[$k]["room_name"]=implode(",",$nameArr);
		}
		$this->assign("xymArr",$xymArr);
		$this->display();
	}
	function add(){
		$roomArr = M("room")->where("iroom_status= 1")->field("id,room_name")->select();
		$this->assign("roomArr",$roomArr);
		$time = date('Y-m-d',time());
		$time1 = date("Y-m-d",strtotime("+1 day"));
		$this->assign("time",$time);
		$this->assign("time1",$time1);
		$this->display();
	}
	function add_post(){ 
		if(IS_PSOT){
			if($_POST['type'] == 1){
				if($_POST['disprice'] > 10){
					$_POST['disprice'] = 10;
				}
			} 
			$data = array(
				"starttime" => strtotime($_POST['starttime']),
				"endtime" => strtotime($_POST['endtime']),
				"type" => $_POST['type'],
				"disprice" => $_POST['disprice']
				);
			$xymcode = $this->xymcode_model->add($data);
			foreach($_POST['roomid'] as $val){ 
				$roomName[] = array(
					"roomid" => $val,
					"xymid" => $xymcode,
					"created" => time()
				);
			}
			if($xymcode){
				M("xym_code")->addAll($roomName);
				$this->success("添加成功！",U("XymCode/index"));
			}else{ 
				$this->error("添加失败！");
			}
		}
	}
	function delete(){
		$id = intval(I("get.id"));
		$isdel = I("get.isdel");
        if ($this->xymcode_model->where("id='" . $id . "'")->setField('isdel',$isdel)!==false) {
            $this->success("成功！",U("XymCode/index"));
        } else {
            $this->error("失败！". I("get.Status"));
        }
	}
}