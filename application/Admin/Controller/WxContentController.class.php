<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class WxContentController extends AdminbaseController{
	
	function _initialize() {
		parent::_initialize();
		$this->CONTENT = M("content");
	}

	function index(){

		$where_ands=array("isview=0 and content_type='keyword'");
		$fields=array(
				'title'=> array("field"=>"title","operator"=>"like"),
				'keyword'  => array("field"=>"keyword","operator"=>"like"),
				'type'  => array("field"=>"type","operator"=>"="),
		);
		if(IS_POST){
			foreach ($fields as $param =>$val){
				if (isset($_POST[$param]) && !empty($_POST[$param])) {
					$operator=$val['operator'];
					$field   =$val['field'];
					$get=$_POST[$param];
					$_GET[$param]=$get;
					if($operator=="like"){
						$get="%$get%";
					}
					array_push($where_ands, "$field $operator '$get'");
				}
			}
		}else{
			foreach ($fields as $param =>$val){
				if (isset($_GET[$param]) && !empty($_GET[$param])) {
					$operator=$val['operator'];
					$field   =$val['field'];
					$get=$_GET[$param];
					if($operator=="like"){
						$get="%$get%";
					}
					array_push($where_ands, "$field $operator '$get'");
				}
			}
		}
		
		$where= join(" and ", $where_ands);
		
		$count=$this->CONTENT->where($where)->count();
		$page = $this->page($count, 10);
		
		$lists=$this->CONTENT->join('ejd_users ON ejd_users.id = ejd_content.uid', 'LEFT')->where($where)->limit($page->firstRow . ',' . $page->listRows)->getField("ejd_content.id, ejd_users.user_nicename, title, pic_url, keyword, description, url, isview, created, updated");
		
		$this->assign("Page", $page->show('Admin'));
		$this->assign("formget",$_GET);
		$this->assign("List",$lists);
		$this->display();
	}

	function add(){
		$this->display();
	}
	
	public function edit(){
		$id=  I("get.id");
		
		$post=$this->CONTENT->where(array("id"=>$id))->find();
		$this->assign("post",$post);
		$this->display();
	}

	function add_post(){
		if (IS_POST) {
			if(empty($_POST['title']) && empty($_POST['price'])){
				$this->error("商品名称，价格不能为空！");
			}
			
			$data = array(
				"keyword" => $_POST["keyword"], 
				"type" => $_POST["type"], 
				"match_type" => $_POST["match_type"], 
				"title" => $_POST["title"], 
				"pic_url" => $_POST["pic_url"], 
				"description" => $_POST["description"], 
				"url" => $_POST["url"], 
				"isview" => $_POST["isview"]
			);	
			if(!empty($_POST["id"])){
				if($data['type'] == 1){
					$data['content'] = $_POST['content_info'];
				}else{
					$data['content'] = $_POST['content_text'];					
				}
				$data["updateuid"] = $_SESSION["ADMIN_ID"];
				$data["updated"] = time();
				$result = $this->CONTENT->where(array("id" => $_POST["id"]))->save($data);				
//				$result = $this->PRODUCT->where("id='" . $_POST["id"] . "'")->save($data);				
			}else{
				if($data['type'] == 1){
					$data['content'] = $_POST['content_info'];
				}else{
					$data['content'] = $_POST['content_text'];					
				}
				$data["id"] = gettableid("SC");
				$data["uid"] = $_SESSION["ADMIN_ID"];;
				$data["created"] = time();
				$result = $this->CONTENT->add($data);				
			}	
			if ($result) {
				$this->success("成功！");
			} else {
				$this->error("失败！");
			}
			 
		}
	}

    /**
     *  删除
     */
    public function delete() {
        $id = I("get.id");
        if ($this->CONTENT->where("id='" . $id . "'")->setField('isview','1')!==false) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
}
