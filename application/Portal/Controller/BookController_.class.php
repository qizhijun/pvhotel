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
class BookController extends HomebaseController {
	private $roomM;
	public function __construct(){
		parent::__construct();
		$this->roomM=M("room");
		$this->RoomRp=M("room_rp_room");
	}
	
    //在线预订
	public function book() {
		//查询房型信息
		
		$id = I("get.id");
		$cid = I("get.cid");
		$CheckInDate = I("get.CheckInDate");
		$CheckOutDate = I("get.CheckOutDate");
		$begtime = I("get.begtime");
		$endtime = I("get.endtime");
		$rid = !empty($id) ? $id : $cid;
 		$num = I("get.num");
		$rmid = I("get.rmid");
		$time = (strtotime($CheckOutDate) - strtotime($CheckInDate))/86400;
		$begend = (strtotime($endtime) - strtotime($begtime))/86400;
		
		$time1 = !empty($time) ? $time : $begend;
		$date = date("d",time());
		$CheckI = !empty($CheckInDate) ? $CheckInDate : $begtime;
		$CheckO = !empty($CheckOutDate) ? $CheckOutDate : $endtime;
		$BeginDate=date('Y-m-01', strtotime(date("Y-m-d")));
		
		$Month = date("Y-m",time());
		for($i=0;$i<4;$i++){
			$MonthArr[] = date("m月Y",strtotime($Month . "+" .$i."Month"));
		}
		$roomList=$this->roomM
		->where(array(
			"iroom_status"=>1
		,"id"=>$rid))->order("sort_index desc")
		->find();
		$tmp['roomid'] = array("in","$rid");
		
		$RoomRp = $this->RoomRp->where($tmp)->select();
		
		foreach($RoomRp as $vo){
			$rpid[] = $vo['rpid'];
		}
		
		$pid = implode(",",$rpid);
		
		$tap['id'] = array("in","$pid");
		$where = "status=1 and startdate <='".strtotime($CheckI)."' and EndDate >='".strtotime($CheckO)."'";
		
		$TaoCan = M("room_rp")->where($where)->where($tap)->field("id,rateplanname,bfservice,pricetype,reserveitem,pricerule")->select();
		$TaoCan1 = array();
		foreach($TaoCan as $v){
			$bfservice = json_decode($v['bfservice'],ture);
			$price = 0;
			foreach($bfservice as $k=>$vo){
				if($k < 5){
					$price += $vo;
				}
			}
			$v['bfservice'] = $price;
			$v['fw'] = $bfservice[5];
			$TaoCan1[] = $v;
		}
		
		$this->assign("MonthArr",$MonthArr);
		$this->assign("BeginDate",$BeginDate);
		$this->assign("rmid",$rmid);
		$this->assign("TaoCan",$TaoCan1);
		$this->assign("roomList",$roomList);
		$this->assign("time",$time1);
		$this->assign("date",$date);
		$this->assign('id',$rid);
		$this->assign("CheckInDate",$CheckI);
		$this->assign("CheckOutDate",$CheckO);
		$this->assign("num",$num);
    	$this->display();
    }
	
