<?php
namespace Wechat\Controller;
use Common\Controller\WxBaseController; 
/**
 * 首页
 */
class RoomController extends WxBaseController {
	
	
	function _initialize() {
		parent::_initialize();
		$this->room_model = M("room");
		$this->info_model = M("hotel_info");
		$this->openid = $_SESSION['fans']['id'] ? $_SESSION['fans']['id'] : $_SESSION['fans']['openid'];
	}
	
	
	//客房
	public function room() {
		//酒店信息
		$infoArr = $this->info_model
		->join("ejd_dict on ejd_dict.id = ejd_hotel_info.hotel_star","left")
		->field("ejd_dict.name,ejd_hotel_info.*")
		->find();
		//入住时间显示
		$time = date("m月d日",time());
		$this->assign("time",$time);
		//住店隐藏值显示
		$sdate = date("Y-m-d",time());
		$this->assign("sdate",$sdate);
		//离店时间显示
		$time1 = date("m月d日",strtotime("+1 days"));
		$this->assign("time1",$time1);
		//离店时间隐藏值
		$edate = date("Y-m-d",strtotime("+1 days"));
		$this->assign("edate",$edate);
		//入住周显示
		$weekArr = array("日","一","二","三","四","五","六",);
		$week = "周".$weekArr[date('w')];
		$this->assign("week",$week);
		//离店当天周几显示
		$week1 = "周".$weekArr[date("w",strtotime(date("Y-m-d",strtotime("+1 days"))))];
		$this->assign("week1",$week1);
		//最多提前多少天预订
		$day = array( 1=>30,2=>60,3=>90,4=>180,5=>365);
		$maxdays = $day[$infoArr['maxdays']];
		$time2 = date("Y-m-d",strtotime("+ $maxdays days"));
		$this->assign("time2",$time2);
		
		$phone = $_SESSION['fans']['phone'];
		$this->assign("phone",$phone);
		$this->assign("infoArr",$infoArr);
		$this->assign("room_curr","curr");
		$this->display();
    }
	public function room_comment(){
		$this->display();
	}
	public function room_book(){
		//传过来的id
		$phone = $_SESSION['fans']['phone'];
		$truename = M("fans")->where(array("phone"=>$phone))->field("name,id")->find();
		//查询最近一次订单
		$orderA = M("order")->where("vipid = '".$truename['id']."' and xymcode > 13000000000 and xymcode < 19000000000")->field("xymcode")->order("created desc")->find();
		$this->assign("ordercode",$orderA);
		$this->assign("truename",$truename);
		$this->assign("phone",$phone);
		$id = I("get.id");
		
		$this->assign("id",$id);
		//传过来的入住时间
		$begintime = I('get.begintime');

		//var_dump($begintime);
		$this->assign("begintime",$begintime);
		//传过来的离店时间
		$endtime = I('get.endtime');
		$this->assign("endtime",$endtime);
		//传过来的价格
		$Zprice = I("get.Zprice");
		
		$paymenttype = I("get.paymenttype");
		$this->assign("paymenttype",$paymenttype);
		
		//查询房间量
		
		//共住几晚
		$time3 = (strtotime($endtime) - strtotime($begintime))/86400;
		$this->assign("time3",$time3);
		$RoomRpRoom = M("room_rp_room")
		->join("ejd_room on ejd_room.id = ejd_room_rp_room.roomid","left")
		->join("ejd_room_rp on ejd_room_rp.id = ejd_room_rp_room.rpid","left")
		->where('ejd_room_rp_room.id="'.$id.'"')
		->field("ejd_room.clevel_price0,ejd_room_rp.bfservice,ejd_room_rp_room.roomid,ejd_room_rp_room.rpid,ejd_room.room_name,ejd_room_rp.rateplanname,ejd_room_rp.pricetype,ejd_room_rp.reserveitem,ejd_room_rp.pricerule")
		->find();
		$roomNum = M("room")->where("id='".$RoomRpRoom['roomid']."'")->field("total_number")->find();
		//从特殊表里查询特殊房量
		$roomNumTe = M("room_price")->where("hotel_id = '".$RoomRpRoom['roomid']."' and type=2 and ctime = '".strtotime($begintime)."'")->field("room_num")->find();
		$numTe = $roomNumTe['room_num'] ? $roomNumTe['room_num'] : $roomNum['total_number'];
		for($i = 1;$i<=$numTe;$i++){
			$numTe1[] = $i;
		}
		$this->assign("numTe1",$numTe1);
		$bfservice = json_decode($RoomRpRoom['bfservice'],true);
		$pricerule = json_decode($RoomRpRoom['pricerule'],true);
		if($RoomRpRoom['pricetype'] == "-1"){
			if($RoomRpRoom['reserveitem'] == "-4"){
				$time1 = date("Y-m-d",strtotime($endtime ."-".$pricerule[-7]."days"));
				for($i=0;$i<$pricerule[-7];$i++){
					$time2[] = strtotime(date("Y-m-d",strtotime($time1 . "+" . $i . "days")));
				}
				
			}
			
		}else{
			if($RoomRpRoom['reserveitem'] == "4"){
				$time1 = date("Y-m-d",strtotime($endtime ."-".$pricerule[7]."days"));
				for($i=0;$i<$pricerule[7];$i++){
					$time2[] = strtotime(date("Y-m-d",strtotime($time1 . "+" . $i . "days")));
				}
			}
		}
		//var_dump($time1);
		$tmp = 0;
		foreach($bfservice as $key=>$v){
			if($key < 5){
				$tmp += $v;
			}
		}
		$where = "ctime < '".strtotime($endtime)."' and ctime >= '".strtotime($begintime)."' and hotel_id='".$RoomRpRoom['roomid']."'";
		$RoomPrice = M("room_price")
		->where($where)
		->field("ctime,price")
		->select();
		if(!empty($RoomPrice)){
			foreach($RoomPrice as $p){
				$price1 = $tmp + $p['price'];
				$pArr[$p['ctime']] = $p['price'] +$tmp;
			}	
		}
		
		//循环入住时间到离店时间
		for($i=0;$i<$time3;$i++){
			$newdate[] = strtotime(date("Y-m-d",strtotime($begintime . "+" . $i . "days")));
		}
		foreach($newdate as $n){
			$price2 = $RoomRpRoom['clevel_price0'] + $tmp;
			$RoomP[$n] = $this->price($price2,$pricerule,$RoomRpRoom['pricetype'],$RoomRpRoom['reserveitem'],$begintime,$endtime,$bfservice[5],$n,$time2);
			if($pArr[$n]){
				$RoomP[$n] = $this->price($pArr[$n],$pricerule,$RoomRpRoom['pricetype'],$RoomRpRoom['reserveitem'],$sdate,$edate,$bfservice[5],$n,$time2);
			}
		}
		$price = array_sum($RoomP);
		//查询接受电话号码
		$order_tel = M("hotel_info")->field("order_tel")->find();
		$this->assign("order_tel",$order_tel);
		$this->assign("Zprice",$price);
		$this->assign("RoomP",$RoomP);
		//入住时间显示
		$time = date("m月d日",strtotime($begintime));
		$this->assign("time",$time);
		//入住周显示
		$weekArr = array("日","一","二","三","四","五","六",);
		$week = "周".$weekArr[date('w',strtotime($begintime))];
		$this->assign("week",$week);
		//住店隐藏值显示
		$this->assign("sdate",$begintime);
		//离店时间显示
		$time1 = date("m月d日",strtotime($endtime));
		$this->assign("time1",$time1);
		$week1 = "周".$weekArr[date("w",strtotime($endtime))];
		//离店时间隐藏值
		$this->assign("edate",$endtime);
		//查询最多提前多少天预定
		$infoArr = $this->info_model
		->field("maxdays,hotel_tel")
		->find();
		$day = array( 1=>30,2=>60,3=>90,4=>180,5=>365);
		$maxdays = $day[$infoArr['maxdays']];
		$time2 = date("Y-m-d",strtotime("$begintime + $maxdays days"));
		$this->assign("time2",$time2);
		$this->assign("week1",$week1);
		$this->assign("RoomRp",$RoomRpRoom);
		$this->assign("infoArr",$infoArr);
		$this->display();
	}
	
