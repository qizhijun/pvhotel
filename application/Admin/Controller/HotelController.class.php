<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class HotelController extends AdminbaseController{
	
	protected $hotel_model;
	protected  $targets=array("_blank"=>"新标签页打开","_self"=>"本窗口打开");
	
	function _initialize() {
		parent::_initialize();
		$this->hotel_model = M("room");
		$this->roomRP_model = M("room_rp");
		$this->restaurant_model = M("restaurant");
		$this->restaurant_room_model = M("restaurant_room");
		$this->restaurant_food_model = M("restaurant_food");
		$this->room_rp_room_model = M("room_rp_room");
		$this->dict_model = M("dict");
		$this->conferenceroom_model = M("conferenceroom");
		$this->entertainment_model = M("entertainment");
		$this->entertainment_item_model = M("entertainment_item");
		$this->hotel_manager_model = M("hotel_manager");
		$this->area_model = M("area");
		$this->hotel_info_model = M("hotel_info");
		$this->hotel_pic_model = M("pic");
		$this->hotel_circle_model = M("hotel_circle");
		$this->room_role_model = M("room_role");
		$this->room_price_model = M("room_price");
		$this->order_model = M("order");
	}
	//房型管理
	function fxindex(){
		//查询状态
		$where = "iroom_status = 1";
		$iroom_status=$_GET['iroom_status']=$_REQUEST["iroom_status"];
    	if($iroom_status){
    		$this->assign("iroom_status",$iroom_status);
    		$where=" ejd_room.iroom_status=".$iroom_status;
    	}
        //查询总数
        $count=$this->hotel_model->where($where)->count();
		//分页查询
    	$page = $this->page($count, 10);
    	$roomArr = $this->hotel_model
		->where($where)
		->field("id,room_name,sort_index")
    	->order("sort_index DESC")
    	->limit($page->firstRow . ',' . $page->listRows)
    	->select();
    	$this->assign("page",$page->show("Admin"));
    	$this->assign("roomArr",$roomArr);
		$this->display();
	}
	//添加房型
	function fxadd(){ 
		$this->display();
	}
	function fxadd_post(){ 
		if(IS_PSOT){ 
			if($_POST['room_name'] == ''){ 
				$this->error("房型名称不能为空！");
			}
			if(!empty($_POST['photos_alt']) && !empty($_POST['photos_url'])){
				foreach ($_POST['photos_url'] as $key=>$url){
					$photourl=sp_asset_relative_url($url);
					$_POST['pics']['photo'][]=array("url"=>$photourl,"alt"=>$_POST['photos_alt'][$key]);
				}
			}
			$article['pics']=json_encode($_POST['pics']);
			$data = array(
				"room_name" => $_POST['room_name'],
				"sort_index" => $_POST['sort_index'],
				"room_area" => $_POST['room_area'],
				"floor" => $_POST['floor'],
				"category_type" => $_POST['category_type'],
				"bed_size" => $_POST['bed_size'],
				"imax_guestnum" => $_POST['imax_guestnum'],
				"no_smoking" => $_POST['no_smoking'],
				"max_addbed" => $_POST['max_addbed'],
				"pics" => $article['pics'],
				"descp" => $_POST['descp'],
				"facilities1" => json_encode($_POST['facilities1']),
				"iroom_status" => $_POST['iroom_status'],
				"total_number" => $_POST['total_number'],
				"clevel_price0" => $_POST['clevel_price0'],
				"pricetype" => $_POST['pricetype'],
				"levellst" => json_encode($_POST['levellst']),
				"created" => time(),
				"creatuid" => get_current_admin_id()
				);
			$roomArr = $this->hotel_model->add($data);
			if($roomArr){ 
				$this->success("添加成功",U('Hotel/fxindex'));
			}else{ 
				$this->error("添加失败",U('Hotel/fxindex'));
			}
		}
	}
	//修改房型
	function fxedit(){ 
		$id = I("get.id");
		$roomArr = $this->hotel_model->where("id='".$id."'")->find();
		if($roomArr){ 
			$actArr=json_decode($roomArr["facilities1"],true);
				foreach($actArr as $value){
					$actselect[$value]="selected='selected'";
				}
			$this->assign("levellst",json_decode($roomArr['levellst'],true));
			$this->assign("pics",json_decode($roomArr['pics'],true));
			$this->assign("facilities",$actselect);
		}
		$this->assign("roomArr",$roomArr);
		$this->display();
	}
	function fxedit_post(){ 
		if(IS_PSOT){
			if($_POST['room_name'] == ''){ 
				$this->error("房型名称不能为空！");
			}
			if(!empty($_POST['photos_alt']) && !empty($_POST['photos_url'])){
				foreach ($_POST['photos_url'] as $key=>$url){
					$photourl=sp_asset_relative_url($url);
					$_POST['pics']['photo'][]=array("url"=>$photourl,"alt"=>$_POST['photos_alt'][$key]);
				}
			}
			$article['pics']=json_encode($_POST['pics']); 
			$data = array(
				"room_name" => $_POST['room_name'],
				"sort_index" => $_POST['sort_index'],
				"room_area" => $_POST['room_area'],
				"floor" => $_POST['floor'],
				"category_type" => $_POST['category_type'],
				"bed_size" => $_POST['bed_size'],
				"imax_guestnum" => $_POST['imax_guestnum'],
				"no_smoking" => $_POST['no_smoking'],
				"max_addbed" => $_POST['max_addbed'],
				"pics" => $article['pics'],
				"descp" => $_POST['descp'],
				"facilities1" => json_encode($_POST['facilities1']),
				"iroom_status" => $_POST['iroom_status'],
				"total_number" => $_POST['total_number'],
				"clevel_price0" => $_POST['clevel_price0'],
				"pricetype" => $_POST['pricetype'],
				"levellst" => json_encode($_POST['levellst']),
				"updated" => time(),
				"updateuid"=>get_current_admin_id()
			);
			$roomArr = $this->hotel_model->where("id = '".$_POST['id']."'")->save($data);
			if($roomArr){ 
				$this->success("更新成功！",U("Hotel/fxindex"));
			}else{ 
				$this->error("更新失败！",U("Hotel/fxindex"));
			}
		}
	}
	//RP房型显示
	function rpindex(){
		$roomArr = $this->hotel_model->where("iroom_status= 1")->field("id,room_name")->select();
		$this->assign("roomArr",$roomArr);
		$where = " ejd_room_rp.Status = 1";
		$Status=$_GET['Status']=$_REQUEST["Status"];
    	if($Status){
    		$this->assign("Status",$Status);
    		$where=" ejd_room_rp.Status=".$Status;
    	}
    	$roomid=$_GET['roomid']=$_REQUEST["roomid"];
    	if($roomid){
    		$this->assign("roomid",$roomid);
    		$where .=" and ejd_room_rp_room.roomid=".$roomid;
    	}
		$keyname=$_GET['keyname']=$_REQUEST["keyname"];
		if($keyname){
			$this->assign("keyname",$keyname);
			$where.=" and (ejd_room_rp.RatePlanName like '%".$keyname."%')";
		}
		$roomRP = $this->roomRP_model->join("ejd_room_rp_room on ejd_room_rp_room.rpid = ejd_room_rp.id","left")
		->where($where)
		->group("ejd_room_rp.id")
		->field("ejd_room_rp.id,ejd_room_rp.rateplanname,ejd_room_rp.status,ejd_room_rp_room.roomid")
		->select();
		$roomname = $this->room_rp_room_model->join("ejd_room on ejd_room.id = ejd_room_rp_room.roomid","left")->field("ejd_room.room_name,ejd_room_rp_room.rpid")->select();
		$room = $this->hotel_model->field("room_name")->select();
		foreach($room as $v){
			$arr[]=$v["room_name"];
		}
		foreach($roomRP as $k=>$v){
			$nameArr=array();
			foreach($roomname as $r){
				if($v["id"]==$r["rpid"]){ 
					$nameArr[]=$r["room_name"];
				}
			}
			$arr1 = array_diff($arr,$nameArr);
			$roomRP[$k]["room"]=implode(",",$arr1);
			$roomRP[$k]["room_name"]=implode(",",$nameArr);
		}
		$this->assign("roomRP",$roomRP);
		$this->display();
	}
	//添加RP房型
	function rpadd(){ 
		$roomArr = $this->hotel_model->where("iroom_status= 1")->field("id,room_name")->select();
		$this->assign("roomArr",$roomArr);
		$this->display();
	}
	function rpadd_post(){ 
		if(IS_PSOT){ 
			if($_POST["RatePlanName"] == ''){ 
				$this->error("客房产品名称不能为空！");
			}
			$data = array(
				"RatePlanName" => $_POST['RatePlanName'],
				"SortIndex" => $_POST['SortIndex'],
				"StartDate" => strtotime($_POST['StartDate']),
				"Status" => $_POST['Status'],
				"EndDate" => strtotime($_POST['EndDate']),
				"PaymentType" => $_POST['PaymentType'],
				"bfservice" => json_encode($_POST['bfservice']),
				"pricetype" => $_POST['pricetype'],
				"reserveitem" => $_POST['reserveitem'],
				"pricerule" => json_encode($_POST['pricerule'])
				);
			$roomRP = $this->roomRP_model->add($data);
			foreach($_POST['roomid'] as $val){ 
				$roomName[] = array(
					"roomid" => $val,
					"rpid" => $roomRP
				);
			}
			if($roomRP){
				$this->room_rp_room_model->addAll($roomName);
				$this->success("添加成功！",U("Hotel/rpindex"));
			}else{ 
				$this->error("添加失败！",U("Hotel/rpindex"));
			}
		}
	}
	//RP修改页面显示
	function rpedit(){ 
		$id = I("get.id");
		$roomRP = $this->roomRP_model->where("id='".$id."'")->find();
		$room_RP = $this->room_rp_room_model->where("rpid='".$id."'")->select();
		$tmp = array();
		foreach($room_RP as $val){ 
			$tmp[$val["roomid"]] = 1;
		}
		$roomArr = $this->hotel_model->where("iroom_status= 1")->field("id,room_name")->select();
		$startdate = date("Y-m-d",$roomRP['startdate']);
		$enddate = date("Y-m-d",$roomRP['enddate']);
		$bfservice = json_decode($roomRP['bfservice'],true);
		$pricerule = json_decode($roomRP['pricerule'],true);
		$this->assign("pricerule",$pricerule);
		$this->assign("bfservice",$bfservice);
		$this->assign("roomArr",$roomArr);
		$this->assign("startdate",$startdate);
		$this->assign("enddate",$enddate);
		$this->assign("roomRP",$roomRP);
		$this->assign("tmp",$tmp);
		$this->display();
	}
	//RP修改
	function rpedit_post(){ 
		if(IS_PSOT){ 
			$id = $_POST['id'];
			if($_POST["RatePlanName"] == ''){ 
				$this->error("客房产品名称不能为空！");
			}
			$data = array(
				"RatePlanName" => $_POST['RatePlanName'],
				"SortIndex" => $_POST['SortIndex'],
				"StartDate" => strtotime($_POST['StartDate']),
				"Status" => $_POST['Status'],
				"EndDate" => strtotime($_POST['EndDate']),
				"PaymentType" => $_POST['PaymentType'],
				"bfservice" => json_encode($_POST['bfservice']),
				"pricetype" => $_POST['pricetype'],
				"reserveitem" => $_POST['reserveitem'],
				"pricerule" => json_encode($_POST['pricerule'])
				);
			$roomRP = $this->roomRP_model->where(array("id"=>$id))->save($data);
			foreach($_POST['roomid'] as $val){ 
				$roomName[] = array(
					"roomid" => $val,
					"rpid" => $id
				);
			}
			if($roomRP || $roomRP === 0){
				$this->room_rp_room_model->where(array("rpid"=>$id))->delete();
				$this->room_rp_room_model->addAll($roomName);
				$this->success("更新成功！",U("Hotel/rpindex"));
			}else{ 
				$this->error("更新失败！");
			}
		}
	}
	//删除
	function delete(){
		$id = intval(I("get.id"));
		$Status = I("get.Status");
        if ($this->roomRP_model->where("id='" . $id . "'")->setField('Status',$Status)!==false) {
            $this->success("成功！",U("Hotel/rpindex"));
        } else {
            $this->error("失败！". I("get.Status"));
        }
	}


	//餐厅管理
	function ctindex(){ 
		//根据状态查询
		$isdel=$_GET['isdel']=$_REQUEST["isdel"];
    	if($isdel){
    		$this->assign("isdel",$isdel);
    		$where=" ejd_restaurant.isdel=".$isdel;
    	}
    	$count=$this->restaurant_model->where($where)->count();
		//分页查询
    	$page = $this->page($count, 20);
    	$restaurant = $this->restaurant_model
    	->join("ejd_dict on ejd_dict.id = ejd_restaurant.restype","left")
		->where($where)
		->field("ejd_restaurant.id,ejd_restaurant.resname,ejd_restaurant.perperson,ejd_restaurant.isdel,ejd_restaurant.sortindex,ejd_dict.name")
    	->order("sortindex DESC")
    	->limit($page->firstRow . ',' . $page->listRows)
    	->select();
    	$this->assign("page",$page->show("Admin"));
    	$this->assign("restaurant",$restaurant);
		$this->display();
	}
	//添加餐厅
	function ctadd(){ 
		$ctType = $this->dict_model->where(array("type"=>'餐厅类别'))->field("id,name")->select();
		$this->assign("ctType",$ctType);
		$dicArr = $this->dict_model->where(array("type"=>'餐段'))->field("id,name,val")->select();
		$this->assign("dicArr",$dicArr);
		$this->display();
	}
	function ctadd_post(){ 
		if(IS_PSOT){ 
			if($_POST['resname'] == ''){ 
				$this->error("餐厅名称不能为空！");
			}
			if(!empty($_POST['photos_alt']) && !empty($_POST['photos_url'])){
				foreach ($_POST['photos_url'] as $key=>$url){
					$photourl=sp_asset_relative_url($url);
					$_POST['picurl']['photo'][]=array("url"=>$photourl,"alt"=>$_POST['photos_alt'][$key]);
				}
			}
			$array = array(
				"isdel" => $_POST['helptype'],
				"list" => $_POST['isbuffetres']
				);
			$isbuffetres = json_encode($array);
			
			$b = array(
				"level" => $_POST['foods'],
				"foodsend" => $_POST['foodsend'],
				"levellst" => array(
					"ctime" => $_POST['levellst'],
					"ontime" => $_POST['levellsts']
					)
				);
			$foodsend = json_encode($b);
			$article['picurl']=json_encode($_POST['picurl']);
			$data = array(
				"resname" => $_POST['resname'],
				"sortindex" => $_POST['sortindex'],
				"restype" => $_POST['restype'],
				"restel" => $_POST['restel'],
				"resaddress" => $_POST['resaddress'],
				"picurl" => $article['picurl'],
				"businessbeg" => $_POST['businessbeg'],
				"businessend" => $_POST['businessend'],
				"perperson" => $_POST['perperson'],
				"support_pay" => $_POST['support_pay'],
				"support_online" => $_POST['support_online'],
				"issmoking" => $_POST['issmoking'],
				"isbuffetres" => $isbuffetres,
				"foodsend" => $foodsend,
				"peoplenum" => $_POST['peoplenum'],
				"tablenum" => $_POST['tablenum'],
				"tshpanoramaurl" => $_POST['tshpanoramaurl'],
				"des" => $_POST['des'],
				"saledisontime" => $_POST['saledisontime'],
				"scoredisontime" => $_POST['scoredisontime'],
				"cleveldiscount" => $_POST['cleveldiscount'],
				"clevelprice" => $_POST['clevelprice'],
				"isrefund" => $_POST['isrefund'],
				"qhour" => $_POST['qhour'],
				"refund" => $_POST['refund'],
				"created" =>time(),
				"creatuid" => get_current_admin_id()
				);
			$restaurant = $this->restaurant_model->add($data);
			if($restaurant){ 
				$this->success("添加成功！",U("Hotel/ctindex"));
			}else{ 
				$this->error("添加失败！",U("Hotel/ctindex"));
			}
		}
	}
	function ctedit(){ 
		$id = I("get.id");
		$ctType = $this->dict_model->where(array("type"=>'餐厅类别'))->field("id,name")->select();
		$this->assign("ctType",$ctType);
		$dicArr = $this->dict_model->where(array("type"=>'餐段'))->field("id,name,val")->select();
		$this->assign("dicArr",$dicArr);
		$ctArr = $this->restaurant_model->where("id='".$id."'")->find();
		if($ctArr){ 
			$isbuffetres = json_decode($ctArr['isbuffetres']);
			$_arr=get_object_vars($isbuffetres);
			if($_arr['isdel'] == 1){ 
				$tmp = array();
				foreach($_arr['list'] as $val){ 
					$tmp[$val] = $val;
				}
			}
			$foodsend = json_decode($ctArr['foodsend']);
			$foodsend=get_object_vars($foodsend);
			if($foodsend['level'] == 1){
				$foodlst = get_object_vars($foodsend['levellst']);
				$foods = array(); 
				foreach($foodsend['foodsend'] as $val){ 
					$foods[$val] = $val;
				}
			}
			$this->assign("foodlst",$foodlst);
			$this->assign("foods",$foods);
			$this->assign("level",$foodsend['level']);
			$this->assign("tmp",$tmp);
			$this->assign("isdel",$_arr['isdel']);
			$this->assign("picurl",json_decode($ctArr['picurl'],true));
		}
		$this->assign("ctArr",$ctArr);
		$this->display();
	}
	function ctedit_post(){ 
		if(IS_PSOT){ 
			if($_POST['resname'] == ''){ 
				$this->error("餐厅名称不能为空！");
			}
			if(!empty($_POST['photos_alt']) && !empty($_POST['photos_url'])){
				foreach ($_POST['photos_url'] as $key=>$url){
					$photourl=sp_asset_relative_url($url);
					$_POST['picurl']['photo'][]=array("url"=>$photourl,"alt"=>$_POST['photos_alt'][$key]);
				}
			}
			$array = array(
				"isdel" => $_POST['helptype'],
				"list" => $_POST['isbuffetres']
				);
			$isbuffetres = json_encode($array);
			
			$b = array(
				"level" => $_POST['foods'],
				"foodsend" => $_POST['foodsend'],
				"levellst" => array(
					"ctime" => $_POST['levellst'],
					"ontime" => $_POST['levellsts']
					)
				);
			$foodsend = json_encode($b);
			$article['picurl']=json_encode($_POST['picurl']);
			$data = array(
				"resname" => $_POST['resname'],
				"sortindex" => $_POST['sortindex'],
				"restype" => $_POST['restype'],
				"restel" => $_POST['restel'],
				"resaddress" => $_POST['resaddress'],
				"picurl" => $article['picurl'],
				"businessbeg" => $_POST['businessbeg'],
				"businessend" => $_POST['businessend'],
				"perperson" => $_POST['perperson'],
				"support_pay" => $_POST['support_pay'],
				"support_online" => $_POST['support_online'],
				"issmoking" => $_POST['issmoking'],
				"isbuffetres" => $isbuffetres,
				"foodsend" => $foodsend,
				"peoplenum" => $_POST['peoplenum'],
				"tablenum" => $_POST['tablenum'],
				"tshpanoramaurl" => $_POST['tshpanoramaurl'],
				"des" => $_POST['des'],
				"saledisontime" => $_POST['saledisontime'],
				"scoredisontime" => $_POST['scoredisontime'],
				"cleveldiscount" => $_POST['cleveldiscount'],
				"clevelprice" => $_POST['clevelprice'],
				"isrefund" => $_POST['isrefund'],
				"qhour" => $_POST['qhour'],
				"refund" => $_POST['refund'],
				"created" =>time(),
				"creatuid" => get_current_admin_id()
				);
			$restaurant = $this->restaurant_model->where("id='".$_POST['id']."'")->save($data);
			if($restaurant){ 
				$this->success("更新成功！",U("Hotel/ctindex"));
			}else{ 
				$this->error("更新失败！");
			}
		}
	}
	//餐厅删除
	function isdel(){
		$id = intval(I("get.id"));
		$isdel = I("get.isdel");
        if ($this->restaurant_model->where("id='" . $id . "'")->setField('isdel',$isdel)!==false) {
            $this->success("停业成功！",U("Hotel/ctindex"));
        } else {
            $this->error("停业失败！". I("get.isdel"));
        }
	}
	//包间列表
	function bjindex(){
		$resid=$_GET['resid']=$_REQUEST["resid"];
		$where = "id is not null";
    	if($resid){
    		$this->assign("resid",$resid);
    		$where=" ejd_restaurant_room.resid=".$resid;
    	}
    	$keyname = $_GET['keyname'] = $_REQUEST['keyname'];
    	if($keyname){ 
    		$this->assign("keyname",$keyname);
    		$where.= " and ejd_restaurant_room.resroomname like '%".$keyname."%'";
    	}
    	$count=$this->restaurant_room_model->where($where)->count();
		//分页查询
    	$page = $this->page($count, 20);
    	$restaurant_room = $this->restaurant_room_model
		->where($where)
		->field("resroomname,id,maxlimit,resid")
    	->order("id DESC")
    	->limit($page->firstRow . ',' . $page->listRows)
    	->select();
    	$this->assign("page",$page->show("Admin"));
    	$this->assign("restaurant_room",$restaurant_room);
		$restaurant = $this->restaurant_model->where("isdel=-1")->field("id,resname")->select();
		$this->assign("restaurant",$restaurant); 
		$this->display();
	}
	//包间添加
	function bjadd(){
		$restaurantArr = $this->restaurant_model->where("isdel=-1")->field("id,resname")->select(); 
		$dicArr = $this->dict_model->where(array("type"=>'餐段'))->field("id,name,val")->select();
		$this->assign("restaurantArr",$restaurantArr);
		$this->assign("dicArr",$dicArr);
		$this->display();
	}
	function bjadd_post(){ 
		if(IS_PSOT){ 
			if($_POST['resid'] == ''){ 
				$this->error("请选择餐厅");
			}
			if($_POST['resroomname'] == ''){ 
				$this->error("包间名称不能为空");
			}
			$data = array(
				"resid" => $_POST['resid'],
				"resroomname" => $_POST['resroomname'],
				"fminfo" => json_encode($_POST['fminfo']),
				"maxlimit" => $_POST['maxlimit'],
				"earnest" => $_POST['earnest'],
				"resroomurl" => $_POST['resroomurl'],
				"des" => $_POST['des'],
				"created" => time(),
				"creatuid" => get_current_admin_id()
				);
			$restaurant_room = $this->restaurant_room_model->add($data);
			if($restaurant_room){ 
				$this->success("添加成功！");
			}else{ 
				$this->error("添加失败！");
			}
		}
	}
	//修改包间
	function bjedit(){
		$id = I("get.id");
		$bjArr = $this->restaurant_room_model->where("id='".$id."'")->find();
		$restaurantArr = $this->restaurant_model->where("isdel=-1")->field("id,resname")->select(); 
		$dicArr = $this->dict_model->where(array("type"=>'餐段'))->field("id,name,val")->select();
		$fminfo = json_decode($bjArr['fminfo']);
		$ids = array();
		foreach($fminfo as $val){ 
			$ids[$val] = $val;
		}
		$this->assign("fminfo",$ids);
		$this->assign("restaurantArr",$restaurantArr);
		$this->assign("dicArr",$dicArr);
		$this->assign("bjArr",$bjArr); 
		$this->display();
	}
	function bjedit_post(){ 
		if(IS_PSOT){ 
			if($_POST['resid'] == ''){ 
				$this->error("请选择餐厅");
			}
			if($_POST['resroomname'] == ''){ 
				$this->error("包间名称不能为空");
			}
			$data = array(
				"resid" => $_POST['resid'],
				"resroomname" => $_POST['resroomname'],
				"fminfo" => json_encode($_POST['fminfo']),
				"maxlimit" => $_POST['maxlimit'],
				"earnest" => $_POST['earnest'],
				"resroomurl" => $_POST['resroomurl'],
				"des" => $_POST['des'],
				"created" => time(),
				"creatuid" => get_current_admin_id()
				);
			$restaurant_room = $this->restaurant_room_model->where("id='".$_POST['id']."'")->save($data);
			if($restaurant_room){ 
				$this->success("更新成功！");
			}else{ 
				$this->error("更新失败！");
			}
		}
	}
	function bjdelete(){ 
		$id = I("get.id");
		if($this->restaurant_room_model->where("id='".$id."'")->delete()!==false){ 
			$this->success("删除成功！");
		}else{ 
			$this->error("删除失败！");
		}
	}
	//菜品列表
	function cpindex(){
		//选择餐厅
		$resname = $this->restaurant_model->where("isdel = -1")->field("id,resname")->select();
		$this->assign("resname",$resname); 
		//选择菜品分类
		$dicArr = $this->dict_model->where(array("type"=>'菜品类别'))->field("id,name")->select();
		$this->assign("dicArr",$dicArr);
		//条件查询
		$where = "ejd_restaurant_food.isdel = 0";
		$resid=$_GET['resid']=$_REQUEST["resid"];
    	if($resid){
    		$this->assign("resid",$resid);
    		$where.=" and ejd_restaurant_food.resid=".$resid;
    	}
    	$menutype=$_GET['menutype']=$_REQUEST["menutype"];
    	if($menutype){
    		$this->assign("menutype",$menutype);
    		$where.=" and ejd_restaurant_food.menutype=".$menutype;
    	}
    	$count=$this->restaurant_food_model->where($where)->count();
		//分页查询
    	$page = $this->page($count, 20);
    	$restaurant_food = $this->restaurant_food_model
    	->join("ejd_restaurant on ejd_restaurant.id = ejd_restaurant_food.resid","left")
    	->join("ejd_dict on ejd_dict.id = ejd_restaurant_food.menutype","left")
		->where($where)
		->field("ejd_restaurant_food.foodname,ejd_restaurant_food.id,ejd_dict.name,ejd_restaurant.resname,ejd_restaurant_food.maxnum,ejd_restaurant_food.isdel")
    	->order("id ASC")
    	->limit($page->firstRow . ',' . $page->listRows)
    	->select();
    	$this->assign("page",$page->show("Admin"));
    	$this->assign("restaurant_food",$restaurant_food);
		$restaurant = $this->restaurant_model->where("isdel=-1")->field("id,resname")->select();
		$this->assign("restaurant",$restaurant); 
		$this->display();
	}
	//添加菜品
	function cpadd(){ 
		$restaurantArr = $this->restaurant_model->where("isdel=-1")->field("id,resname")->select();
		$this->assign("restaurantArr",$restaurantArr); 
		$dicArr = $this->dict_model->where(array("type"=>'菜品类别'))->field("id,name")->select();
		$this->assign("dicArr",$dicArr);
		$dicArr1 = $this->dict_model->where(array("type"=>'餐段'))->field("id,name,val")->select();
		$this->assign("dicArr1",$dicArr1);
		$this->display();
	}
	function cpadd_post(){ 
		if(IS_PSOT){ 
			if($_POST['resid'] == ''){ 
				$this->error("请选择餐厅");
			}
			if($_POST['menutype'] == ''){ 
				$this->error("请选择菜品分类");
			}
			if($_POST['foodname'] == ''){ 
				$this->error("菜品名称不能为空");
			}
			$data = array(
				"resid" => $_POST['resid'],
				"menutype" => $_POST['menutype'],
				"foodname" => $_POST['foodname'],
				"fminfo" => json_encode($_POST['fminfo']),
				"maxnum" => $_POST['maxnum'],
				"price" => $_POST['price'],
				"picurl" => $_POST['picurl'],
				"des" => $_POST['des'],
				"created" => time(),
				"creatuid" => get_current_admin_id()
				);
			$restaurant_food = $this->restaurant_food_model->add($data);
			if($restaurant_food){ 
				$this->success("添加成功！");
			}else{ 
				$this->error("添加失败！");
			}
		}
	}
	//修改菜品
	function cpedit(){ 
		$id = I("get.id");
		$foodArr = $this->restaurant_food_model->where("id='".$id."'")->find();
		$fminfo = json_decode($foodArr['fminfo']);
		$tmp = array();
		foreach($fminfo as $val){ 
			$tmp[$val] = $val;
		}
		$this->assign("fminfo",$tmp);
		$restaurantArr = $this->restaurant_model->where("isdel=-1")->field("id,resname")->select();
		$this->assign("restaurantArr",$restaurantArr); 
		$dicArr = $this->dict_model->where(array("type"=>'菜品类别'))->field("id,name")->select();
		$this->assign("dicArr",$dicArr);
		$dicArr1 = $this->dict_model->where(array("type"=>'餐段'))->field("id,name,val")->select();
		$this->assign("dicArr1",$dicArr1);
		$this->assign("foodArr",$foodArr);
		$this->display();
	}
	function cpedit_post(){ 
		if(IS_PSOT){ 
			if($_POST['resid'] == ''){ 
				$this->error("请选择餐厅");
			}
			if($_POST['menutype'] == ''){ 
				$this->error("请选择菜品分类");
			}
			if($_POST['foodname'] == ''){ 
				$this->error("菜品名称不能为空");
			}
			$data = array(
				"resid" => $_POST['resid'],
				"menutype" => $_POST['menutype'],
				"foodname" => $_POST['foodname'],
				"fminfo" => json_encode($_POST['fminfo']),
				"maxnum" => $_POST['maxnum'],
				"price" => $_POST['price'],
				"picurl" => $_POST['picurl'],
				"des" => $_POST['des'],
				"created" => time(),
				"creatuid" => get_current_admin_id()
				);
			$restaurant_food = $this->restaurant_food_model->where("id='".$_POST['id']."'")->save($data);
			if($restaurant_food){ 
				$this->success("更新成功！");
			}else{ 
				$this->error("更新失败！");
			}
		}
	}
	//菜品删除
	function cpdelete(){
		$id = intval(I("get.id"));
		$isdel = I("get.isdel");
        if ($this->restaurant_food_model->where("id='" . $id . "'")->setField('isdel',$isdel)!==false) {
            $this->success("删除成功！",U("Hotel/cpindex"));
        } else {
            $this->error("删除失败！". I("get.isdel"));
        }
	}

	//宴会展示
	function hyyhindex(){ 
		$where = "isdel = 0";
		$keyname = $_GET['keyname'] = $_REQUEST['keyname'];
		if($keyname){
			$this->assign("keyname",$keyname);
			$where.=" and (ejd_conferenceroom.crname like '%".$keyname."%')";
		}
		//查询总数
        $count=$this->conferenceroom_model->where($where)->count();
		//分页查询
    	$page = $this->page($count, 20);
    	$conferenceroom = $this->conferenceroom_model
		->where($where)
		->field("id,crname,sortindex,status")
    	->order("sortindex DESC")
    	->limit($page->firstRow . ',' . $page->listRows)
    	->select();
    	$this->assign("page",$page->show("Admin"));
    	$this->assign("conferenceroom",$conferenceroom);
		$this->display();
	}
	//添加宴会厅页面展示
	function hyyhadd(){ 
		$jypersonnum = $this->dict_model->where(array("type"=>"宴会厅类型"))->field("id,name")->select();
		$this->assign("jypersonnum",$jypersonnum);
		$this->display();
	}
	function hyyhadd_post(){ 
		if(IS_PSOT){ 
			if($_POST['crname'] == ""){ 
				$this->error("宴会厅名称不能为空");
			}
			$data = array(
				"crname" => $_POST['crname'],
				"tips" => $_POST['tips'],
				"sortindex" => $_POST['sortindex'],
				"usetype" => $_POST['usetype'],
				"suppretype" => $_POST['suppretype'],
				"phone" => $_POST['phone'],
				"crprice" => $_POST['crprice'],
				"jypersonnum" => json_encode($_POST['jypersonnum']),
				"clong" => $_POST['clong'],
				"cwide" => $_POST['cwide'],
				"chight" => $_POST['chight'],
				"picurl" => $_POST['picurl'],
				"des" => $_POST['des'],
				"created" => time(),
				"creatuid" => get_current_admin_id()
			);
			$conferenceroom = $this->conferenceroom_model->add($data);
			if($conferenceroom){ 
				$this->success("添加成功！",U("Hotel/hyyaindex"));
			}else{ 
				$this->error("添加失败！");
			}
		}
	}
	//编辑宴会厅
	function hyyhedit(){
		$id = I("get.id");
		$jypersonnum = $this->dict_model->where(array("type"=>"宴会厅类型"))->field("id,name")->select();
		$this->assign("jypersonnum",$jypersonnum);
		$conferenceroom = $this->conferenceroom_model->where("id='".$id."'")->find();
		$num = json_decode($conferenceroom['jypersonnum']);
		$arr = get_object_vars($num);
		$this->assign("num",$arr);
		$this->assign("conferenceroom",$conferenceroom); 
		$this->display();
	}
	//预约控制
	function hyyhstatus(){ 
		$id = I("get.id");
		$status = I("get.status");
		if ($this->conferenceroom_model->where("id='" . $id . "'")->setField('status',$status)!==false) {
            $this->success("设置成功！",U("Hotel/hyyhindex"));
        } else {
            $this->error("设置失败！");
        }
	}
	function hyyhedit_post(){ 
		if(IS_PSOT){ 
			if($_POST['crname'] == ""){ 
				$this->error("宴会厅名称不能为空");
			}
			$data = array(
				"crname" => $_POST['crname'],
				"tips" => $_POST['tips'],
				"sortindex" => $_POST['sortindex'],
				"usetype" => $_POST['usetype'],
				"suppretype" => $_POST['suppretype'],
				"phone" => $_POST['phone'],
				"crprice" => $_POST['crprice'],
				"jypersonnum" => json_encode($_POST['jypersonnum']),
				"clong" => $_POST['clong'],
				"cwide" => $_POST['cwide'],
				"chight" => $_POST['chight'],
				"picurl" => $_POST['picurl'],
				"des" => $_POST['des'],
				"created" => time(),
				"creatuid" => get_current_admin_id()
			);
			$conferenceroom = $this->conferenceroom_model->where("id='".$_POST['id']."'")->save($data);
			if($conferenceroom){ 
				$this->success("更新成功！",U("Hotel/hyyaindex"));
			}else{ 
				$this->error("更新失败！");
			}
		}
	}
	//宴会厅删除
	function hyyhdelete(){ 
		$id = I("get.id");
		$isdel = I("get.isdel");
		if ($this->conferenceroom_model->where("id='" . $id . "'")->setField('isdel',$isdel)!==false) {
            $this->success("成功！",U("Hotel/hyyhindex"));
        } else {
            $this->error("失败！");
        }
	}
	//休闲娱乐展示
	function xyylindex(){
		$xyylArr = $this->entertainment_model->where("isdel=0")->field("id,ename,isdel,issuppre")->select();
		$this->assign("xyylArr",$xyylArr); 
		$this->display();
	} 
	//添加休闲娱乐
	function xyyladd(){ 
		$xyylArr = $this->dict_model->where(array("type"=>"娱乐类别"))->field("id,name")->select();
		$this->assign("xyylArr",$xyylArr);
		$this->display();
	}
	function xyyladd_post(){ 
		if(IS_PSOT){ 
			if($_POST['ename'] == ""){ 
				$this->error("娱乐名称不能为空！");
			}
			if(!empty($_POST['photos_alt']) && !empty($_POST['photos_url'])){
				foreach ($_POST['photos_url'] as $key=>$url){
					$photourl=sp_asset_relative_url($url);
					$_POST['picurls']['photo'][]=array("url"=>$photourl,"alt"=>$_POST['photos_alt'][$key]);
				}
			}
			$data = array(
				"ename" => $_POST['ename'],
				"sortindex" => $_POST['sortindex'],
				"etypeid" => $_POST['etypeid'],
				"entel" => $_POST['entel'],
				"enaddress" => $_POST['enaddress'],
				"picurls" => json_encode($_POST['picurls']),
				"begtime" => $_POST['begtime'],
				"endtime" => $_POST['endtime'],
				"perperson" => $_POST['perperson'],
				"suppretype" => $_POST['suppretype'],
				"issmoking" => $_POST['issmoking'],
				"tshpanoramaurl" => $_POST['tshpanoramaurl'],
				"des" => $_POST['des'],
				"saledisontime" => $_POST['saledisontime'],
				"scoredisontime" => $_POST['scoredisontime'],
				"clevelprice" => $_POST['clevelprice'],
				"leveldiscount" => $_POST['leveldiscount'],
				"isrefund" => $_POST['isrefund'],
				"beforehour" => $_POST['beforehour'],
				"refundper" => $_POST['refundper'],
				"created" => time(),
				"creatuid" => get_current_admin_id()
			);
			$entertainment = $this->entertainment_model->add($data);
			if($entertainment){ 
				$this->success("添加成功！",U("Hotel/xyylindex"));
			}else{ 
				$this->error("添加失败！");
			}
		}
	}
	//修改休闲娱乐
	function xyyledit(){
		$id = I("get.id");
		$etypeid = $this->dict_model->where(array("type"=>"娱乐类别"))->field("id,name")->select();
		$xyylArr = $this->entertainment_model->where("id='".$id."'")->find();
		$this->assign("picurl",json_decode($xyylArr['picurls'],true));
		$this->assign("etypeid",$etypeid);
		$this->assign("xyylArr",$xyylArr); 
		$this->display();
	}
	function xyyledit_post(){ 
		if(IS_PSOT){ 
			if($_POST['ename'] == ""){ 
				$this->error("娱乐名称不能为空！");
			}
			if(!empty($_POST['photos_alt']) && !empty($_POST['photos_url'])){
				foreach ($_POST['photos_url'] as $key=>$url){
					$photourl=sp_asset_relative_url($url);
					$_POST['picurls']['photo'][]=array("url"=>$photourl,"alt"=>$_POST['photos_alt'][$key]);
				}
			}
			$data = array(
				"ename" => $_POST['ename'],
				"sortindex" => $_POST['sortindex'],
				"etypeid" => $_POST['etypeid'],
				"entel" => $_POST['entel'],
				"enaddress" => $_POST['enaddress'],
				"picurls" => json_encode($_POST['picurls']),
				"begtime" => $_POST['begtime'],
				"endtime" => $_POST['endtime'],
				"perperson" => $_POST['perperson'],
				"suppretype" => $_POST['suppretype'],
				"issmoking" => $_POST['issmoking'],
				"tshpanoramaurl" => $_POST['tshpanoramaurl'],
				"des" => $_POST['des'],
				"saledisontime" => $_POST['saledisontime'],
				"scoredisontime" => $_POST['scoredisontime'],
				"clevelprice" => $_POST['clevelprice'],
				"leveldiscount" => $_POST['leveldiscount'],
				"isrefund" => $_POST['isrefund'],
				"beforehour" => $_POST['beforehour'],
				"refundper" => $_POST['refundper'],
				"created" => time(),
				"creatuid" => get_current_admin_id()
			);
			$entertainment = $this->entertainment_model->where("id='".$_POST['id']."'")->save($data);
			if($entertainment){ 
				$this->success("更新成功！",U("Hotel/xyylindex"));
			}else{ 
				$this->error("更新失败！");
			}
		}
	}
	//休闲娱乐删除
	function xyyldelete(){ 
		$id = I("get.id");
		$isdel = I("get.isdel");
		if ($this->entertainment_model->where("id='" . $id . "'")->setField('isdel',$isdel)!==false) {
            $this->success("成功！",U("Hotel/xyylindex"));
        } else {
            $this->error("失败！");
        }
	}
	//休闲娱乐预定控制
	function xyylissupper(){ 
		$id = I("get.id");
		$issuppre = I("get.issuppre");
		if ($this->entertainment_model->where("id='" . $id . "'")->setField('issuppre',$issuppre)!==false) {
            $this->success("设置成功！",U("Hotel/xyylindex"));
        } else {
            $this->error("设置失败！");
        }
	}
	//展示娱乐项目
	function ylxmindex(){ 
		$ename = $this->entertainment_model->where("isdel = 0")->field("id,ename")->select();
		$this->assign("ename",$ename);
		$where = "ejd_entertainment_item.isdel = 0";
		$eid = $_GET['eid'] = $_REQUEST['eid'];
		if($eid){ 
			$this->assign("eid",$eid);
			$where.= " and ejd_entertainment_item.eid = " . $eid;
		}
		$count = $this->entertainment_item_model->where($where)->count();
		$page = $this->page($count,20);
		$entertainment_item = $this->entertainment_item_model
		->join("ejd_entertainment on ejd_entertainment.id = ejd_entertainment_item.eid","left")
		->where($where)
		->order("id desc")
		->field("ejd_entertainment.ename,ejd_entertainment_item.itemname,ejd_entertainment_item.id,ejd_entertainment_item.isdel")
		->limit($page->firstRow . ',' . $page->listRows)
		->select();
		$this->assign("entertainment_item",$entertainment_item);
		$this->display();
	}

	//添加娱乐项目
	function ylxmadd(){ 
		$ename = $this->entertainment_model->where("isdel = 0")->select();
		$this->assign("ename",$ename);
		$this->display();
	}
	function ylxmadd_post(){ 
		if(IS_PSOT){ 
			if($_POST['itemname'] == ""){ 
				$this->error("娱乐项目名称不能为空！");
			}
			$data = array(
				"eid" => $_POST['eid'],
				"itemname" => $_POST['itemname'],
				"price" => $_POST['price'],
				"picurl" => $_POST['picurl'],
				"des" => $_POST['des'],
				"created" => time(),
				"creatuid" => get_current_admin_id()
			);
			$ylxmArr = $this->entertainment_item_model->add($data);
			if($ylxmArr){ 
				$this->success("添加成功！",U("Hotel/ylxmindex"));
			}else{ 
				$this->error("添加失败！");
			}
		}
	}
	//修改娱乐项目
	function ylxmedit(){ 
		$id = I("get.id");
		$ename = $this->entertainment_model->where("isdel = 0")->select();
		$this->assign("ename",$ename);
		$ylxmArr = $this->entertainment_item_model->where("id='".$id."'")->find();
		$this->assign("ylxmArr",$ylxmArr);
		$this->display();
	}
	function ylxmedit_post(){ 
		if(IS_PSOT){ 
			if($_POST['itemname'] == ""){ 
				$this->error("娱乐项目名称不能为空！");
			}
			$data = array(
				"eid" => $_POST['eid'],
				"itemname" => $_POST['itemname'],
				"price" => $_POST['price'],
				"picurl" => $_POST['picurl'],
				"des" => $_POST['des'],
				"created" => time(),
				"creatuid" => get_current_admin_id()
			);
			$ylxmArr = $this->entertainment_item_model->where("id='".$_POST['id']."'")->save($data);
			if($ylxmArr){ 
				$this->success("更新成功！",U("Hotel/ylxmindex"));
			}else{ 
				$this->error("更新失败！");
			}
		}
	}
	function ylxmdelete(){ 
		$id = I("get.id");
		$isdel = I("get.isdel");
		if($this->entertainment_item_model->where("id='" . $id . "'")->setField('isdel',$isdel)!==false){ 
			$this->success("删除成功！",U("Hotel/ylxmindex"));
		}else{ 
			$this->error("删除失败！");
		}
	}
	//总经理推荐
	function recommend(){ 
		$recommendArr = $this->hotel_manager_model->find();
		$this->assign("recommendArr",$recommendArr);
		$this->display();
	}
	function recommend_post(){ 
		if(IS_PSOT){
			if($_POST['manager_name']==""){ 
				$this->error("总经理名称不能为空！");
			}
			$data = array(
				"manager_name" => $_POST['manager_name'],
				"head_img" => $_POST['head_img'],
				"title" => $_POST['title'],
				"reason" => $_POST['reason'],
				"recommend" => $_POST['recommend'],
				"vipdes" => $_POST['vipdes'],
				"updated" => time(),
				"updateuid" => get_current_admin_id()
			);
			$id = $this->hotel_manager_model->find();
			if($id){ 
				$hotel_manager = $this->hotel_manager_model->where("id = '".$id['id']."'")->save($data);
				if($hotel_manager){ 
					$this->success("更新成功！",U("Hotel/recommend"));
				}else{ 
					$this->error("更新失败！");
				}
			}else{ 
				$hotel_manager = $this->hotel_manager_model->add($data);
				if($hotel_manager){ 
					$this->success("添加成功！",U("Hotel/recommend"));
				}else{ 
					$this->error("添加失败！");
				}
			}
			
		}
	}
	//酒店信息
	function info(){
	//查询酒店类型 
		$hotelType = $this->dict_model->where(array("type"=>"酒店类型"))->field("id,name")->select();
		$this->assign("hotelType",$hotelType);
	//查询酒店星级
		$hotelStar = $this->dict_model->where(array("type"=>"酒店星级"))->field("id,name")->select();
		$this->assign("hotelStar",$hotelStar);
	//查询省份
		$province = $this->area_model->where("id_parent = -1 and provice_id = id")->select();
		$this->assign("province",$province);
	//查询城市
		$city = $this->area_model->where("city_id = id")->select();
		$this->assign("city",$city);
	//查询区县
		$area = $this->area_model->where("id_parent = city_id")->select();
		$this->assign("area",$area);
		$hotel_info = $this->hotel_info_model->find();
		$contactArr = M("hotel_contact")->where("hotelid = '".$hotel_info['id']."'")->select();
	//设备
		if($hotel_info){ 
			$actArr=json_decode($hotel_info["facilities"],true);
			foreach($actArr as $value){
				$actselect[$value]="selected='selected'";
			}
			$this->assign("facilities",$actselect);
			$this->assign("hotel_open_time",date("Y-m-d",$hotel_info['hotel_open_time']));
			$this->assign("lastdecoratedate",date("Y-m-d",$hotel_info['lastdecoratedate']));
		}
		$this->assign("hotel_info",$hotel_info);
		$this->assign("contactArr",$contactArr);
		$this->display();
	}
	function info_post(){ 
		if(IS_POST){ 
			if($_POST['hotel_name'] == '' || $_POST['hotel_tel'] == ''){ 
				$this->error("酒店名称和电话号码不能为空！");
			}
			$data = array(
				"hotel_name" => $_POST['hotel_name'],
				"sortindex" => $_POST['sortindex'],
				"hotel_type" => $_POST['hotel_type'],
				"hotel_star" => $_POST['hotel_star'],
				"hotel_tel" => $_POST['hotel_tel'],
				"hotel_fax" => $_POST['hotel_fax'],
				"hotel_site" => $_POST['hotel_site'],
				"tshpanorama_url" => $_POST['tshpanorama_url'],
				"hotel_open_time" => strtotime($_POST['hotel_open_time']),
				"lastdecoratedate" => strtotime($_POST['lastdecoratedate']),
				"facilities" => json_encode($_POST['facilities']),
				"room_count" => $_POST['room_count'],
				"maxdays" => $_POST['maxdays'],
				"liutime" => $_POST['liutime'],
				"earlieintime" =>$_POST['earlieintime'],
				"lastouttime" => $_POST['lastouttime'],
				"hotel_close" => $_POST['hotel_close'],
				"province" => $_POST['province'],
				"city" => $_POST['city'],
				"area" => $_POST['area'],
				"zipcode" => $_POST['zipcode'],
				"hotel_address" => $_POST['hotel_address'],
				"lng" => $_POST['lng'],
				"lat" => $_POST['lat'],
				"gps_address" => $_POST['gps_address'],
				"logourl" => $_POST['logourl'],
				"headpic" => $_POST['headpic'],
				"des" => $_POST['des'],
				"address" => $_POST['address'],
				"created" => time(),
				"order_tel" => $_POST['order_tel'],
				"creatuid" => get_current_admin_id()
			);
			$data2 = array(
				"hotel_name" => $_POST['hotel_name'],
				"sortindex" => $_POST['sortindex'],
				"hotel_type" => $_POST['hotel_type'],
				"hotel_star" => $_POST['hotel_star'],
				"hotel_tel" => $_POST['hotel_tel'],
				"hotel_fax" => $_POST['hotel_fax'],
				"hotel_site" => $_POST['hotel_site'],
				"tshpanorama_url" => $_POST['tshpanorama_url'],
				"hotel_open_time" => strtotime($_POST['hotel_open_time']),
				"lastdecoratedate" => strtotime($_POST['lastdecoratedate']),
				"facilities" => json_encode($_POST['facilities']),
				"room_count" => $_POST['room_count'],
				"maxdays" => $_POST['maxdays'],
				"liutime" => $_POST['liutime'],
				"earlieintime" =>$_POST['earlieintime'],
				"lastouttime" => $_POST['lastouttime'],
				"hotel_close" => $_POST['hotel_close'],
				"province" => $_POST['province'],
				"city" => $_POST['city'],
				"area" => $_POST['area'],
				"zipcode" => $_POST['zipcode'],
				"hotel_address" => $_POST['hotel_address'],
				"lng" => $_POST['lng'],
				"lat" => $_POST['lat'],
				"gps_address" => $_POST['gps_address'],
				"logourl" => $_POST['logourl'],
				"headpic" => $_POST['headpic'],
				"des" => $_POST['des'],
				"address" => $_POST['address'],
				"updated" => time(),
				"order_tel" => $_POST['order_tel'],
				"updateuid" => get_current_admin_id()
			);
			$hotel_info = $this->hotel_info_model->find();
			if($hotel_info){ 
				$this->hotel_info_model->startTrans();
				$infoArr = $this->hotel_info_model->where("id = '".$hotel_info['id']."'")->save($data2);
				$data3 = array(
					"name" => $_POST['name1'],
					"phone" => $_POST['phone1'],
					"mail" => $_POST['mail1'],
					"created" => time(),
					"creatuid" => get_current_admin_id()
				);
				$data4 = array(
					"name" => $_POST['name2'],
					"phone" => $_POST['phone2'],
					"mail" => $_POST['mail2'],
					"created" => time(),
					"creatuid" => get_current_admin_id()
				);
				$id4 = M("hotel_contact")->where("id = '".$_POST['id1']."'")->save($data3);
				$id3 = M("hotel_contact")->where("id = '".$_POST['id2']."'")->save($data4);
				if($infoArr || $id4 || $id3){
					$this->hotel_info_model->commit(); 
					$this->success("更新成功！",U("Hotel/info"));
				}else{ 
					$this->hotel_info_model->rollback();
					$this->error("更新失败！");
				}
			}else{ 
				$this->hotel_info_model->startTrans();
				$info = $this->hotel_info_model->add($data);
				$data1 = array(
					"hotelid" => $info,
					"name" => $_POST['name1'],
					"phone" => $_POST['phone1'],
					"mail" => $_POST['mail1'],
					"created" => time(),
					"creatuid" => get_current_admin_id()
				);
				$data2 = array(
					"hotelid" => $info,
					"name" => $_POST['name2'],
					"phone" => $_POST['phone2'],
					"mail" => $_POST['mail2'],
					"created" => time(),
					"creatuid" => get_current_admin_id()
				);
				$hotel_contact = M("hotel_contact")->add($data1);
				$hotel_contact1 = M("hotel_contact")->add($data2);
				if($info || $hotel_contact || $hotel_contact1){ 
					$this->hotel_info_model->commit();
					$this->success("添加成功！",U("Hotel/info"));
				}else{ 
					$this->hotel_info_model->rollback();
					$this->error("添加失败！");
				}
			}
		}
	}
	function cityListAjax(){
		if (IS_POST) {
			$id = $_POST['id'];
			$nextListName = $_POST['nextListName'];
			if($nextListName == "city"){
				$lists=$this->area_model->where("provice_id = '" . $id . "' and city_id = id")->field("id, name")->select();
			}else if($nextListName == "area"){
				$lists=$this->area_model->where("city_id = '" . $id . "' and id_parent = '" . $id . "'")->field("id, name")->select();
			}else if($nextListName == "district"){ 
				$lists=$this->area_model->where("id_parent='".$id."'")->field("id,name")->select();
			}
			if ($lists) {
				$resarr = array(
					"code" => 0, 
					"list" => $lists
				);
			} else {
				$resarr = array(
					"code" => -1, 
					"list" => ""
				);
			}
		}
		exit(json_encode($resarr));
	}
	function photo(){ 
		$picArr = $this->hotel_pic_model->join("ejd_dict on ejd_dict.id = ejd_pic.aid","left")->where("ejd_pic.isdel = 0")->field("ejd_dict.name,ejd_pic.id,ejd_pic.picurl")->select();
		$this->assign("picArr",$picArr);
		$this->display();
	}
	function photoadd(){ 
		$id = I("get.id");
		$this->assign('id',$id);
		$this->display();
	}
	function photoedit(){ 
		$ids = I("get.ids");
		$picArr = $this->hotel_pic_model->where("id='".$ids."'")->find();
		$this->assign("pics",json_decode($picArr['picurl'],true));
		$this->assign("picArr",$picArr);
		$this->display();
	}
	function photoindex(){ 
		$picType = $this->dict_model->where(array("type" => "相册分类"))->select();
		$this->assign("picType",$picType);
		$this->display();
	}
	function phototype(){ 
		$id = I("get.id");
		$phototype = $this->dict_model->where("id = '".$id."'")->find();
		$this->assign("phototype",$phototype);
		$this->display();
	}
	//分类修改添加
	function photo_post(){ 
		if(IS_POST){ 
			if($_POST['name'] == ''){ 
				$this->error("相册分类不能为空！");
			}
			$data = array(
				"name" => $_POST['name'],
				"type" => "相册分类"
				);
			if($_POST['id']){ 
				$picRes = $this->dict_model->where("id = '".$_POST['id']."'")->save($data);
				if($picRes){ 
					$this->success("更新成功！",U("Hotel/photoindex"));
				}else{ 
					$this->error("更新失败！");
				}
			}else{ 
				$picType = $this->dict_model->add($data);
				if($picType){ 
					$this->success("添加成功！",U("Hotel/photoindex"));
				}else{ 
					$this->error("添加失败！");
				}
			}
		}
	}
	//图片添加
	function photoadd_post(){
		$id = I('post.id');
		if(IS_POST){ 
			if(!empty($_POST['photos_alt']) && !empty($_POST['photos_url'])){
				foreach ($_POST['photos_url'] as $key=>$url){
					$photourl=sp_asset_relative_url($url);
					$_POST['picurl']['photo'][]=array("url"=>$photourl,"alt"=>$_POST['photos_alt'][$key]);
				}
			}
			$picurl = json_encode($_POST['picurl']);
			$data = array( 
				"aid" => $id,
				"picurl" => $picurl,
				"created" => time(),
				"creatuid" => get_current_admin_id()
			);
			$picArr = $this->hotel_pic_model->add($data);
			if($picArr){ 
				$this->success("添加成功！",U("Hotel/photo"));
			}else{ 
				$this->error("添加失败！");
			}
		}
	}
	//图片修改
	function photoedit_post(){
		if(IS_POST){ 
			if(!empty($_POST['photos_alt']) && !empty($_POST['photos_url'])){
				foreach ($_POST['photos_url'] as $key=>$url){
					$photourl=sp_asset_relative_url($url);
					$_POST['picurl']['photo'][]=array("url"=>$photourl,"alt"=>$_POST['photos_alt'][$key]);
				}
			}
			$picurl = json_encode($_POST['picurl']);
			$data = array( 
				"picurl" => $picurl,
				"created" => time(),
				"creatuid" => get_current_admin_id()
			);
			$picArr = $this->hotel_pic_model->where("id = '".$_POST['id']."'")->save($data);
			if($picArr){ 
				$this->success("更新成功！",U("Hotel/photo"));
			}else{ 
				$this->error("更新失败！");
			}
		}
	}
	//分类删除
	function photodelete(){ 
		$id = I("get.id");
		if($this->dict_model->where("id = '".$id."'")->delete() !== false){ 
			$this->success("删除成功！",U("Hotel/photoindex"));
		}else{ 
			$this->error("删除失败！");
		}
	}
	//图片删除
	function picdelete(){ 
		$id = I("get.id");
		$isdel = I("get.isdel");
		if($this->hotel_pic_model->where("id='" . $id . "'")->setField('isdel',$isdel)!==false){ 
			$this->success("删除成功！",U("Hotel/photo"));
		}else{ 
			$this->error("删除失败！");
		}
	}
	//周边指南
	function nearinfo(){ 
		$where = "ejd_hotel_circle.isdel = 0";
		$count=$this->hotel_circle_model->where($where)->count();
		//分页查询
    	$page = $this->page($count, 20);
    	$circleArr = $this->hotel_circle_model->join("ejd_dict on ejd_dict.id = ejd_hotel_circle.CircleType")
		->where($where)
		->field("ejd_hotel_circle.id,ejd_hotel_circle.circle_name,ejd_dict.name")
    	->order("ejd_hotel_circle.sortindex DESC")
    	->limit($page->firstRow . ',' . $page->listRows)
    	->select();
    	$this->assign("page",$page->show("Admin"));
    	$this->assign("circleArr",$circleArr);
		$this->display();
	}
	//添加商圈
	function nearadd(){
		$nearArr = $this->dict_model->where(array("type"=>"商圈类型"))->field("id,name")->select();
		$this->assign("nearArr",$nearArr); 
		$id = I("get.id");
		$circleArr = $this->hotel_circle_model->where("id='".$id."'")->find();
		$this->assign("circleArr",$circleArr);
		$this->display();
	}
	function nearadd_post(){ 
		if(IS_POST){ 
			if($_POST['circle_name'] == ""){ 
				$this->error("商圈名称不能为空！");
			}
			//要添加的数据
			$data = array(
				"circle_name" => $_POST['circle_name'],
				"sortindex" => $_POST['sortindex'],
				"CircleType" => $_POST['CircleType'],
				"address" => $_POST['address'],
				"lng" => $_POST['lng'],
				"lat" => $_POST['lat'],
				"created" => time(),
				"creatuid" => get_current_admin_id()
			);
			//判断商圈id是否存在
			if($_POST['id']){
				//执行更新商圈 
				$circleArr = $this->hotel_circle_model->where("id = '".$_POST['id']."'")->save($data);
				if($circleArr){ 
					$this->success("更新成功",U("Hotel/nearinfo"));
				}else{ 
					$this->error("更新失败！");
				}
			}else{
				//执行商圈添加
				$circle = $this->hotel_circle_model->add($data);
				if($circle){ 
					$this->success("添加成功！",U("Hotel/nearinfo"));
				}else{ 
					$this->error("添加失败！");
				}
			}
		}
	}
	//商圈删除操作
	function infodelete(){ 
		$id = I("get.id");
		$isdel = I("get.isdel");
		if($this->hotel_circle_model->where("id='" . $id . "'")->setField('isdel',$isdel)!==false){ 
			$this->success("删除成功！",U("Hotel/nearinfo"));
		}else{ 
			$this->error("删除失败！");
		}
	}
	//房价展示页
	function fjindex(){
		//查询出房型的所有名称
		$roomid = $this->hotel_model->where("iroom_status = 1")->field("room_name,id")->select();
		$this->assign("roomid",$roomid);
		//where房型状态等于1
		$where = "ejd_room.iroom_status = 1";
		//精确查询房型
		$priceroomid = $_GET["priceroomid"] = $_REQUEST["priceroomid"];
		if($priceroomid){ 
			$this->assign("priceroomid",$priceroomid);
			$where .= " and ejd_room.id=".$priceroomid;
		}
		$roomArr = $this->hotel_model->where($where)->field("ejd_room.room_name,ejd_room.id,ejd_room.clevel_price0,ejd_room.total_number")->select();
		//var_dump($roomArr);
		//前十天  后十天
		$time8 = I("get.time");
		$time = str_replace("-","/",$time8);
		for($i=0;$i<=10;$i++){ 
			$newdate[] = date("m/d",strtotime($time . "+" . $i . "day"));
		}
		//这个是把十天的日期转换成时间戳
		foreach($newdate as $v){ 
			$newTime[] = strtotime($v);
		}
		
		//查询特殊表里价格的数据
		$priceArr = $this->room_price_model->where("type=1 and ctime >= '".strtotime($time)."'")->select();
		//给特殊日期附上价格
		foreach($priceArr as $p){ 
			$pArr[$p["hotel_id"]][$p['ctime']] = $p['price'];
		}

		//\Think\Log::record("特殊价格：".json_encode($pArr));
		//\Think\Log::record("当前十天：".json_encode($newTime));
		//\Think\Log::record("所有房型：".json_encode($roomArr));
		//特殊价格显示到十天之内对应的日期下
		foreach($roomArr as $r){ 
			foreach($newTime as $t){ 
				$a[$r['id']][$t] = $r['clevel_price0'];
				if($pArr[$r['id']][$t]){
					$a[$r['id']][$t] = $pArr[$r['id']][$t];
				}
			}
		}
		//查询特殊房量
		$numArr = $this->room_price_model->where("type=2 and ctime >= '".strtotime($time)."'")->select();
		//给特殊日期附上特殊房量
		foreach($numArr as $n){ 
			$nArr[$n['hotel_id']][$n['ctime']] = $n['room_num'];
		}
		//把特殊房量显示到特殊的日期下
		foreach($roomArr as $m){ 
			foreach($newTime as $n){ 
				$b[$m['id']][$n] = $m['total_number'];
				if($nArr[$m['id']][$n] === '0' || $nArr[$m['id']][$n]){ 
					$b[$m['id']][$n] = $nArr[$m['id']][$n];
				}
			}
		}
		//查询出支付后客房订单
		$orderArr = M("order")
		->where("(begtime <= '".strtotime($time)."' and endtime >= '".strtotime($time)."') or (begtime > '".strtotime($time)."' and begtime <= '".$newTime[10]."')")
		->where("status > 0")
		->field("roomid,begtime,endtime,room_number,status")
		->select();
		//var_dump($orderArr);
		foreach($orderArr as $o){
			for($i=0;$i<($o['endtime'] - $o['begtime'])/86400;$i++){ 
				$riqi=strtotime(date("Y-m-d",$o['begtime'])."+".$i."day");
				$order1[$o['roomid']][$riqi] +=$o['room_number'] ;
			}
		}
		//var_dump($order1);
		foreach($roomArr as $m){ 
			foreach($newTime as $n){ 
				$order2[$m['id']][$n] = 0;
				if($order1[$m['id']][$n]){ 
					$order2[$m['id']][$n] = $order1[$m['id']][$n];
				}
			}
		}
		//var_dump($order2);
		$this->assign("d",$order2);
		$this->assign("a",$a);
		$this->assign("b",$b);
		$this->assign("time",$newdate);
		$this->assign("roomArr",$roomArr);
		$this->display();
	}
	function fjedit(){ 
		//查询出房型名称
		$roomArr = $this->hotel_model->where("iroom_status = 1")->field("room_name,id,clevel_price0,total_number")->select(); 
		$this->assign("roomArr",$roomArr);
		$this->display();
	}
	function fjedit_post(){ 
		if(IS_POST){ 
			//添加的房价规则
			$data = array(
				"priceroomid" => $_POST['priceroomid'],
				"type" => 1,
				"startTime" => strtotime($_POST['startTime']),
				"endTime" => strtotime($_POST['endTime']),
				"pweek" => json_encode($_POST['pweek']),
				"price" => $_POST['price'],
				"vipprice" => $_POST['vipprice'],
				"created" => time(),
				"creatuid" => get_current_admin_id()
			);
			//往特殊表里添加一条特殊价格的规则
			$roleArr1 = $this->room_role_model->add($data);
			//查询新增的那条规则的数据
			$roleArr = $this->room_role_model->where("id='".$roleArr1."'")->find();
			//开始时间到结束时间有多少天
			$a = ($roleArr['endtime'] - $roleArr['starttime'])/86400;
			$b = date("Y-m-d",$roleArr['starttime']);
			$arr=array();
			for($i=0;$i<=$a;$i++)
			{
			    $arr[] = date("Y-m-d",strtotime($b."+".$i."day"));
			}
			//开始时间到结束时间转成时间戳
			foreach($arr as $val){ 
				$cTime[] = strtotime($val);
			}
			
			//特殊天数有多少天
			$xq = json_decode($roleArr['pweek']);
			$xqArr = get_object_vars($xq);
			
			if($xqArr){
				foreach($cTime as $x){ 
					//\Think\Log::record("日期：".$x."星期：".date("w",$x));
					foreach($xqArr as $t){
						//\Think\Log::record("星期：".$t);
						if($t == date("w",$x)){
							//解析规则的所有数据
							$xingqiArr[] = array(
								"hotel_id" => $roleArr['priceroomid'],
								"price" => $roleArr['vipprice'],
								"ctime" => $x,
								"type" => $roleArr['type']
							);
						}
					}
				}
				//\Think\Log::record("价格：".json_encode($xingqiArr));
				//当前房型旧规则的所有数据
				$cTimeArr = $this->room_price_model->where(array("hotel_id"=>$roleArr['priceroomid'],"type"=>1))->select();
				//新规则数据与旧规则数据
				foreach($xingqiArr as $v){ 
					$flag=true;
					foreach($cTimeArr as $x){ 
						if($v['ctime'] == $x['ctime']){ 
							//改旧数据的价格
							$x["price"]=$v["price"];
							$updateArr[]=$v;
							$flag=false;
						}
					}
					if($flag){ 
						$insertArr[]=$v;
					}
				}
				$this->room_price_model->addAll($insertArr);
				//$this->room_price_model->save($updateArr);
				foreach($updateArr as $v){ 
					$p = $this->room_price_model->where(array("hotel_id"=>$v['hotel_id'],"ctime"=>$v['ctime'],"type"=>$v['type']))->setField("price",$v['price']);
				}
			}
			if($roleArr1){
				$this->success("添加成功！",U("Hotel/fjindex"));
			}else{ 
				$this->error("添加失败！");
			}	
		}
	}
	function fledit(){ 
		$roomArr = $this->hotel_model->where("iroom_status = 1")->field("room_name,id,clevel_price0,total_number")->select(); 
		$this->assign("roomArr",$roomArr);
		$this->display();
	}
	function fledit_post(){ 
		if(IS_POST){ 
			$data = array(
				"priceroomid" => $_POST['priceroomid'],
				"type" => 2,
				"startTime" => strtotime($_POST['startTime']),
				"endTime" => strtotime($_POST['endTime']),
				"pweek" => json_encode($_POST['pweek']),
				"roomnum" => $_POST['roomnum'],
				"created" => time(),
				"creatuid" => get_current_admin_id()
			);
			$roleArr1 = $this->room_role_model->add($data);
			//查询新增的那条规则的数据
			$roleArr = $this->room_role_model->where("id='".$roleArr1."'")->find();
			//开始时间到结束时间有多少天
			$a = ($roleArr['endtime'] - $roleArr['starttime'])/86400;
			$b = date("Y-m-d",$roleArr['starttime']);
			$arr=array();
			for($i=0;$i<=$a;$i++)
			{
			    $arr[] = date("Y-m-d",strtotime($b."+".$i."day"));
			}
			//开始时间到结束时间转成时间戳
			foreach($arr as $val){ 
				$cTime[] = strtotime($val);
			}
			
			//特殊天数有多少天
			$xqArr = json_decode($roleArr['pweek'],true);
//			$xqArr = get_object_vars($xq);
			
			if($xqArr){
				foreach($cTime as $x){ 
					//\Think\Log::record("日期：".$x."星期：".date("w",$x));
					foreach($xqArr as $t){
						//\Think\Log::record("星期：".$t);
						if($t == date("w",$x)){
							//解析规则的所有数据
							$xingqiArr[] = array(
								"hotel_id" => $roleArr['priceroomid'],
								"room_num" => $roleArr['roomnum'],
								"ctime" => $x,
								"type" => $roleArr['type']
							);
						}
					}
				}
				//\Think\Log::record("价格：".json_encode($xingqiArr));
				//当前房型旧规则的所有数据
				$cTimeArr = $this->room_price_model->where(array("hotel_id"=>$roleArr['priceroomid'],"type"=>2))->select();
				//新规则数据与旧规则数据
				foreach($xingqiArr as $v){ 
					$flag=true;
					foreach($cTimeArr as $x){ 
						if($v['ctime'] == $x['ctime']){ 
							//改旧数据的价格
							$x["room_num"]=$v["room_num"];
							$updateArr[]=$v;
							$flag=false;
						}
					}
					if($flag){ 
						$insertArr[]=$v;
					}
				}
				$this->room_price_model->addAll($insertArr);
				foreach($updateArr as $v){ 
					$this->room_price_model->where(array("hotel_id"=>$v['hotel_id'],"ctime"=>$v['ctime'],"type"=>$v['type']))->setField("room_num",$v['room_num']);
				}
			}
			if($roleArr){ 
				$this->success("添加成功！",U("Hotel/fjindex"));
			}else{ 
				$this->error("添加失败！");
			}	
		}
	}

	//留言列表
	
	public function contact(){
		$where = array("isdel" => "0");
    	
        //查询总数
        $count=M("contacts")->where($where)->count();
		//分页查询
    	$page = $this->page($count, 10);
    	$contact = M("contacts")
		->where($where)
    	->order("id DESC")
    	->limit($page->firstRow . ',' . $page->listRows)
    	->select();
    	$this->assign("page",$page->show("Admin"));
    	$this->assign("contact",$contact);
		$this->display();
	}
	
	public function contactdetele(){
		$id = I("get.id");
		$isdel = I("get.isdel");
		if(M("contacts")->where("id='" . $id . "'")->setField('isdel',$isdel)!==false){ 
			$this->success("已确认",U("Hotel/contact"));
		}else{ 
			$this->error("确认失败！");
		}
	}
}