	//房型列表
	public function roomList(){
		
		$RoomArr = $this->roomM->where("iroom_status = 1")->select();
		$this->assign("RoomArr",$RoomArr);
		
		$where = "ejd_room_rp.status=1 and ejd_room_rp.startdate <='".strtotime(date("Y-m-d",time()))."' and ejd_room_rp.EndDate >='".strtotime(date("Y-m-d",time()))."'";
		//客房信息下的套餐信息
		$RoomRpArr = $this->roomM
		->join("ejd_room_rp_room on ejd_room_rp_room.roomid=ejd_room.id","left")
		->join("ejd_room_rp on ejd_room_rp.id = ejd_room_rp_room.rpid","left")
		->join("ejd_room_price on ejd_room_price.hotel_id = ejd_room.id and ejd_room_price.ctime='".strtotime(date('Y-m-d',time()))."'","left")
		->where($where)
		->field("ejd_room_rp_room.roomid,ejd_room_price.hotel_id,ejd_room_price.price,ejd_room_rp_room.id,ejd_room_rp.rateplanname,ejd_room.clevel_price0,ejd_room_rp.bfservice,ejd_room_rp.paymenttype,ejd_room_rp_room.rpid,ejd_room.total_number,ejd_room_rp.pricerule,ejd_room_rp.reserveitem,ejd_room_rp.pricetype")
		->select();
		$begtime = date("Y-m-d",time());
		$endtime = date("Y-m-d",strtotime("+1 days"));
		$RoomRpArr1 = array();
		foreach($RoomRpArr as $vo){
			$json = json_decode($vo['bfservice'],true);
			$pricerule = json_decode($vo['pricerule'],true);
			$tmp = 0;
			foreach($json as $k=>$v){
				$Zprice = $vo['price'] ? $vo['price'] : $vo['clevel_price0'];
				if($k < 5){
					$tmp += $v;
					$price = $tmp + $Zprice;
				}
			}
			$vo['Zprice'] = $this->Z_price($price,$pricerule,$vo['pricetype'],$vo['reserveitem'],$begtime,$endtime,$json[5]);
			$RoomRpArr1[$vo['roomid']][] = $vo;
		}
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
		//var_dump($RoomRpArr1);
		
		$bedtime = (strtotime($endtime) - strtotime($begtime))/86400;
		for($i=0;$i<$bedtime;$i++){
			$newdate[] = strtotime(date("Y-m-d",strtotime($sdate . "+" .$i. "days")));
		}
		$numArr = M("room_price")->where( "ctime <= '".strtotime($begtime)."' and ctime >= '".strtotime($endtime)."'")
		->field("hotel_id,ctime,room_num")
		->select();
		foreach($numArr as $n){ 
			$nArr[$n['hotel_id']][$n['ctime']] = $n['room_num'];
		}
		//var_dump($nArr);
		foreach($RoomRpArr as $r){ 
			foreach($newdate as $t){ 
				$NumArr[$r['roomid']][$t] = $r['total_number'];
				if($nArr[$r['roomid']][$t]){
					$NumArr[$r['roomid']][$t] = $nArr[$r['roomid']][$t];
				}
			}
		}
		//var_dump($NumArr);
		
		//统计房型的房间数
		$order_number = M("order")
		->where("(begtime <= '".strtotime($begtime)."' and endtime >= '".strtotime($begtime)."') or (begtime > '".strtotime($begtime)."' and begtime <= '".strtotime($endtime)."')")
		->field("roomid,begtime,endtime,room_number")
		->group("id")
		->select();
		//var_dump($order_number);
		$enddate = array();
		foreach($order_number as $vo){
			$begdate = ($vo['endtime'] - $vo['begtime'])/86400;
			for($i=0;$i<$begdate;$i++){
				$enddate = strtotime(date("Y-m-d",strtotime(date("Y-m-d",$vo['begtime']) . "+" . $i . "days")));
				$room_num[$vo['roomid']][$enddate] += $vo['room_number']; 
			}
		}
		//var_dump($room_num);
		foreach($RoomRpArr as $m){ 
			foreach($newdate as $n){ 
				$room_N[$m['roomid']][$n] = 0;
				if($room_num[$m['roomid']][$n]){ 
					$room_N[$m['roomid']][$n] = $room_num[$m['roomid']][$n];
				}
			}
		}
		
		$this->assign("newdate",$newdate);
		$this->assign("NumArr",$NumArr);
		$this->assign("room_N",$room_N);
		$this->assign("begtime",$begtime);
		$this->assign("endtime",$endtime);
		
		$this->assign("RoomRpArr",$RoomRpArr1);
		$this->display("/Book/book_list");
	}
	