	function roomajax(){
		if(IS_POST){
			$sdate = strtotime($_POST['HDSDate']);
			$edate = strtotime($_POST['HDEDate']);
			//查询线上的房型信息
			$RoomArr = $this->room_model->where("iroom_status = 1")->select();
			//查询入住当天的特殊价格 再前端页面有用
			$room_price = M("room_price")->where("ctime='".$sdate."' and type=1")->getField("hotel_id,price");

			//查询条件
			$where = "ejd_room.iroom_status=1 and ejd_room_rp.status=1 and ejd_room_rp.startdate <='".$sdate."' and ejd_room_rp.EndDate >='".$edate."'";
			//查询所有的套餐信息
			$RoomRpArr = $this->room_model
			->join("ejd_room_rp_room on ejd_room_rp_room.roomid=ejd_room.id","left")
			->join("ejd_room_rp on ejd_room_rp.id = ejd_room_rp_room.rpid","left")
			->where($where)
			->field("ejd_room_rp_room.roomid,ejd_room_rp_room.id,ejd_room_rp.rateplanname,ejd_room.clevel_price0,ejd_room_rp.bfservice,ejd_room_rp.paymenttype,ejd_room.total_number,ejd_room_rp.pricetype,ejd_room_rp.reserveitem,ejd_room_rp.pricerule")
			->select();
			//计算套餐后的价格
			$RoomRpArr1 = array();
			foreach($RoomRpArr as $vo){
				$json = json_decode($vo['bfservice'],true);
				$pricerule = json_decode($vo['pricerule'],true);
				$tmp = 0;
				foreach($json as $k=>$v){
					$Zprice = $room_price[$vo['roomid']] ? $room_price[$vo['roomid']] : $vo['clevel_price0'];
					if($k < 5){
						$tmp += $v;
						$price = $tmp + $Zprice;
						
					}
				}
				$vo['Zprice'] = ceil($this->Z_price($price,$pricerule,$vo['pricetype'],$vo['reserveitem'],date("Y-m-d",$sdate),date("Y-m-d",$edate),$json[5]));
				$RoomRpArr1[$vo['roomid']][] = $vo;
			}
			\Think\Log::record("计算套餐后的价格结果：".json_encode($RoomRpArr1));
			//以套餐价格进行升序排序
			 foreach($RoomRpArr1 as $key=>$val){
		        $new_array= array();
		        $sort_array = array();
		        foreach($val as $k=>$v){
		            $sort_array[$k] = $v['Zprice'];
		        }
				asort($sort_array);//降序使用 arsort();
			 	reset($sort_array);
				
		        foreach($sort_array as $k=>$v){
		            $new_array[] = $RoomRpArr1[$key][$k];
		        }
				$RoomRpArr1[$key] = $new_array;
		    }
			//开始时间到结束时间循环出每天的时间
			$bedtime = ($edate - $sdate)/86400;
			for($i=0;$i<$bedtime;$i++){
				$newdate[] = date("Y-m-d",strtotime(date("Y-m-d",$sdate) . "+" .$i. "days"));
			}
			//查询开始时间到结束时间的特殊房量
			$numArr = M("room_price")->where( "ctime >= '".$sdate."' and ctime <= '".$edate."' and type=2")
			->field("hotel_id,ctime,room_num")
			->select();
			//已时间年月日作为下标 附上特殊的房量
			foreach($numArr as $n){ 
				//将特殊时间转成年月日做下标
				$ctimes = date("Y-m-d",$n['ctime']);
				$nArr[$n['hotel_id']][$ctimes] = $n['room_num'];
			}
			\Think\Log::record("已时间年月日作为下标 附上特殊的房量结果：".json_encode($NumArr));
			//开始时间到结束时间哪天有特殊房量就附上特殊房量 没有就附上原有房量
			foreach($RoomRpArr as $r){ 
				foreach($newdate as $t){ 
					$NumArr[$r['roomid']][$t] = $r['total_number'];
					if($nArr[$r['roomid']][$t] || $nArr[$r['roomid']][$t] === "0"){
						$NumArr[$r['roomid']][$t] = $nArr[$r['roomid']][$t];
					}
				}
			}
			\Think\Log::record("开始时间到结束时间房量结果：".json_encode($NumArr));
			//统计订单中的房型的房间数
			$order_number = M("order")
			->where("(begtime <= '".$sdate."' and endtime >= '".$sdate."') or (begtime > '".$sdate."' and begtime <= '".$edate."')")
			->where("status > 0")
			->field("roomid,begtime,endtime,room_number,status")
			->select();
			\Think\Log::record("统计订单中的房型的房间数返回结果：".json_encode($order_number));
			//循环订单中的数据从开始时间到结束时间每个房间订出多少进行累加
			foreach($order_number as $vo){
				$begdate = ($vo['endtime'] - $vo['begtime'])/86400;
				for($i=0;$i<$begdate;$i++){
					$enddate = date("Y-m-d",strtotime(date("Y-m-d",$vo['begtime']) . "+" . $i . "days"));
					$room_num[$vo['roomid']][$enddate] += $vo['room_number']; 
				}
			}
			\Think\Log::record("查询订单数据中房间累加返回结果：".json_encode($room_num));
			foreach($RoomRpArr as $m){ 
				foreach($newdate as $n){ 
					$room_N[$m['roomid']][$n] = 0;
					if($room_num[$m['roomid']][$n]){ 
						$room_N[$m['roomid']][$n] = $room_num[$m['roomid']][$n];
					}
				}
			}
		}
		
		$phone = $_SESSION['fans']['phone'];
		$this->assign("phone",$phone);
		$this->assign("newdate",$newdate);
		$this->assign("NumArr",$NumArr);
		$this->assign("room_N",$room_N);
		$this->assign("room_price",$room_price);
		$this->assign("edate",date("Y-m-d",$edate));
		$this->assign("sdate",date("Y-m-d",$sdate));
		$this->assign("room_num",$room_num);
		$this->assign("room_number",$room_number);
		$this->assign("RoomArr",$RoomArr);
		$this->assign("RoomRpArr1",$RoomRpArr1);
		$this->display();
	}
	
