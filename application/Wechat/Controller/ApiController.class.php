<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace Wechat\Controller;
use Common\Controller\AppframeController; 
/**
 * 首页
 */
class ApiController extends AppframeController {
	
	private $wxapi;
	private $openid="";
	private $wxid="";
	private $mfocus;
	private $news;
	
	public function __construct(){
		vendor('wx.WxApi');//导入微信类库
		$this->wxapi= new \WxApi();
		$this->mfocus=M("fans");
		$this->news=array();
	}
	
    //首页
	public function index() {
		$this->wxapi->validUrl("diangu");
		\Think\Log::record("开始获取内容");
		$wxData=$this->wxapi->responseMsg();
		\Think\Log::record($wxData->FromUserName);
		//处理用户请求
		if($wxData){
			$this->openid=strval($wxData->FromUserName);//用户微信号
			$this->wxid=strval($wxData->ToUserName);//当前微信编号
			$msgtype=strval($wxData->MsgType);//消息类型
			$event=strval($wxData->Event);//事件类型
			$eventkey=strval($wxData->EventKey);//事件关键字
			$content=$wxData->Content;
			\Think\Log::record($content);
			
			//修改当前粉丝的活跃时间
			$this->mfocus->where(array(
				"id"=>$this->openid
			))->save(array(
				"onlinetime"=>time()
			));
			
			if($msgtype=="event"){//事件处理
				if($event=="subscribe"){//关注
					$canid=str_replace("qrscene_","",$eventkey);
					$this->subscribe($canid);
				}elseif($event=="unsubscribe"){//取消关注
					$this->unsubscribe();
				}elseif($event=="LOCATION"){//上报地址
					$this->location($wxData);
				}elseif($event=="CLICK"){//自定义菜单点击事件
					$this->click($eventkey);
				}elseif($event=="VIEW"){//自定义菜单浏览事件
					$this->view($eventkey);
				}elseif($event=="SCAN"){//已经关注再次扫描
					$this->scan($eventkey,false);
				}elseif($event=="poi_check_notify"){//门店添加成功
					$UniqId=strval($wxData->UniqId);
					$PoiId=strval($wxData->PoiId);
					$Result=strval($wxData->Result);
					\Think\Log::record("微信门店回调".$UniqId."||".$PoiId."||".$Result,'WARN');
					$this->addCompany($UniqId,$PoiId,$Result);
				}
			}elseif($msgtype=="text"){//文本消息
				$this->message($content);
			}else{//图片，语音，视频，小视频，地理位置，链接信息的处理
				//image,voice，video，shortvideo，location，link
			}
		}
		exit();
    }
	
	//关注处理
	private function subscribe($canid){
		\Think\Log::record("开始关注",'WARN');
		$focus=$this->mfocus->where("id='".$this->openid."'")->find();
		
		//获取用户的基本信息，昵称头像等
		$focusInfo=$this->wxapi->getFocusInfo($this->openid);
		\Think\Log::record(json_encode($focusInfo));
		
		//赋值
		$focusData["nickname"]=urlencode($focusInfo["nickname"]);
		$focusData["sex"]=$focusInfo["sex"]==1?"男":"女";
		$focusData["headimgurl"]=$focusInfo["headimgurl"];
		$focusData["country"]=$focusInfo["country"];
		$focusData["province"]=$focusInfo["province"];
		$focusData["city"]=$focusInfo["city"];
		$focusData["subscribe_time"]=$focusInfo["subscribe_time"];
		$focusData["subscribe"]=1;
		$focusData["unionid"]=$focusInfo["unionid"];
		
		//保存粉丝信息
		if($focus["id"]){//修改
			$this->mfocus->where("id='".$this->openid."'")->save($focusData);
			//如果有详细信息，说明以前关注过，如果没有，说明之前只是获得过积分，没有关注过
			if($focus["nickname"]){
				$messagetxt="感谢您再次关注";
			}
			$this->scan($canid,FALSE);
		}else{//新增
			$focusData["id"]=$this->openid;
			$focusData["created"]=time();
			\Think\Log::record("保存前".json_encode($focusData),'WARN');
			$this->mfocus->add($focusData);
			$this->scan($canid);
		}
		
		//后面处理同扫面渠道二维码
		
	}
	
