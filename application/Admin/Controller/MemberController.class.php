<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class MemberController extends AdminbaseController{
	
	protected $member_model;
	
	function _initialize() {
		parent::_initialize();
		$this->member_model = M("member");
	}
	
	function index(){
//		$status=$_GET["status"];
		$where="status=0 and isdel = 0";
		$keyname=$_GET['keyname']=$_REQUEST["keyname"];
		if($keyname){
			$this->assign("keyname",$keyname);
			$where.=" and (name like '%".$keyname."%' or postname like '%".$keyname."%' or phone like '%".$keyname."%')";
		}
		
//		if($status==1){
//			$where="status=1";
//			$yishen="class='active'";
//		}else{
//			$weishen="class='active'";
//		}
		$count=$this->member_model->where($where)->count();
		$page = $this->page($count, 20);
		$members = $this->member_model
		->where($where)
		->order("created DESC")
		->limit($page->firstRow . ',' . $page->listRows)
		->select();
		
		$this->assign("page", $page->show('Admin'));
		$this->assign("members",$members);
		$this->assign("count",$count);
//		$this->assign("yishen",$yishen);
//		$this->assign("weishen",$weishen);
		$this->display();
	}
	
	function yishen(){
		$where="status=1 and isdel = 0";
		$keyname=$_GET['keyname']=$_REQUEST["keyname"];
		if($keyname){
			$this->assign("keyname",$keyname);
			$where.=" and (name like '%".$keyname."%' or postname like '%".$keyname."%' or phone like '%".$keyname."%')";
		}
		$count=$this->member_model->where($where)->count();
		$page = $this->page($count, 20);
		$members = $this->member_model
		->where($where)
		->order("created DESC")
		->limit($page->firstRow . ',' . $page->listRows)
		->select();
		
		$this->assign("count",$count);
		$this->assign("page", $page->show('Admin'));
		$this->assign("members",$members);
		$this->display();
	}
	
	function edit(){
		$id=trim($_GET["id"]);
		if(empty($id)){
			$this->error("员工编号不能为空");
		}
		
		$member=$this->member_model
		->find($id);
		
		$this->assign("member",$member);
		$this->display();
	}
	
	function delete(){
		$id=trim($_GET["id"]);
		$isdel=trim($_GET["isdel"]);
		if(empty($id)){
			$this->error("员工编号不能为空");
		}
		
		$res=$this->member_model
		->where(array("id"=>$id))
		->save(array(
			"postname"=>$postname,
			"isdel"=>$isdel
		));
		
		if($res){
			$this->success("操作成功");
		}else{
			$this->error("操作失败");
		}
	}
	
	function edit_post(){
		$id=$_POST["id"];
		$postname=trim($_POST["postname"]);
		$status=trim($_POST["status"]);
		
		$res=$this->member_model
		->where(array("id"=>$id))
		->save(array(
			"postname"=>$postname,
			"status"=>$status
		));
		//查询当前员工
		$member=$this->member_model->find($id);
		
		\Think\Log::record("员工信息：".json_encode($member));
		vendor("wx.WxTemplate");
		if($res){
			if($status){
				$mes="您好，员工认证信息审核通过";
			}else{
				$mes="您好，员工认证信息已失效";
			}
			//推送微信通知，提醒审核通过
			$res=\WxTemplate::checkMsg($member["openid"],"",$mes,$member["phone"],$member["postname"],"感谢您的使用");
			\Think\Log::record("消息推送结果：".json_encode($res));
			$this->success("操作成功！", U("member/yishen"));
		}else{
			$res=\WxTemplate::checkMsg($member["openid"],"","您好，员工信息失效",$member["phone"],$member["postname"],"感谢您的使用");
			\Think\Log::record("消息推送结果：".json_encode($res));
			$this->error("操作失败！");
		}
	}
}