	//房型详情
	public function img_post(){
		if(IS_POST){
			$roomid = $_POST['roomid'];
			$RoomArr = $this->room_model->where("iroom_status = 1 and id = '".$roomid."'")->find();
			$hotelInfo = M("hotel_info")->field("hotel_tel,earlieintime,lastouttime")->find();
			$RoomArr['pics'] = json_decode($RoomArr['pics'],true);
			$RoomInfo = array_merge($RoomArr,$hotelInfo);
			$phoneA = $_SESSION['fans']['phone'];
			if($RoomInfo){
				$resArr = array(
					"code" => 0,
					"data" => $RoomInfo,
					"phone" => $phoneA
				);
			}else{
				$resArr = array(
					"code" => 1,
					"data" => "",
					"phone" => $phoneA
				);
			}
		}
		exit(json_encode($resArr));
	}
	//客房订单
	function rpajax(){
		if(IS_POST){
			$sdate = $_POST['HDSDate'];
			$edate = $_POST['HDEDate'];
			$rid = $_POST['rid'];
			$Zprice = $_POST['Zprice'];
			$jian = $_POST['jian'];
			$xymcode = trim($_POST['xymcode']);
			$RoomRpRoom = M("room_rp_room")
			->join("ejd_room on ejd_room.id = ejd_room_rp_room.roomid","left")
			->join("ejd_room_rp on ejd_room_rp.id = ejd_room_rp_room.rpid","left")
			->where('ejd_room_rp_room.id="'.$rid.'"')
			->field("ejd_room.clevel_price0,ejd_room_rp.bfservice,ejd_room_rp_room.roomid,ejd_room_rp_room.rpid,ejd_room.room_name,ejd_room_rp.rateplanname,ejd_room_rp.pricetype,ejd_room_rp.reserveitem,ejd_room_rp.pricerule")
			->find();
			if($xymcode){
				$xymphone = M("member")->where("phone=".$xymcode)->find();
			}
			$xymid = M("xym_code")->where(array('roomid'=>$RoomRpRoom['roomid']))->order("created desc")->find();
			$zhexym = M("xymcode")->where("id = '".$xymid['xymid']."' and endtime >= '".strtotime($sdate)."' and starttime <='".strtotime($sdate)."' and isdel=1")->find();
			if($xymphone && $zhexym){
				$time = (strtotime($edate) - strtotime($sdate))/86400;
				$tdate = ($zhexym['endtime'] - $zhexym['starttime'])/86400;
				$bfservice = json_decode($RoomRpRoom['bfservice'],true);
				$pricerule = json_decode($RoomRpRoom['pricerule'],true);
				if($RoomRpRoom['pricetype'] == "-1"){
					if($RoomRpRoom['reserveitem'] == "-4"){
						$time1 = date("Y-m-d",strtotime($edate ."-".$pricerule[-7]."days"));
						for($i=0;$i<$pricerule[-7];$i++){
							$time2[] = strtotime(date("Y-m-d",strtotime($time1 . "+" . $i . "days")));
						}
						
					}
					
				}else{
					if($RoomRpRoom['reserveitem'] == "4"){
						$time1 = date("Y-m-d",strtotime($edate ."-".$pricerule[7]."days"));
						for($i=0;$i<$pricerule[7];$i++){
							$time2[] = strtotime(date("Y-m-d",strtotime($time1 . "+" . $i . "days")));
						}
					}
				}
				$tmp = 0;
				foreach($bfservice as $key=>$v){
					if($key < 5){
						$tmp += $v;
					}
				}
				$where = "ctime < '".strtotime($edate)."' and ctime >= '".strtotime($sdate)."' and hotel_id='".$RoomRpRoom['roomid']."'";
				$RoomPrice = M("room_price")
				->where($where)
				->field("ctime,price")
				->select();
				if(!empty($RoomPrice)){
					foreach($RoomPrice as $p){
						$pArr[$p['ctime']] = $p['price'] + $tmp;
					}	
				}
				
				for($i=0;$i<$time;$i++){
					$newdate[] = strtotime(date("Y-m-d",strtotime($sdate . "+" . $i . "days")));
				}
				$time4 = date("Y-m-d",$zhexym['starttime']);
				for($i=0;$i<$tdate;$i++){
					$newdate1[] = strtotime(date("Y-m-d",strtotime( $time4. "+" . $i . "days")));
				}
				foreach($newdate1 as $vo){
					$zhekou[$vo] = $zhexym['disprice'];
				}
				foreach($newdate as $n){
					if($zhekou[$n]){
						if($zhexym['type'] == 1){
							$price2 = $RoomRpRoom['clevel_price0'] + $tmp;
							$RoomP[$n] = ($this->price($price2,$pricerule,$RoomRpRoom['pricetype'],$RoomRpRoom['reserveitem'],$sdate,$edate,$bfservice[5],$n,$time2))*(ceil($zhexym['disprice']))/10;
							if($pArr[$n]){
								$RoomP[$n] = ($this->price($pArr[$n],$pricerule,$RoomRpRoom['pricetype'],$RoomRpRoom['reserveitem'],$sdate,$edate,$bfservice[5],$n,$time2))*(ceil($zhexym['disprice']))/10;
								
							}
						}else{
							$price2 = $RoomRpRoom['clevel_price0'] + $tmp;
							$RoomP[$n] = ($this->price($price2,$pricerule,$RoomRpRoom['pricetype'],$RoomRpRoom['reserveitem'],$sdate,$edate,$bfservice[5],$n,$time2))-(ceil($zhexym['disprice']));
							if($pArr[$n]){
								$RoomP[$n] = ($this->price($pArr[$n],$pricerule,$RoomRpRoom['pricetype'],$RoomRpRoom['reserveitem'],$sdate,$edate,$bfservice[5],$n,$time2))-(ceil($zhexym['disprice']));
								
							}
						}
					}else{
						$price2 = $RoomRpRoom['clevel_price0'] + $tmp;
						$RoomP[$n] = $this->price($price2,$pricerule,$RoomRpRoom['pricetype'],$RoomRpRoom['reserveitem'],$sdate,$edate,$bfservice[5],$n,$time2);
						if($pArr[$n]){
							$RoomP[$n] = $this->price($pArr[$n],$pricerule,$RoomRpRoom['pricetype'],$RoomRpRoom['reserveitem'],$sdate,$edate,$bfservice[5],$n,$time2);
							
						}
					}
					
				}
				$price = array_sum($RoomP) * $jian;
			}else{
				$time = (strtotime($edate) - strtotime($sdate))/86400;
				$bfservice = json_decode($RoomRpRoom['bfservice'],true);
				$pricerule = json_decode($RoomRpRoom['pricerule'],true);
				if($RoomRpRoom['pricetype'] == "-1"){
					if($RoomRpRoom['reserveitem'] == "-4"){
						$time1 = date("Y-m-d",strtotime($edate ."-".$pricerule[-7]."days"));
						for($i=0;$i<$pricerule[-7];$i++){
							$time2[] = strtotime(date("Y-m-d",strtotime($time1 . "+" . $i . "days")));
						}
						
					}
					
				}else{
					if($RoomRpRoom['reserveitem'] == "4"){
						$time1 = date("Y-m-d",strtotime($edate ."-".$pricerule[7]."days"));
						for($i=0;$i<$pricerule[7];$i++){
							$time2[] = strtotime(date("Y-m-d",strtotime($time1 . "+" . $i . "days")));
						}
					}
				}
				$tmp = 0;
				foreach($bfservice as $key=>$v){
					if($key < 5){
						$tmp += $v;
					}
				}
				$where = "ctime < '".strtotime($edate)."' and ctime >= '".strtotime($sdate)."' and hotel_id='".$RoomRpRoom['roomid']."'";
				$RoomPrice = M("room_price")
				->where($where)
				->field("ctime,price")
				->select();
				if(!empty($RoomPrice)){
					foreach($RoomPrice as $p){
						$pArr[$p['ctime']] = $p['price'] + $tmp;
					}	
				}
				
				for($i=0;$i<$time;$i++){
					$newdate[] = strtotime(date("Y-m-d",strtotime($sdate . "+" . $i . "days")));
				}
				
				foreach($newdate as $n){
					$price2 = $RoomRpRoom['clevel_price0'] + $tmp;
					$RoomP[$n] = $this->price($price2,$pricerule,$RoomRpRoom['pricetype'],$RoomRpRoom['reserveitem'],$sdate,$edate,$bfservice[5],$n,$time2);
					if($pArr[$n]){
						$RoomP[$n] = $this->price($pArr[$n],$pricerule,$RoomRpRoom['pricetype'],$RoomRpRoom['reserveitem'],$sdate,$edate,$bfservice[5],$n,$time2);
						
					}
				}
				$price = array_sum($RoomP) * $jian;
			}
		}
		
		$this->assign("sdate",$sdate);
		$this->assign("edate",$edate);
		$this->assign("Zprice",$price);
		$this->assign("RoomP",$RoomP);
		$this->assign("RoomRp",$RoomRpRoom);
		$this->display();
	}