	//取消关注
	private function unsubscribe(){
		\Think\Log::record("开始取消".$this->openid,'WARN');
		$this->mfocus->where(array(
			"id"=>$this->openid
		))->save(array(
			"subscribe"=>0
		));
	}
	
	//消息触发
	private function message($keyword){
		$content=M("content")
		->where("keyword='$keyword' and content_type='keyword' and isview=0 ")
		->find();
		\Think\Log::record("查询对应内容".json_encode($content),'WARN');
		//判断消息类型
		if($content){
			if($content["type"]=="1"){//图文消息
				$news=array(
					"title"=>$content["title"],
					"description"=>$content["description"],
					"pic_url"=>"http://".$_SERVER['HTTP_HOST'].$content["pic_url"]
				);
				if($content["content"]){
					$news["url"]=$_SERVER['HTTP_HOST']."/index.php?g=Admin&m=public&a=message_info&id=" . $content['id'];
				}elseif($content["url"]){
					$news["url"]=$content["url"];
				}
				echo $this->wxapi->newstpl($this->openid,$this->wxid,$news);
			}elseif($content["type"]=="0"){//文本消息
				echo $this->wxapi->texttpl($this->openid,$this->wxid,$content["content"]);
			}
		}else{
			echo $this->wxapi->texttpl($this->openid,$this->wxid,"感谢咨询，我们会尽快回复");
		}
	}
	
	//添加咖啡厅
	private function addCompany($UniqId,$PoiId,$Result){
		if($Result=="succ"){
			//修改当前店面信息已经成为微信店面
			M("shop_infos",null)->where(array(
				"shop_id"=>$UniqId
			))->save(array(
				"wx_wifi_status"=>1,
				"wx_shop_id"=>$PoiId
			));
		}else{
			//使微信店面信息可再次提交
			M("shop_infos",null)->where(array(
				"shop_id"=>$UniqId
			))->save(array(
				"wx_issub"=>0
			));
		}
	}
	
	//自定义菜单点击
	private function click($eventkey){
		
	}
	
	//上报地址
	private function location($wxData){
		
	}
	
	//关注后扫描
	private function scan($eventkey,$flag=true){
		/*
		//保存关系
		$shopid=$this->saveRelation($eventkey);
		
		//活动内容
		$this->setActivity($flag);

		//获取wifi信息
		$password=$this->getWifi($shopid);
		
		//活动消息
		$this->sendMessage();
		
		$message="";
		if($password){
			$message=$password;
		}

		echo $this->wxapi->texttpl($this->openid,$this->wxid,$message);
		*/
	}
	