	public function GetCanderData(){
		$selRoom = $_GET['selRoom'];
		$RoomRp = M("room_rp")->where(array("id" => $selRoom))->find();
		$bfservice = json_decode($RoomRp['bfservice'],true);
		$pricerule = json_decode($RoomRp['pricerule'],true);
		$roomnum = $_GET['roomnum'];
		$tmp = 0;
		foreach($bfservice as $key=>$vo){
			if($key < 5){
				$tmp += $vo;
			}
		}
		$RoomRp['bfservice'] = $tmp;
		//房型id
		$roomtype = $_GET['roomtype'];
		//每个月的第一天
		$start = strtotime($_GET['start']);
		//住店到离店的时间
		$CheckI = strtotime($_GET['CheckI']);
		$CheckO = strtotime($_GET['CheckO']);
		
		$sta = date("Y-m-",$start);
		//每个月的最后一天
		$end = $_GET['end'];
		$tme = strtotime(date("Y-m-d",strtotime("$end -1 day")));
		$days = date("d",$tme);
		//当前日期时间戳
		$time = strtotime(date("Y-m-d",time()));
		//查询特殊价格条件
		$where['hotel_id'] = array("in",$roomtype);
		$where['ctime'] = array("egt",$time);
		$price = M("room_price")->where($where)->field("ctime,price")->select();
		//房型信息
		$roomM = $this->roomM->where(array("id"=>$roomtype,"iroom_status"=>1))->find();
		$now = date("d",$start);
		$now1 = preg_replace('/^0+/','',$now);
		if($RoomRp['pricetype'] == "-1"){
			if($RoomRp['reserveitem'] == "-4"){
				$time1 = date("Y-m-d",strtotime(date("Y-m-d",$CheckO) ."-".$pricerule[-7]."days"));
				for($i=0;$i<$pricerule[-7];$i++){
					$time2[] = strtotime(date("Y-m-d",strtotime($time1 . "+" . $i . "days")));
				}
			}
			
		}else{
			if($RoomRp['reserveitem'] == "4"){
				$time1 = date("Y-m-d",strtotime(date("Y-m-d",$CheckO) ."-".$pricerule[7]."days"));
				for($i=0;$i<$pricerule[7];$i++){
					$time2[] = strtotime(date("Y-m-d",strtotime($time1 . "+" . $i . "days")));
				}
			}
		}
		//判断是否加套餐价格
		if($selRoom == "-1"){
			foreach($price as $p){
				$pArr[$p['ctime']] = $p['price'];
			}
			for($i=0;$i<$days;$i++){
				$newdate[] = strtotime(date("Y-m-d",strtotime(date("Y-m-d",$start) . "+" . $i . "days")));
			}
			$RoomP = array();
			foreach($newdate as $n){
				$RoomP[$n] = $roomM['clevel_price0'];
				if($pArr[$n]){
					$RoomP[$n] = $pArr[$n];
					
				}
			}
			$Checktime = ($CheckO-$CheckI)/86400;
			for($i=0; $i<$Checktime;$i++){
				$Check[] = strtotime(date("Y-m-d",strtotime(date("Y-m-d",$CheckI) . "+" . $i . "days")));
			}
			foreach($Check as $n){
				$RoomD[$n] = $roomM['clevel_price0'];
				if($pArr[$n]){
					$RoomD[$n] = $pArr[$n];
					
				}
			}	
			$price1 = array_sum($RoomD);
			$price2 = $price1 * $roomnum;
		}else{
			foreach($price as $p){
				$pArr[$p['ctime']] = $p['price']+$RoomRp['bfservice'];
			}
			for($i=0;$i<$days;$i++){
				$newdate[] = strtotime(date("Y-m-d",strtotime(date("Y-m-d",$start) . "+" . $i . "days")));
			}
			$RoomP = array();
			foreach($newdate as $n){
				$price1 = $roomM['clevel_price0']+$RoomRp['bfservice'];
				$RoomP[$n] = $this->price($price1,$pricerule,$RoomRp['pricetype'],$RoomRp['reserveitem'],date("Y-m-d",$CheckI),date("Y-m-d",$CheckO),$bfservice[5],$n,$time2);
				if($pArr[$n]){
					$RoomP[$n] = $this->price($pArr[$n],$pricerule,$RoomRp['pricetype'],$RoomRp['reserveitem'],date("Y-m-d",$CheckI),date("Y-m-d",$CheckO),$bfservice[5],$n,$time2);
					
				}
			}
			$Checktime = ($CheckO-$CheckI)/86400;
			for($i=0; $i<$Checktime;$i++){
				$Check[] = strtotime(date("Y-m-d",strtotime(date("Y-m-d",$CheckI) . "+" . $i . "days")));
			}
			foreach($Check as $n){
				$price1 = $roomM['clevel_price0']+$RoomRp['bfservice'];
				$RoomD[$n] = $this->price($price1,$pricerule,$RoomRp['pricetype'],$RoomRp['reserveitem'],date("Y-m-d",$CheckI),date("Y-m-d",$CheckO),$bfservice[5],$n,$time2);
				if($pArr[$n]){
					$RoomD[$n] = $this->price($pArr[$n],$pricerule,$RoomRp['pricetype'],$RoomRp['reserveitem'],date("Y-m-d",$CheckI),date("Y-m-d",$CheckO),$bfservice[5],$n,$time2);
					
				}
			}	
			$price1 = array_sum($RoomD);
			$price2 = $price1 * $roomnum;
		
		}
		
		$Checktime = ($CheckO-$CheckI)/86400;
		for($i=0; $i<$Checktime;$i++){
			$Check[] = strtotime(date("Y-m-d",strtotime(date("Y-m-d",$CheckI) . "+" . $i . "days")));
		}	
		for($i=0;$i<$days;$i++){
			$newdate[] = strtotime(date("Y-m-d",strtotime(date("Y-m-d",$start) . "+" . $i . "days")));
		}
		$numArr = M("room_price")->where("hotel_id='".$roomtype."' and ctime >= '".$start."' and ctime <= '".strtotime($end)."' and type = 2")
		->field("ctime,room_num")
		->select();
		foreach($numArr as $n){ 
			$nArr[$n['ctime']] = $n['room_num'];
		}
		foreach($newdate as $n){ 
			$numb[$n] = $roomM['total_number'];
			if($nArr[$n] || $nArr[$n] === '0'){ 
				$numb[$n] = $nArr[$n];
			}
		}
		
		$order_num = M("order")
		->where("roomid='".$roomtype."' and ((begtime <= '".$start."' and endtime >= '".$start."') or (begtime > '".$start."' and begtime <= '".strtotime($end)."'))")
		->field("roomid,begtime,endtime,room_number")
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
			if($room_num[$t] >= $numb[$t] || $numb[$t] === '0'){
				$RoomP[$t] = 0;
			}
		}
		for($i=$now1;$i<=$days;$i++){
		$priceArr[]=array(
			"ChainID"=>1,
			"RoomTypeID"=>$roomM['id'],
			"RoomTypeName"=>$roomM['room_name'],
			"AccDate"=>$sta.$i." 00:00:00",
			"CheckInCount"=>7,
			"BookInCount"=>4,
			"StopSaleCount"=>0,
			"OTACount"=>0,
			"CanBook"=>1,
			"BaseRoomTypeID"=>2,
			"IsPre"=>0,
			"RoomCount"=>12,
			"Remark"=>"1.8米或2.0米(<22)",
			"LstRoomRate"=>array(
				array(
					"RoomRate"=>$RoomP[strtotime($sta.$i)],
					"ProRate"=>$RoomP[strtotime($sta.$i)],
					"RoomRateTypeID"=>1,
					"RoomRateTypeName"=>"门市价"
				),
				array(
					"RoomRate"=>$RoomP[strtotime($sta.$i)],
					"ProRate"=>$RoomP[strtotime($sta.$i)],
					"RoomRateTypeID"=>1,
					"RoomRateTypeName"=>"银会员价"
				),
				array(
					"RoomRate"=>$RoomP[strtotime($sta.$i)],
					"ProRate"=>$RoomP[strtotime($sta.$i)],
					"RoomRateTypeID"=>1,
					"RoomRateTypeName"=>"金会员价"
				),
				array(
					"RoomRate"=>$RoomP[strtotime($sta.$i)],
					"ProRate"=>$RoomP[strtotime($sta.$i)],
					"RoomRateTypeID"=>1,
					"RoomRateTypeName"=>"铂金会员价"
				),
				array(
					"RoomRate"=>$RoomP[strtotime($sta.$i)],
					"ProRate"=>$RoomP[strtotime($sta.$i)],
					"RoomRateTypeID"=>1,
					"RoomRateTypeName"=>"非会员首次预订价"
				),
				array(
					"RoomRate"=>$RoomP[strtotime($sta.$i)],
					"ProRate"=>$RoomP[strtotime($sta.$i)],
					"RoomRateTypeID"=>1,
					"RoomRateTypeName"=>"业主尊享会员价"
				),
			)
		);
	}
	//房型报价
	$resArr=array(
		"State"=>1,
		"ErrCode"=>200,
		"ErrMsg"=>"",
		"IsShowMsgToView"=>0,
		"Data"=>$priceArr,
		"aaa" => $price2
	);
	exit(json_encode($resArr));
	}

	function book_order(){
		if(IS_POST){
			
			$id = $_POST['id'];
			$CheckInDate = $_POST['CheckInDate'];
			$CheckOutDate = $_POST['CheckOutDate'];
			$selRooms = $_POST['selRooms'];
			$tbTel = $_POST['tbTel'];
			$tbName = $_POST['tbName'];
			$tbRemark = $_POST['tbRemark'];
			$sel = $_POST['sel'];
			$tbTotalDays = $_POST['tbTotalDays'];
			$array=array(
				"name" => $tbName
			);
			$days = (strtotime($CheckOutDate) - strtotime($CheckInDate))/86400;
			
			$roomM = $this->roomM->where(array("id"=>$id,"iroom_status"=>1))->find();
			//查询特殊房价
			$where['hotel_id'] = array("in",$id);
			$where['ctime'] = array("egt",strtotime($CheckInDate));
			$price = M("room_price")->where($where)->field("ctime,price")->select();
			$RoomRp = M("room_rp")->where(array("id" => $sel))->find();
			
			$pricerule = json_decode($RoomRp['pricerule'],true);
			$bfservice = json_decode($RoomRp['bfservice'],true);
			$tmp = 0;
			foreach($bfservice as $key=>$vo){
				if($key < 5){
					$tmp += $vo;
				}
			}
			
			$RoomRp['bfservice'] = $tmp;
			if($RoomRp['pricetype'] == "-1"){
				if($RoomRp['reserveitem'] == "-4"){
					$time1 = date("Y-m-d",strtotime($CheckOutDate ."-".$pricerule[-7]."days"));
					for($i=0;$i<$pricerule[-7];$i++){
						$time2[] = strtotime(date("Y-m-d",strtotime($time1 . "+" . $i . "days")));
					}
				}
				
			}else{
				if($RoomRp['reserveitem'] == "4"){
					$time1 = date("Y-m-d",strtotime($CheckOutDate ."-".$pricerule[7]."days"));
					for($i=0;$i<$pricerule[7];$i++){
						$time2[] = strtotime(date("Y-m-d",strtotime($time1 . "+" . $i . "days")));
					}
				}
			}
			if($sel == "-1"){
				foreach($price as $p){
					$pArr[$p['ctime']] = $p['price'];
				}
				for($i=0;$i<$days;$i++){
					$newdate[] = strtotime(date("Y-m-d",strtotime($CheckInDate . "+" . $i . "days")));
				}
				$RoomP = array();
				foreach($newdate as $n){
					$RoomP[$n] = $roomM['clevel_price0'];
					if($pArr[$n]){
						$RoomP[$n] = $pArr[$n];
						
					}
				}	
				$price1 = array_sum($RoomP);			
				$pay = $price1 * $selRooms;
			}else{
				foreach($price as $p){
					$pArr[$p['ctime']] = $p['price']+$RoomRp['bfservice'];
				}
				for($i=0;$i<$days;$i++){
					$newdate[] = strtotime(date("Y-m-d",strtotime($CheckInDate . "+" . $i . "days")));
				}
				$RoomP = array();
				foreach($newdate as $n){
					$price1 = $roomM['clevel_price0']+$RoomRp['bfservice'];
					$RoomP[$n] = $this->price($price1,$pricerule,$RoomRp['pricetype'],$RoomRp['reserveitem'],$CheckInDate,$CheckOutDate,$bfservice[5],$n,$time2);
					if($pArr[$n]){
						$RoomP[$n] = $this->price($pArr[$n],$pricerule,$RoomRp['pricetype'],$RoomRp['reserveitem'],$CheckInDate,$CheckOutDate,$bfservice[5],$n,$time2);
						
					}
				}
				$price2 = array_sum($RoomP);
				$pay = $price2 * $selRooms;
			
			}
			
			//查询特殊的房量
			$numArr = M("room_price")->where("hotel_id='".$id."' and ctime <= '".strtotime($CheckInDate)."' and ctime >= '".strtotime($CheckOutDate)."'")
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
			->where("roomid='".$id."' and ((begtime <= '".strtotime($CheckInDate)."' and endtime >= '".strtotime($CheckInDate)."') or (begtime > '".strtotime($CheckInDate)."' and begtime <= '".strtotime($CheckOutDate)."'))")
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
				$number = $room_num[$t] + $selRooms;
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
				"vipname" => json_encode($array),
				"vipphone" => $tbTel,
				"rpid" => $sel,
				"roomid" => $id,
				"amount" => $pay,
				"begtime" => strtotime($CheckInDate),
				"endtime" => strtotime($CheckOutDate),
				"yenum" => $tbTotalDays,
				"room_number" => $selRooms,
				"des" => $tbRemark,
				"created" => time(),
				"status" => 1,
				"type" => 2
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
			exit(json_encode($resArr));
		}
		
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
}