	function order_post(){
		if(IS_POST){
			$openid = $_SESSION['fans']['id'] ? $_SESSION['fans']['id'] : $_SESSION['fans']['openid'];
			$array = array(
				"name" => $_POST['name'],
				"vname" => $_POST['vname']
			);
			$vip_name = json_encode($array);
			$rid = $_POST['rid'];
			$paymenttype = $_POST['paymenttype'];
			$HDSDate = $_POST['HDSDate'];
			$HDEDate = $_POST['HDEDate'];
			$jian = $_POST['jian'];
			$numDayNew = $_POST['numDayNew'];
			$txtUserTel = $_POST['txtUserTel'];
			$eta = $_POST['eta'];
			$bz = $_POST['bz'];
			$hdsure = $_POST['hdsure'];
			$room_id = $_POST['room_id'];
			$rp_id = $_POST['rp_id'];
			$xymcode = trim($_POST['xymcode']);
			
			$RoomRpRoom = M("room_rp_room")
			->join("ejd_room on ejd_room.id = ejd_room_rp_room.roomid","left")
			->join("ejd_room_rp on ejd_room_rp.id = ejd_room_rp_room.rpid","left")
			->where('ejd_room_rp_room.id="'.$rid.'"')
			->field("ejd_room.clevel_price0,ejd_room_rp.bfservice,ejd_room_rp_room.roomid,ejd_room_rp_room.rpid,ejd_room.room_name,ejd_room_rp.rateplanname,ejd_room_rp.pricetype,ejd_room_rp.reserveitem,ejd_room_rp.pricerule")
			->find();
			if($xymcode){
				$xymphone = M("member")->where("phone=".$xymcode)->find();
				if(!$xymphone){
					$xymphone['phone'] = 1;
				}
			}
			$xymid = M("xym_code")->where(array('roomid'=>$RoomRpRoom['roomid']))->order("created desc")->find();
			$zhexym = M("xymcode")->where("id = '".$xymid['xymid']."' and endtime >= '".strtotime($HDSDate)."' and starttime <='".strtotime($HDSDate)."' and isdel=1")->find();
			if($xymphone && $zhexym){
				$time = (strtotime($HDEDate) - strtotime($HDSDate))/86400;
				$tdate = ($zhexym['endtime'] - $zhexym['starttime'])/86400;
				$bfservice = json_decode($RoomRpRoom['bfservice'],true);
				$pricerule = json_decode($RoomRpRoom['pricerule'],true);
				if($RoomRpRoom['pricetype'] == "-1"){
					if($RoomRpRoom['reserveitem'] == "-4"){
						$time1 = date("Y-m-d",strtotime($HDEDate ."-".$pricerule[-7]."days"));
						for($i=0;$i<$pricerule[-7];$i++){
							$time2[] = strtotime(date("Y-m-d",strtotime($time1 . "+" . $i . "days")));
						}
						
					}
					
				}else{
					if($RoomRpRoom['reserveitem'] == "4"){
						$time1 = date("Y-m-d",strtotime($HDEDate ."-".$pricerule[7]."days"));
						for($i=0;$i<$pricerule[7];$i++){
							$time2[] = strtotime(date("Y-m-d",strtotime($time1 . "+" . $i . "days")));
						}
					}
				}
				$tmp = 0;
				foreach($bfservice as $key=>$v){
					if($key < 5){
						$tmp += $v;
					}
				}
				$where = "ctime < '".strtotime($HDEDate)."' and ctime >= '".strtotime($HDSDate)."' and hotel_id='".$RoomRpRoom['roomid']."'";
				$RoomPrice = M("room_price")
				->where($where)
				->field("ctime,price")
				->select();
				if(!empty($RoomPrice)){
					foreach($RoomPrice as $p){
						$pArr[$p['ctime']] = $p['price'] + $tmp;
					}	
				}
				
				for($i=0;$i<$time;$i++){
					$newdate[] = strtotime(date("Y-m-d",strtotime($HDSDate . "+" . $i . "days")));
				}
				$time4 = date("Y-m-d",$zhexym['starttime']);
				for($i=0;$i<$tdate;$i++){
					$newdate1[] = strtotime(date("Y-m-d",strtotime( $time4. "+" . $i . "days")));
				}
				foreach($newdate1 as $vo){
					$zhekou[$vo] = $zhexym['disprice'];
				}
				foreach($newdate as $n){
					if($zhekou[$n]){
						if($zhexym['type'] == 1){
							$price2 = $RoomRpRoom['clevel_price0'] + $tmp;
							$RoomP[$n] = ($this->price($price2,$pricerule,$RoomRpRoom['pricetype'],$RoomRpRoom['reserveitem'],$HDSDate,$HDEDate,$bfservice[5],$n,$time2))*(ceil($zhexym['disprice']))/10;
							if($pArr[$n]){
								$RoomP[$n] = ($this->price($pArr[$n],$pricerule,$RoomRpRoom['pricetype'],$RoomRpRoom['reserveitem'],$HDSDate,$HDEDate,$bfservice[5],$n,$time2))*(ceil($zhexym['disprice']))/10;
								
							}
						}else{
							$price2 = $RoomRpRoom['clevel_price0'] + $tmp;
							$RoomP[$n] = ($this->price($price2,$pricerule,$RoomRpRoom['pricetype'],$RoomRpRoom['reserveitem'],$HDSDate,$HDEDate,$bfservice[5],$n,$time2))-(ceil($zhexym['disprice']));
							if($pArr[$n]){
								$RoomP[$n] = ($this->price($pArr[$n],$pricerule,$RoomRpRoom['pricetype'],$RoomRpRoom['reserveitem'],$HDSDate,$HDEDate,$bfservice[5],$n,$time2))-(ceil($zhexym['disprice']));
								
							}
						}
					}else{
						$price2 = $RoomRpRoom['clevel_price0'] + $tmp;
						$RoomP[$n] = $this->price($price2,$pricerule,$RoomRpRoom['pricetype'],$RoomRpRoom['reserveitem'],$HDSDate,$HDEDate,$bfservice[5],$n,$time2);
						if($pArr[$n]){
							$RoomP[$n] = $this->price($pArr[$n],$pricerule,$RoomRpRoom['pricetype'],$RoomRpRoom['reserveitem'],$HDSDate,$HDEDate,$bfservice[5],$n,$time2);
							
						}
					}
					
				}
				$price = array_sum($RoomP);
				$Zprice = $price * $jian;
			}else{
				$days = (strtotime($HDEDate) - strtotime($HDSDate))/86400;
				$bfservice = json_decode($RoomRpRoom['bfservice'],true);
				$pricerule = json_decode($RoomRpRoom['pricerule'],true);
				if($RoomRpRoom['pricetype'] == "-1"){
					if($RoomRpRoom['reserveitem'] == "-4"){
						$time1 = date("Y-m-d",strtotime($HDEDate ."-".$pricerule[-7]."days"));
						for($i=0;$i<$pricerule[-7];$i++){
							$time2[] = strtotime(date("Y-m-d",strtotime($time1 . "+" . $i . "days")));
						}
						
					}
					
				}else{
					if($RoomRpRoom['reserveitem'] == "4"){
						$time1 = date("Y-m-d",strtotime($HDEDate ."-".$pricerule[7]."days"));
						for($i=0;$i<$pricerule[7];$i++){
							$time2[] = strtotime(date("Y-m-d",strtotime($time1 . "+" . $i . "days")));
						}
					}
				}
				$tmp = 0;
				foreach($bfservice as $key=>$v){
					if($key < 5){
						$tmp += $v;
					}
				}
				$where = "ctime < '".strtotime($HDEDate)."' and ctime >= '".strtotime($HDSDate)."' and hotel_id='".$RoomRpRoom['roomid']."'";
				$RoomPrice = M("room_price")
				->where($where)
				->field("ctime,price")
				->select();
				if(!empty($RoomPrice)){
					foreach($RoomPrice as $p){
						$pArr[$p['ctime']] = $p['price'] + $tmp;
					}	
				}
				for($i=0;$i<$days;$i++){
					$newdate[] = strtotime(date("Y-m-d",strtotime($HDSDate . "+" . $i . "days")));
				}
				foreach($newdate as $n){
					$price2 = $RoomRpRoom['clevel_price0'] + $tmp;
					$RoomP[$n] = $this->price($price2,$pricerule,$RoomRpRoom['pricetype'],$RoomRpRoom['reserveitem'],$HDSDate,$HDEDate,$bfservice[5],$n,$time2);
					if($pArr[$n]){
						$RoomP[$n] = $this->price($pArr[$n],$pricerule,$RoomRpRoom['pricetype'],$RoomRpRoom['reserveitem'],$HDSDate,$HDEDate,$bfservice[5],$n,$time2);
						
					}
				}
				$price = array_sum($RoomP);			
				$Zprice = $price * $jian;
			}
			$roomM = $this->room_model->where(array("id"=>$room_id,"iroom_status"=>1))->find();
			//查询特殊的房量
			$numArr = M("room_price")->where("hotel_id='".$room_id."' and ctime <= '".strtotime($HDSDate)."' and ctime >= '".strtotime($HDEDate)."'")
			->field("ctime,room_num")
			->select();
			foreach($numArr as $n){ 
				$nArr[$n['ctime']] = $n['room_num'];
			}
			foreach($newdate as $n){ 
				$numb[$n] = $roomM['total_number'];
				if($nArr[$n]){ 
					$numb[$n] = $nArr[$n];
				}
			}
			$order_num = M("order")
			->where("roomid='".$room_id."' and ((begtime <= '".strtotime($HDSDate)."' and endtime >= '".strtotime($HDSDate)."') or (begtime > '".strtotime($HDSDate)."' and begtime <= '".strtotime($HDEDate)."')) and status > -1")
			->field("roomid,begtime,endtime,room_number")
			->group("id")
			->select();
			$enddate = array();
			foreach($order_num as $vo){
				$begdate = ($vo['endtime'] - $vo['begtime'])/86400;
				for($i=0;$i<$begdate;$i++){
					$enddate = strtotime(date("Y-m-d",strtotime(date("Y-m-d",$vo['begtime']) . "+" . $i . "days")));
					$room_num[$enddate] += $vo['room_number']; 
				}
			}
			foreach($newdate as $t){
				if($room_num[$t] >= $numb[$t]){
					$resArr = array(
						"code" => "-2",
						"data" => "您下单的这几天中有房间已满！请重新下单"
					);
					exit(json_encode($resArr));
				}
				
			}
			foreach($newdate as $t){
				$number = $room_num[$t] + $jian;
				if($number > $numb[$t]){
					$resArr = array(
						"code" => "-3",
						"data" => "房间剩余房量不足！"
					);
					exit(json_encode($resArr));
				}
			}
			
			
			$data = array(
				"id" => gettableid("DD"),
				"hotelid" => 1,
				"ordertype" => 1,
				"paytype" => $paymenttype,
				"vipname" => $vip_name,
				"vipid" => $openid,
				"vipphone" => $txtUserTel,
				"rpid" => $rp_id,
				"roomid" => $room_id,
				"amount" => $Zprice,
				"begtime" => strtotime($HDSDate),
				"endtime" => strtotime($HDEDate),
				"yenum" => $numDayNew,
				"room_number" => $jian,
				"des" => $bz,
				"hdsure" => $eta,
				"created" => time(),
				"status" => 1,
				"isphone" => $hdsure,
				"type" => 1,
				"xymcode" => $xymphone['phone']
			);
			$orderArr = M("order")->add($data);
			if($orderArr){
				$resArr = array(
					"code" => 0,
					"data" => $orderArr
				);
			}else{
				$resArr = array(
					"code" => 1,
					"data" => ""
				);
			}
		}
		exit(json_encode($resArr));
	}