	/**
	 * 保存粉丝于咖啡厅的关系,获取店面编号
	 */
	private function saveRelation($canid){
		\Think\Log::record("扫描的二维码的渠道号:".$canid);
		//保存粉丝与门店之间的关系
		if($canid){//如果通道号存在
			$qrcodeinfo=M("qrcode")->where("id=$canid and isdel=0")->find();
			\Think\Log::record("扫描的二维码".json_encode($qrcodeinfo));
			if($qrcodeinfo){
				$qshopid=$qrcodeinfo["shop_id"];
				$shopfocusM=M("shop_focus");
				$one=$shopfocusM->where(array(
					"shop_id"=>$qshopid,
					"focus_id"=>$this->openid
				))->find();
				\Think\Log::record("二维码和当前用户的关系".json_encode($one));
				if(empty($one)){
					//添加到数据库，使用replace参数
					$shopfocusM->add(array(
						"shop_id"=>$qshopid,
						"focus_id"=>$this->openid
					));
				}
				
				//查询店面详情推送消息
				$shopInfo=M("shop_infos",null)->alias("info")
				->field("sh.id,sh.name,info.app_head_img,info.shop_name")
				->join("left join shops sh on sh.id=info.shop_id")
				->where("info.shop_id='$qshopid'")->find();
				\Think\Log::record("二维码对应的咖啡店".json_encode($shopInfo));
				if($shopInfo){
					$shopname=empty($shopInfo["shop_name"])?$shopInfo["name"]:$shopInfo["shop_name"];
					$url="http://wx.kafeibang.com/index.php?g=wechat&m=shop&a=p_shopinfo&id=".$qshopid;
					$headimg=empty($shopInfo["app_head_img"])?"tpl/simplebootx_wx/Public/images/img-max-ceshi.jpg":$shopInfo["app_head_img"];
					
					$this->news[]=array(
						"title"=>urlencode($shopname." 欢迎您"),
						"description"=>urlencode("点击查看详情"),
						"url"=>$url,
						"picurl"=>"http://wx.kafeibang.com/".$headimg
					);
				}
			}else{
				$count = M("bd_focus")->where("focus_id = '" . $this->openid . "'")->count();
				$fcount = $this->mfocus->where("id = '" . $this->openid . "' and subscribe = '0'")->count();
				$is_old = ($fcount > 0) ? "1" : "0";
				if($count == 0){
					M("bd_focus")->add(array(
						"qrcode_id" => $canid, 
						"focus_id" => $this->openid, 
						"is_old" => $is_old
					));
				}
				$qshopid = "";
			}
		}
		return $qshopid;
	}

	/**
	 * 获取店面wifi信息
	 */
	private function getWifi($shopid){
		if($shopid){
			$wifiArr=M("shop_wifi")->where(array(
				"shop_id"=>$shopid
			))->select();
			foreach($wifiArr as $val){
				$wifinameArr[]=$val["ssid"];
			}
			
			//存在wifi的话
			if(count($wifiArr)>0){
				$wifinames=implode(",",$wifinameArr);
				//本店wifi信息
				$act=array(
					"title"=>urlencode("上网请连接 ".$wifinames." ,密码如下️⬇️"),
					"description"=>urlencode(""),
					"url"=>"http://wx.kafeibang.com/index.php?g=wechat&m=shop&a=p_shopinfo&id=".$shopid,
					"picurl"=>"http://wx.kafeibang.com/tpl/simplebootx_wx/Public/images/wifi.png"
				);
				$this->news[]=$act;
				return $wifiArr[0]["password"];
			}else{
				return "暂无配置wifi信息";
			}
		}
	}

	/**
	 * 设置活动内容
	 */
	private function setActivity($flag){
		if($flag){
			//送挂耳活动
			$act=array(
				"title"=>urlencode("恭喜您获得一袋挂耳咖啡"),
				"description"=>urlencode("点击查看详情"),
				"url"=>"http://wx.kafeibang.com/Wechat/Help/guaer"
			);
			if(count($this->news)>0){//用小图
				$act["picurl"]="http://wx.kafeibang.com/tpl/simplebootx_wx/Public/images/guaerkafei.png";
			}else{//用大图
				$act["picurl"]="http://wx.kafeibang.com/tpl/simplebootx_wx/Public/images/guaerkafeibig.png";
			}
			
			$this->news[]=$act;
		}
		//请咖啡流程
		$act=array(
			"title"=>urlencode("互联网+咖啡厅社交神器"),
			"description"=>urlencode("点击查看详情"),
			"url"=>"http://wx.kafeibang.com/Wechat/Help/qing"
		);
		if(count($this->news)>0){//用小图
			$act["picurl"]="http://wx.kafeibang.com/tpl/simplebootx_wx/Public/images/qing.png";
		}else{//用大图
			$act["picurl"]="http://wx.kafeibang.com/tpl/simplebootx_wx/Public/images/qingbig.png";
		}
		$this->news[]=$act;
	}
	
	/**
	 * 推送消息
	 */
	private function sendMessage(){
		if(count($this->news)){
			vendor("wx.WxApi");
			\WxApi::sendWxKfMsg($this->openid,$this->news,true);
		}
	}

}


