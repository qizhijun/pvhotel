<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace Portal\Controller;
use Common\Controller\HomebaseController; 
/**
 * 首页
 */
class IndexController extends HomebaseController {
	private $roomM;
	public function __construct(){
		parent::__construct();
		$this->roomM=M("room");
		$this->slides_model = M("slide");
	}
    //首页
	public function index() {
		//查询房型信息
		$where = "ejd_room.iroom_status=1";
		$roomArr = $this->roomM->where($where)->field("id,room_name")->select();
		$roomList=$this->roomM
		->join("ejd_room_price on ejd_room_price.hotel_id = ejd_room.id and ejd_room_price.ctime = '".strtotime(date("Y-m-d",time()))."'","left")
		->where($where)
		->field("ejd_room.sort_index,ejd_room.id,ejd_room.room_name,ejd_room.clevel_price0,ejd_room.descp,ejd_room_price.price,ejd_room_price.ctime,ejd_room.pics")
		->order("ejd_room.id ASC")
		->limit(4)
		->group("ejd_room.id")
		->select();
		//echo M("room")->getLastSql();
		//幻灯片
		
		$slides = $this->slides_model->where(array("slide_status"=>1))->limit(4)->order("listorder ASC")->select();
		
		$begtime = date("Y-m-d",time());
		$endtime = date("Y-m-d",strtotime("+1 days"));
		$this->assign("begtime",$begtime);
		$this->assign("endtime",$endtime);
		$this->assign("slides",$slides);
		$this->assign("roomList",$roomList);
		$this->assign("roomArr",$roomArr);
    	$this->display();
    }
	
	//联系人
	public function contact(){
		$info = M("hotel_info")->field("hotel_name,hotel_tel,lng,lat,gps_address,address")->find();
		$hotel_contact = M("hotel_contact")->select();
		if(IS_POST){
			$name = $_POST['name'];
			$email = $_POST['email'];
			$des = $_POST['des'];
			$code = $_POST["verify"];
			if(empty($name)){
				$this->error("姓名不能为空！");
			}
			if(empty($email)){
				$this->assign("邮箱不能为空！");
			}
			if(empty($des)){
				$this->error("留言内容不能为空！");
			}
			if(empty($code)){
				$this->error("验证码不能为空！");
			}
			$mode = '/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/';
			if(!preg_match($mode,$email)){
				$this->error("邮箱格式不正确！");
			}
			if(!sp_check_verify_code()){
				$this->error("验证码错误！");
			}
			
			$data = array(
				"name" => $name,
				"email" => $email,
				"des" => $des,
				"code" => $code,
				"created" => time(),
				"isdel" => -1
			);
			$contact = M("contacts")->add($data);
			if($contact){
				$this->success("留言成功！",U("Index/contact"));
			}else{
				$this->error("留言失败！");
			}
		}
		$this->assign("hotel_contact",$hotel_contact);
		$this->assign("hotel_info",$info);
		$this->display();
	}
	
	public function tt(){
		vendor("wx.WxTemplate");
		$res=\WxTemplate::salaryMsg("oodwHjxOU57ig0PILyg3QfEotxnU","http://www.baidu.com","王伟，这是测试数据","8月份","10W元","10W元","0元","0元","注：五险一金不在本页面显示，如果疑问，请联系人力资源部");
		\Think\Log::record("发送结果：".json_encode($res));
		echo json_encode($res);
	}
}