	function orderlist(){
		$openid = $_SESSION['fans']['id'] ? $_SESSION['fans']['id'] :$_SESSION['fans']['openid'];
		$orderList = M("order")->where(array("ejd_order.vipid"=>$openid))->join("ejd_room on ejd_room.id=ejd_order.roomid","left")->order("ejd_order.created desc")->field("ejd_room.room_name,ejd_order.id")->find();
		$this->assign("orderList",$orderList);
		$this->assign("room_curr","curr");
		$this->display();
	}



	private function price($Zprice,$pricerule,$pricetype,$reserveitem,$sdate,$edate,$bfservice,$n,$time1){
		$now = (strtotime($sdate) - strtotime(date("Y-m-d",time())))/86400;
		$time = (strtotime($edate) - strtotime($sdate))/86400;
		if($pricetype == "-1"){
			if($reserveitem == "-1"){
				$aaa = ($Zprice - $Zprice * ($pricerule[-1]/100)) + ($Zprice - $Zprice * ($pricerule[-1]/100))*($bfservice/100);
				return ceil($aaa);
			}else if($reserveitem == "-2"){
				if($now >= $pricerule[-2]){
					$bbb = ($Zprice - ($Zprice * ($pricerule[-3]/100))) + ($Zprice - ($Zprice * ($pricerule[-3]/100))) * ($bfservice/100);
					return ceil($bbb);
				}else{
					$bbb = $Zprice + $Zprice *($bfservice/100);
					return ceil($bbb) ;
				}
			}else if($reserveitem == "-3"){
				if($time >= $pricerule[-4]){
					$ccc = ($Zprice - ($Zprice *($pricerule[-5]/100))) + ($Zprice - ($Zprice *($pricerule[-5]/100)))*($bfservice/100);
					return ceil($ccc);
				}else{
					$ccc = $Zprice + $Zprice *($bfservice/100);
					return ceil($ccc) ;
				}
			}else if($reserveitem == "-4"){
				if($time >= $pricerule[-6]){
					if(in_array(strval($n),$time1)){
						$ddd = ($Zprice - ($Zprice * ($pricerule[-8]/100))) + ($Zprice - ($Zprice * ($pricerule[-8]/100))) * ($bfservice/100);
						return ceil($ddd);
					}else{
						$ddd = $Zprice + $Zprice *($bfservice/100);
						return ceil($ddd) ;
					}
				}else{
					$ddd = $Zprice + $Zprice *($bfservice/100);
					return ceil($ddd) ;
				}
			}else{
				$vvv = $Zprice + $Zprice *($bfservice/100);
				return ceil($vvv) ;
			}
		}else{
			if($reserveitem == "1"){
				$aaa = ($Zprice - $pricerule[1]) + ($Zprice - $pricerule[1]) * ($bfservice/100);
				return ceil($aaa);
			}else if($reserveitem == "2"){
				if($now >= $pricerule[2]){
					$ooo = $Zprice - $pricerule[3];
					$hhh = $ooo * ($bfservice/100);
					$bbb = $ooo + $hhh;
					return ceil($bbb);
				}else{
					$bbb = $Zprice + $Zprice *($bfservice/100);
					return ceil($bbb) ;
				}
			}else if($reserveitem == "3"){
				if($time >= $pricerule[4]){
					$ccc = $Zprice - $pricerule[5];
					return ceil($ccc);
				}else{
					$ccc = $Zprice + $Zprice *($bfservice/100);
					return ceil($ccc) ;
				}
			}else if($reserveitem == "4"){
				if($time >= $pricerule[6]){
					if(in_array(strval($n),$time1)){
						$ddd = ($Zprice - $pricerule[8]) + ($Zprice - $pricerule[8]) * ($bfservice/100);
						return ceil($ddd);
					}else{
						$ddd = $Zprice + $Zprice * ($bfservice/100);
						return ceil($ddd) ;
					}
				}else{
					$ddd = $Zprice + $Zprice *($bfservice/100);
					return ceil($ddd) ;
				}
			}else{
				$vvv = $Zprice + $Zprice *($bfservice/100);
				return ceil($vvv) ;
			}
		}
	}

