<?php

namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class ShakeController extends AdminbaseController {

    protected $shake_list;

    function _initialize() {
        parent::_initialize();
        $this->shake_list = M("shake_list");
        $this->shake_prize = M("shake_prize");
    }

    //摇奖记录

    public function shake_list(){ 
    	//查询总数
        $count=$this->shake_list->count();
		//分页查询
    	$page = $this->page($count, 10);
    	$shake_list = $this->shake_list->join("ejd_fans on ejd_fans.id = ejd_shake_list.openid","left")->field("ejd_shake_list.*,ejd_fans.nickname,ejd_fans.headimgurl")
    	->limit($page->firstRow . ',' . $page->listRows)
    	->select();
    	$this->assign("page",$page->show("Admin"));
    	$this->assign("shake_list",$shake_list);
    	$this->display();
    }
    //中奖记录
    public function shake_prize(){ 
    	//查询总数
        $count=$this->shake_prize->count();
		//分页查询
    	$page = $this->page($count, 10);
    	$shake_prize = $this->shake_prize->join("ejd_fans on ejd_fans.id = ejd_shake_prize.openid","left")->field("ejd_shake_prize.*,ejd_fans.nickname,ejd_fans.headimgurl")
    	->limit($page->firstRow . ',' . $page->listRows)
    	->order("status desc")
    	->select();
    	$this->assign("page",$page->show("Admin"));
    	$this->assign("shake_prize",$shake_prize);
    	$this->display();
    }
    
}

