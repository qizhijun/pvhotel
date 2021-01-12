<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class OrderController extends AdminbaseController{ 

	function _initialize(){ 
		parent::_initialize();
		$this->order_model = M("order");
		$this->order_yh_model = M("order_yh");
		$this->order_cy_model = M("order_cy");
	}

	//客房订单
	function kflist(){
		//查询条件 订单类型是客房的 
		//$where = "ejd_order.ordertype = 1";
		$where = "ejd_order.status = 1";
		$status=$_GET['status']=$_REQUEST["status"];
    	if($status){
    		$this->assign("status",$status);
    		$where=" ejd_order.status=".$status;
    	}
		$type=$_GET['type']=$_REQUEST["type"];
    	if($type){
    		$this->assign("type",$type);
    		$where.=" and ejd_order.type=".$type;
    	}
		$keyname = $_GET['keyname'] = $_REQUEST['keyname'];
		
		if($keyname){
			$this->assign("keyname",$keyname);
			$where .=" and ejd_order.id like '%".$keyname."%' or ejd_order.vipphone like '%".$keyname."%'";
		}
		
		$where .= " and ejd_order.amount > 1";
		//统计客房订单
		$count = $this->order_model->where($where)->count();
		//每页显示10条
		$page = $this->page($count, 10);
		//查询出客房订单
		$kforderArr = $this->order_model
		->join("ejd_room on ejd_room.id = ejd_order.roomid","left")
		->join("ejd_room_rp on ejd_room_rp.id = ejd_order.rpid","left")
		->field("ejd_room.room_name,ejd_room_rp.rateplanname,ejd_order.id,ejd_order.vipname,ejd_order.vipphone,ejd_order.amount,ejd_order.paycost,ejd_order.created,ejd_order.status,ejd_order.begtime,ejd_order.type")
		->where($where)
		
    	->order("ejd_order.created desc")
    	->limit($page->firstRow . ',' . $page->listRows)
    	->select();
    	$this->assign("count",$count);
    	$this->assign("page",$page->show("Admin"));
    	$this->assign("kforderArr",$kforderArr);
    	$this->display();
	}

	//餐饮订单
	function cylist(){
		$where = "ejd_order_cy.status = 2";
		$status=$_GET['status']=$_REQUEST["status"];
    	if($status){
    		$this->assign("status",$status);
    		$where=" ejd_order_cy.status=".$status;
    	} 
		$keyname = $_GET['keyname'] = $_REQUEST['keyname'];
		if($keyname){
			$this->assign("keyname",$keyname);
			$where =" ejd_order_cy.vipname like '%".$keyname."%' or ejd_order_cy.vipphone like '%".$keyname."%'";
		}
		//统计餐饮订单
		$count = $this->order_cy_model->where($where)->count();
		//每页显示10条
		$page = $this->page($count, 10);
		//查询出餐饮订单
		$cyorderArr = $this->order_cy_model
		->join("ejd_restaurant on ejd_restaurant.id = ejd_order_cy.ctid","left")
		->join("ejd_dict on ejd_dict.id = ejd_order_cy.cdid","left")
		->where($where)
		->field("ejd_restaurant.resname,ejd_order_cy.id,ejd_order_cy.vipname,ejd_order_cy.vipphone,ejd_order_cy.paycost,ejd_order_cy.created,ejd_order_cy.status,ejd_dict.name,ejd_order_cy.ctime,ejd_order_cy.openid,ejd_order_cy.tel,ejd_order_cy.automn")
    	->order("ejd_order_cy.created desc")
    	->limit($page->firstRow . ',' . $page->listRows)
    	->select();
    	$this->assign("count",$count);
    	$this->assign("page",$page->show("Admin"));
    	$this->assign("cyorderArr",$cyorderArr);
    	$this->display();
	}

	//会议宴会问询
	function hyyhlist(){
		$where = "ejd_order_yh.isdel = 0"; 
		$isdel=$_GET['isdel']=$_REQUEST["isdel"];
    	if($isdel){
    		$this->assign("isdel",$isdel);
    		$where=" ejd_order_yh.isdel=".$isdel;
    	} 
		$keyname = $_GET['keyname'] = $_REQUEST['keyname'];
		if($keyname){
			$this->assign("keyname",$keyname);
			$where .=" and (ejd_order_yh.linkname like '%".$keyname."%' or ejd_order_yh.linkphone like '%".$keyname."%' or ejd_order_yh.id like '%".$keyname."%')";
		}
		//统计会议宴会问询
		$count = $this->order_yh_model->where($where)->count();
		//每页显示10条
		$page = $this->page($count, 10);
		//查询出会议宴会问询
		$hyyhorderArr = $this->order_yh_model
		->join("ejd_conferenceroom on ejd_conferenceroom.id = ejd_order_yh.cid","left")
		->where($where)
		->field("ejd_conferenceroom.crname,ejd_order_yh.id,ejd_order_yh.linkname,ejd_order_yh.linkphone,ejd_order_yh.plantime,ejd_order_yh.meettype,ejd_order_yh.created,ejd_order_yh.isdel,ejd_order_yh.people,ejd_order_yh.remark,ejd_order_yh.isphone")
    	->order("ejd_order_yh.created desc")
    	->limit($page->firstRow . ',' . $page->listRows)
    	->select();
    	$this->assign("count",$count);
    	$this->assign("page",$page->show("Admin"));
    	$this->assign("hyyhorderArr",$hyyhorderArr);
    	$this->display();
	}
	public function yhorder(){
		$id = I('get.id');
		$status = I("get.status");
		if($status=="2"){
			if(M("order_yh")->where(array("id"=>$id))->setField("isdel",$status)!==false){
				$this->success("确认订单成功!",U('Order/hyyhlist'));
			}else{
				$this->error("确认订单失败!");
			}
		}else{
			if(M("order_yh")->where(array("id"=>$id))->setField("isdel",$status)!==false){
				$this->success("取消订单成功!",U('Order/hyyhlist'));
			}else{
				$this->error("取消订单失败!");
			}
		}
		
	}
	public function kfdelete(){
		$id = I("get.id");
		$status = I("get.status");
		if($this->order_model->where("id = '".$id."'")->setField('status',$status)!==false){
			$this->success("成功!",U("Order/kflist"));
		}else{
			$this->error("失败!");
		}
	}
	public function cydelete(){
		$id = I("get.id");
		$status = I("get.status");
		if($this->order_cy_model->where("id = '".$id."'")->setField('status',$status)!==false){
			$cy = $this->order_cy_model->where("ejd_order_cy.id = '".$id."'")
			->join("ejd_fans on ejd_fans.id = ejd_order_cy.openid","left")
			->field("ejd_order_cy.*,ejd_fans.nickname")
			->find();
			if($status == 3){
				vendor("wx.WxTemplate");
				$res=\WxTemplate::statusMsg($cy["openid"],"http://diangu.yijiudian.cn/Wechat/Room/cyorderlist?id=".$cy['id']."&ctime=".$cy['ctime'],"您好!".urldecode($cy['nickname']),$cy['id'],"已确认","您预定的餐饮订单确认成功！感谢您的使用");
				\Think\Log::record("消息推送结果：".json_encode($res));
			}else{
				vendor("wx.WxTemplate");
				$res=\WxTemplate::statusMsg($cy["openid"],"http://diangu.yijiudian.cn/Wechat/Room/cyorderlist?id=".$cy['id']."&ctime=".$cy['ctime'],"您好!".urldecode($cy['nickname']),$cy['id'],"已取消","您预定的餐饮订单取消成功！感谢您的使用");
				\Think\Log::record("消息推送结果：".json_encode($res));
			}
			$this->success("成功!",U("Order/cylist"));
		}else{
			$this->error("失败!");
		}
	}
	//菜品明细
	public function detail(){
		$openid = $_GET['openid'];
		$ctime = $_GET['ctime'];
		
		if($openid){
			$data=M("cp_list");
			$count=$data->where(array("ejd_cp_list.openid"=>$openid,"ejd_cp_list.created"=>$ctime))->count();
	        $page = $this->page($count, 15);
	        $dataList=$data
	        ->join('ejd_restaurant_food on ejd_restaurant_food.id = ejd_cp_list.cpid',"left")
	        ->field("ejd_cp_list.*,ejd_restaurant_food.foodname,ejd_restaurant_food.price")
	        ->where(array("ejd_cp_list.openid"=>$openid,"ejd_cp_list.created"=>$ctime))
	        	->limit($page->firstRow . ',' . $page->listRows)
	        	->select();

			$this->assign("dataList", $dataList);
			
			$this->display();
		}else{
			$this->error("数据错误");
		}
	}
	public function ordercy(){
		$id = $_GET['id'];
		if($id){
			$orderCY = $this->order_cy_model->where(array("id"=>$id))->find();
			$this->assign("orderCY",$orderCY);
			$this->display();
		}else{
			$this->error("数据错误");
		}
		
	}
	//客房明细
	public function kfdetail(){
		$openid = $_GET['openid'];
		if($openid){
			$kfdetail = $this->order_model->where(array("id"=>$openid))->find();
			$this->assign("kfdetail",$kfdetail);
			$this->display();
		}else{
			$this->error("数据错误");
		}
	}
	//客房取消订单
	public function kforderdelete(){
		$id = $_GET['id'];
		$status = $_GET['status'];
		if($this->order_model->where("id = '".$id."'")->setField('status',$status)!==false){
			$this->success("取消订单成功!",U("Order/kflist"));
		}else{
			$this->error("取消订单失败!");
		}
		
	}
	//休闲娱乐订单
	public function xyyllist(){
		$this->display();
	}
	public function countorder(){
		$where = "ejd_order.xymcode !=1 and ejd_order.status > 0";
		$keyname = $_GET['keyname'] = $_REQUEST['keyname'];
		if($keyname){
			$this->assign("keyname",$keyname);
			$where .=" and ejd_order.xymcode like '%".$keyname."%' ";
		}
		$count = $this->order_model->where($where)->group("ejd_order.xymcode")->count();
		//每页显示10条
		$page = $this->page($count, 25);
		$xymcode = $this->order_model
		->join("ejd_member on ejd_member.phone = ejd_order.xymcode","left")
		->field("count(ejd_order.xymcode) as countxym,ejd_member.name,ejd_member.phone,ejd_order.xymcode")
		->where($where)
    	->group("ejd_order.xymcode")
    	->limit($page->firstRow . ',' . $page->listRows)
    	->select();
    	$this->assign("page",$page->show("Admin"));
    	$this->assign("xymcode",$xymcode);
		$this->display();
	}
	public function countdetail(){
		$xymcode = I("get.xymcode");
		$this->assign("xymcode",$xymcode);
		$where = "ejd_order.status > 0 and ejd_order.xymcode = '".$xymcode."'";
		$keyname = $_GET['keyname'] = $_REQUEST['keyname'];
		if($keyname){
			$this->assign("keyname",$keyname);
			$where .=" and (ejd_order.id like '%".$keyname."%' or ejd_order.vipphone like '%".$keyname."%')";
		}
		//统计客房订单
		$count = $this->order_model->where($where)->count();
		//每页显示10条
		$page = $this->page($count, 25);
		//查询出客房订单
		$kforderArr = $this->order_model
		->join("ejd_room on ejd_room.id = ejd_order.roomid","left")
		->join("ejd_room_rp on ejd_room_rp.id = ejd_order.rpid","left")
		->field("ejd_room.room_name,ejd_room_rp.rateplanname,ejd_order.id,ejd_order.vipname,ejd_order.vipphone,ejd_order.amount,ejd_order.paycost,ejd_order.created,ejd_order.status,ejd_order.begtime,ejd_order.type")
		->where($where)
    	->order("ejd_order.created desc")
    	->limit($page->firstRow . ',' . $page->listRows)
    	->select();
    	$this->assign("count",$count);
    	$this->assign("page",$page->show("Admin"));
    	$this->assign("kforderArr",$kforderArr);
		$this->display();
	}
}