	function Z_price($Zprice,$pricerule,$pricetype,$reserveitem,$sdate,$edate,$json){
		$now = (strtotime($sdate) - strtotime(date("Y-m-d",time())))/86400;
		if($pricetype == "-1"){
			if($reserveitem == "-1"){
				$aaa = ($Zprice - $Zprice * ($pricerule[-1]/100)) + (($Zprice - $Zprice * ($pricerule[-1]/100)) * ($json/100));
				return ceil($aaa);
			}else if($reserveitem == "-2"){
				if($now >= $pricerule[-2]){
					$bbb = ($Zprice - ($Zprice * ($pricerule[-3]/100))) + ($Zprice - ($Zprice * ($pricerule[-3]/100))) * ($json/100);
					return ceil($bbb);
				}else{
					$bbb = $Zprice + $Zprice *($json/100);
					return ceil($bbb) ;
				}
				
			}else{
				$ccc = $Zprice + $Zprice *($json/100);
				return ceil($ccc) ;
			}
			
		}else{
			if($reserveitem == "1"){
				$bbb = ($Zprice - $pricerule[1]) + ($Zprice - $pricerule[1])*($json/100);
				return $bbb;
			}else if($reserveitem == "2"){
				if($now >= $pricerule[2]){
					$ooo = $Zprice - $pricerule[3];
					$hhh = $ooo * ($json/100);
					$aaa = $ooo +  $hhh;
					return ceil($aaa);
				}else{
					$aaa =$Zprice + $Zprice *($json/100);
					return ceil($aaa);
				}
				
			}else{
				$ccc =$Zprice + $Zprice *($json/100);
				return ceil($ccc);
			}
		}
	}
	//微信支付
	public function orderPay(){
		$openid = $_SESSION['fans']['id'] ? $_SESSION['fans']['id'] : $_SESSION['fans']['openid'];
			$array = array(
				"name" => $_POST['name'],
				"vname" => $_POST['vname']
			);
			$vip_name = json_encode($array);
			$rid = $_POST['rid'];
			$paymenttype = $_POST['paymenttype'];
			$HDSDate = $_POST['HDSDate'];
			$HDEDate = $_POST['HDEDate'];
			$jian = $_POST['jian'];
			$numDayNew = $_POST['numDayNew'];
			$txtUserTel = $_POST['txtUserTel'];
			$eta = $_POST['eta'];
			$bz = $_POST['bz'];
			$hdsure = $_POST['hdsure'];
			$room_id = $_POST['room_id'];
			$rp_id = $_POST['rp_id'];
			$xymcode = trim($_POST['xymcode']);
			
			$RoomRpRoom = M("room_rp_room")
			->join("ejd_room on ejd_room.id = ejd_room_rp_room.roomid","left")
			->join("ejd_room_rp on ejd_room_rp.id = ejd_room_rp_room.rpid","left")
			->where('ejd_room_rp_room.id="'.$rid.'"')
			->field("ejd_room.clevel_price0,ejd_room_rp.bfservice,ejd_room_rp_room.roomid,ejd_room_rp_room.rpid,ejd_room.room_name,ejd_room_rp.rateplanname,ejd_room_rp.pricetype,ejd_room_rp.reserveitem,ejd_room_rp.pricerule")
			->find();
			if($xymcode){
				$xymphone = M("member")->where("phone=".$xymcode)->find();
				if(!$xymphone){
					$xymphone['phone'] = "";
				}
			}
			$xymid = M("xym_code")->where(array('roomid'=>$RoomRpRoom['roomid']))->order("created desc")->find();
			$zhexym = M("xymcode")->where("id = '".$xymid['xymid']."' and endtime >= '".strtotime($HDSDate)."' and starttime <='".strtotime($HDSDate)."' and isdel=1")->find();
			if($xymphone && $zhexym){
				$time = (strtotime($HDEDate) - strtotime($HDSDate))/86400;
				$tdate = ($zhexym['endtime'] - $zhexym['starttime'])/86400;
				$bfservice = json_decode($RoomRpRoom['bfservice'],true);
				$pricerule = json_decode($RoomRpRoom['pricerule'],true);
				if($RoomRpRoom['pricetype'] == "-1"){
					if($RoomRpRoom['reserveitem'] == "-4"){
						$time1 = date("Y-m-d",strtotime($HDEDate ."-".$pricerule[-7]."days"));
						for($i=0;$i<$pricerule[-7];$i++){
							$time2[] = strtotime(date("Y-m-d",strtotime($time1 . "+" . $i . "days")));
						}
						
					}
					
				}else{
					if($RoomRpRoom['reserveitem'] == "4"){
						$time1 = date("Y-m-d",strtotime($HDEDate ."-".$pricerule[7]."days"));
						for($i=0;$i<$pricerule[7];$i++){
							$time2[] = strtotime(date("Y-m-d",strtotime($time1 . "+" . $i . "days")));
						}
					}
				}
				$tmp = 0;
				foreach($bfservice as $key=>$v){
					if($key < 5){
						$tmp += $v;
					}
				}
				$where = "ctime < '".strtotime($HDEDate)."' and ctime >= '".strtotime($HDSDate)."' and hotel_id='".$RoomRpRoom['roomid']."'";
				$RoomPrice = M("room_price")
				->where($where)
				->field("ctime,price")
				->select();
				if(!empty($RoomPrice)){
					foreach($RoomPrice as $p){
						$pArr[$p['ctime']] = $p['price'] + $tmp;
					}	
				}
				
				for($i=0;$i<$time;$i++){
					$newdate[] = strtotime(date("Y-m-d",strtotime($HDSDate . "+" . $i . "days")));
				}
				$time4 = date("Y-m-d",$zhexym['starttime']);
				for($i=0;$i<$tdate;$i++){
					$newdate1[] = strtotime(date("Y-m-d",strtotime( $time4. "+" . $i . "days")));
				}
				foreach($newdate1 as $vo){
					$zhekou[$vo] = $zhexym['disprice'];
				}
				foreach($newdate as $n){
					if($zhekou[$n]){
						if($zhexym['type'] == 1){
							$price2 = $RoomRpRoom['clevel_price0'] + $tmp;
							$RoomP[$n] = ($this->price($price2,$pricerule,$RoomRpRoom['pricetype'],$RoomRpRoom['reserveitem'],$HDSDate,$HDEDate,$bfservice[5],$n,$time2))*(ceil($zhexym['disprice']))/10;
							if($pArr[$n]){
								$RoomP[$n] = ($this->price($pArr[$n],$pricerule,$RoomRpRoom['pricetype'],$RoomRpRoom['reserveitem'],$HDSDate,$HDEDate,$bfservice[5],$n,$time2))*(ceil($zhexym['disprice']))/10;
								
							}
						}else{
							$price2 = $RoomRpRoom['clevel_price0'] + $tmp;
							$RoomP[$n] = ($this->price($price2,$pricerule,$RoomRpRoom['pricetype'],$RoomRpRoom['reserveitem'],$HDSDate,$HDEDate,$bfservice[5],$n,$time2))-(ceil($zhexym['disprice']));
							if($pArr[$n]){
								$RoomP[$n] = ($this->price($pArr[$n],$pricerule,$RoomRpRoom['pricetype'],$RoomRpRoom['reserveitem'],$HDSDate,$HDEDate,$bfservice[5],$n,$time2))-(ceil($zhexym['disprice']));
								
							}
						}
					}else{
						$price2 = $RoomRpRoom['clevel_price0'] + $tmp;
						$RoomP[$n] = $this->price($price2,$pricerule,$RoomRpRoom['pricetype'],$RoomRpRoom['reserveitem'],$HDSDate,$HDEDate,$bfservice[5],$n,$time2);
						if($pArr[$n]){
							$RoomP[$n] = $this->price($pArr[$n],$pricerule,$RoomRpRoom['pricetype'],$RoomRpRoom['reserveitem'],$HDSDate,$HDEDate,$bfservice[5],$n,$time2);
							
						}
					}
					
				}
				$price = array_sum($RoomP);
				$Zprice = $price * $jian;
			}else{
				$days = (strtotime($HDEDate) - strtotime($HDSDate))/86400;
				$bfservice = json_decode($RoomRpRoom['bfservice'],true);
				$pricerule = json_decode($RoomRpRoom['pricerule'],true);
				if($RoomRpRoom['pricetype'] == "-1"){
					if($RoomRpRoom['reserveitem'] == "-4"){
						$time1 = date("Y-m-d",strtotime($HDEDate ."-".$pricerule[-7]."days"));
						for($i=0;$i<$pricerule[-7];$i++){
							$time2[] = strtotime(date("Y-m-d",strtotime($time1 . "+" . $i . "days")));
						}
						
					}
					
				}else{
					if($RoomRpRoom['reserveitem'] == "4"){
						$time1 = date("Y-m-d",strtotime($HDEDate ."-".$pricerule[7]."days"));
						for($i=0;$i<$pricerule[7];$i++){
							$time2[] = strtotime(date("Y-m-d",strtotime($time1 . "+" . $i . "days")));
						}
					}
				}
				$tmp = 0;
				foreach($bfservice as $key=>$v){
					if($key < 5){
						$tmp += $v;
					}
				}
				$where = "ctime < '".strtotime($HDEDate)."' and ctime >= '".strtotime($HDSDate)."' and hotel_id='".$RoomRpRoom['roomid']."'";
				$RoomPrice = M("room_price")
				->where($where)
				->field("ctime,price")
				->select();
				if(!empty($RoomPrice)){
					foreach($RoomPrice as $p){
						$pArr[$p['ctime']] = $p['price'] + $tmp;
					}	
				}
				for($i=0;$i<$days;$i++){
					$newdate[] = strtotime(date("Y-m-d",strtotime($HDSDate . "+" . $i . "days")));
				}
				foreach($newdate as $n){
					$price2 = $RoomRpRoom['clevel_price0'] + $tmp;
					$RoomP[$n] = $this->price($price2,$pricerule,$RoomRpRoom['pricetype'],$RoomRpRoom['reserveitem'],$HDSDate,$HDEDate,$bfservice[5],$n,$time2);
					if($pArr[$n]){
						$RoomP[$n] = $this->price($pArr[$n],$pricerule,$RoomRpRoom['pricetype'],$RoomRpRoom['reserveitem'],$HDSDate,$HDEDate,$bfservice[5],$n,$time2);
						
					}
				}
				$price = array_sum($RoomP);			
				$Zprice = $price * $jian;
			}
//			for($i=0;$i<$days;$i++){
//				$newdate[] = strtotime(date("Y-m-d",strtotime($HDSDate . "+" . $i . "days")));
//			}
			$roomM = $this->room_model->where(array("id"=>$room_id,"iroom_status"=>1))->find();
			//查询特殊的房量
			$numArr = M("room_price")->where("hotel_id='".$room_id."' and ctime <= '".strtotime($HDSDate)."' and ctime >= '".strtotime($HDEDate)."'")
			->field("ctime,room_num")
			->select();
			foreach($numArr as $n){ 
				$nArr[$n['ctime']] = $n['room_num'];
			}
			foreach($newdate as $n){ 
				$numb[$n] = $roomM['total_number'];
				if($nArr[$n]){ 
					$numb[$n] = $nArr[$n];
				}
			}
			$order_num = M("order")
			->where("roomid='".$room_id."' and ((begtime <= '".strtotime($HDSDate)."' and endtime >= '".strtotime($HDSDate)."') or (begtime > '".strtotime($HDSDate)."' and begtime <= '".strtotime($HDEDate)."')) and status > -1")
			->field("roomid,begtime,endtime,room_number")
			->group("id")
			->select();
			$enddate = array();
			foreach($order_num as $vo){
				$begdate = ($vo['endtime'] - $vo['begtime'])/86400;
				for($i=0;$i<$begdate;$i++){
					$enddate = strtotime(date("Y-m-d",strtotime(date("Y-m-d",$vo['begtime']) . "+" . $i . "days")));
					$room_num[$enddate] += $vo['room_number']; 
				}
			}
			foreach($newdate as $t){
				if($room_num[$t] >= $numb[$t]){
					$resArr = array(
						"code" => "-2",
						"data" => "您下单的这几天中有房间已满！请重新下单"
					);
					exit(json_encode($resArr));
				}
				
			}
			foreach($newdate as $t){
				$number = $room_num[$t] + $jian;
				if($number > $numb[$t]){
					$resArr = array(
						"code" => "-3",
						"data" => "房间剩余房量不足！"
					);
					exit(json_encode($resArr));
				}
			}
			$data = array(
				"id" => gettableid("DD"),
				"hotelid" => 1,
				"ordertype" => 1,
				"paytype" => $paymenttype,
				"vipname" => $vip_name,
				"vipid" => $openid,
				"vipphone" => $txtUserTel,
				"rpid" => $rp_id,
				"roomid" => $room_id,
				"amount" => $Zprice,
				"begtime" => strtotime($HDSDate),
				"endtime" => strtotime($HDEDate),
				"yenum" => $numDayNew,
				"room_number" => $jian,
				"des" => $bz,
				"hdsure" => $eta,
				"created" => time(),
				"status" => 1,
				"isphone" => $hdsure,
				"type" => 1,
				"xymcode" => $xymphone['phone']
			);
			$orderArr = M("order")->add($data);
			if($orderArr){
				$reqparam = $this->requestPay($data['id'], $data['amount']);
				\Think\Log::record("weixin购买挂耳参数：".json_encode($reqparam));
				$resArr = array(
					"success" => true,
					"id" => $data["id"], 
					"payparam" => $reqparam
				);
			}else{
				$resArr = array(
					"success" => flase,
					"msg" => "错误!"
				);
			}
			exit(json_encode($resArr));
		}
		
