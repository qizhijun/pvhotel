<?php
namespace Wechat\Controller;
use Common\Controller\WxBaseController; 
/**
 * 首页
 */
class IndexController extends WxBaseController {
	
	
	function _initialize() {
		parent::_initialize();
	}
	//微官网
	public function index() {
		$this->display();
	}
	//本地天气
	public function tianqi(){
		$this->display();
	}
	//全国天气
	public function Chinatianqi(){
		$this->display();
	}
	//巧媳妇洗衣
	public function pictorial(){
		$this->display();
	}
	//优惠促销
	public function xinwen(){
		$this->display();
	}
	
	//微信评论
	public function wx_message(){
		$wechat_message = M("wx_message")->join('ejd_fans on ejd_fans.id = ejd_wx_message.openid',"left")->where("ejd_wx_message.status = 0")->order("ejd_wx_message.id desc")->field("ejd_fans.nickname,ejd_fans.headimgurl,ejd_wx_message.*")->select();
		$this->assign("wechat_message",$wechat_message);
		$this->display();
	}
	//添加微信评论
	public function message_post(){
		if(IS_POST){
			$openid = $_SESSION['fans']['openid'] ? $_SESSION['fans']['openid'] : $_SESSION['fans']['id'];
			if($openid){
				$data = array(
					"openid" => $openid,
					"content" => $_POST['info'],
					"status" => 0,
					"created" => time()
				);
				$message = M("wx_message")->add($data);
				if($message){
					$resArr = array(
						"success" => true,
						"msg" => "留言成功！"
					);
				}else{
					$resArr = array(
						"success" => false,
						"msg" => "留言失败！"
					);
				}
				exit(json_encode($resArr));
			}
		}
		
	}
	//酒店相册
	public function photo(){
		$photoArr = M("pic")->join("ejd_dict on ejd_dict.id = ejd_pic.aid","left")->where("ejd_pic.isdel = 0")->field("ejd_pic.*,ejd_dict.name")->select();
		$this->assign("photoArr",$photoArr);
		$this->display();
	}
	//酒店相册详情页
	public function photo_img(){
		$id = I("get.id");
		$photoArr = M("pic")->where("id=".$id)->find();
		$photourl = json_decode($photoArr['picurl'],true);
		$this->assign("photourl",$photourl);
		$this->assign("photoArr",$photoArr);
		$this->display();
	}
}