	private function requestPay($order_id, $amount){
		vendor('wx.WxPayApi');//导入微信类库
		vendor('wx.WxJsApiPay');
		
		$tools = new \WxJsApiPay();
		
		$input = new \WxPayUnifiedOrder();
		$input->SetBody("酒店房间");
		$input->SetAttach("保定电谷酒店");
		$input->SetOut_trade_no($order_id . time());
		$fee=floatval($amount)*100;
		$input->SetTotal_fee($fee);
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 600));
		$input->SetGoods_tag("");
		$input->SetNotify_url("http://diangu.yijiudian.cn/Wechat/WxRoom/index");
		$input->SetTrade_type("JSAPI");
		$input->SetOpenid($this->openid);
		
		$order = \WxPayApi::unifiedOrder($input);
		\Think\Log::record("挂耳咖啡生成订单，订单号：".$input->GetOut_trade_no());
		\Think\Log::record("参数：".json_encode($input->GetValues()));
		$jsApiParameters = $tools->GetJsApiParameters($order);
		\Think\Log::record("返回参数：".$jsApiParameters);
		return $jsApiParameters;
	}
	public function index(){
		$this->display();
	}
	
	public function restaurant_book(){

		$phone = $_SESSION['fans']['phone'];
		$truename = M("fans")->where(array("phone"=>$phone))->field("name")->find();
		$this->assign("truename",$truename);
		$this->assign("phone",$phone);
		$id = I("get.id");
		$dictArr = M("dict")->where("type = '餐段' and (val = 'breakfirst' or val = 'lunch' or val = 'dinner')")->select();
		//餐厅的信息
		$foodArr = M('restaurant_food')
		->join("ejd_dict on ejd_dict.id = ejd_restaurant_food.menutype","left")
		->where(array("ejd_restaurant_food.resid"=>$id))
		->field("ejd_dict.name,ejd_restaurant_food.id,ejd_restaurant_food.resid,ejd_restaurant_food.maxnum,ejd_restaurant_food.foodname,ejd_restaurant_food.picurl,ejd_restaurant_food.price")
		->select();
		foreach($foodArr as $k=>$v){
			$food[$v['name']][] = $v;
		}
		$this->assign("food",$food);
		$this->assign("foodArr",$foodArr);
		$timeH = date("H",time());
		//餐段的显示与隐藏
		foreach($dictArr as $k=>$v){
			if($timeH >= 9 && $v['name'] == '早餐'){
				unset($dictArr[$k]);
			}
			if($timeH > 15 && $v['name'] == "午餐"){
				unset($dictArr[$k]);
			}
//			if($timeH >= 0 && $v['name'] == "下午茶"){
//				unset($dictArr[$k]);
//			}
			if($timeH > 22 && $v['name'] == "晚餐"){
				unset($dictArr);
			}
//			if($timeH < 23 && $timeH > 4 && $v['name'] == "夜宵"){
//				unset($dictArr[$k]);
//			}
		}
		$Restaurant = M('restaurant')->where(array("id"=>$id))->field("id,resname,foodsend,businessbeg,businessend,restel")->find();
		$foodsend = json_decode($Restaurant['foodsend'],true);
		$this->assign("foodsend",$foodsend);
		$this->assign("dictArr",$dictArr);
		$this->assign("Restaurant",$Restaurant);
		$this->display("/Restaurant:restaurant_book");
	}
	
	//餐饮订单详情
	public function cyorderlist(){
		$openid = $_SESSION['fans']['id'] ? $_SESSION['fans']['id'] : $_SESSION['fans']['openid'];
		$ordercyid = $_GET['id'];
		$ctime = $_GET['ctime'];
		if($ordercyid){
			$ordercyList = M("order_cy")
			->join("ejd_restaurant on ejd_restaurant.id = ejd_order_cy.ctid","left")
			->join("ejd_dict on ejd_order_cy.cdid = ejd_dict.id","left")
			->field("ejd_order_cy.id,ejd_order_cy.created,ejd_order_cy.status,ejd_order_cy.paycost,ejd_order_cy.jcaddress,ejd_order_cy.jcnum,ejd_order_cy.automn,ejd_order_cy.ctime,ejd_order_cy.vipphone,ejd_order_cy.vipname,ejd_dict.name,ejd_restaurant.resname")
			->where(array("ejd_order_cy.id"=>$ordercyid))->find();
			$this->assign("ordercyList",$ordercyList);
			$info = M("hotel_info")->field("hotel_tel")->find();
			$this->assign("info",$info);
			$foodList = M("cp_list")
			->join("ejd_restaurant_food on ejd_restaurant_food.id = ejd_cp_list.cpid","left")
			->where(array("ejd_cp_list.openid"=>$openid,"ejd_cp_list.created"=>$ctime))->field("ejd_restaurant_food.foodname")->select();
			$this->assign("foodList",$foodList);
		}
		$this->display("/User:cyorderlist");
	}
	//发送短信
	public function sendVcode(){
		$phone=trim($_POST['order_tel']);
		$message="有新订单了请您登陆后台处理新订单!";
		
		$messageArr=array(
			"phone"=>$phone,
			"created"=>time()
		);
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
	
	//给用户发送短信
	public function sendVcode1(){
		$phone=trim($_POST['txtUserTel']);
		$room_id = $_POST['room_id'];
		$roomname = M("room")->where("id = '".$room_id."'")->field("room_name")->find();
		$message="您好!您预定的".$roomname['room_name']."已预定成功!";
		
		$messageArr=array(
			"phone"=>$phone,
			"created"=>time()
		);
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
	
}
