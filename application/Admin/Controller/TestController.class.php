<?php

/**
 * 后台首页
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class TestController extends AdminbaseController {
	
	function _initialize() {
	    empty($_GET['upw'])?"":session("__SP_UPW__",$_GET['upw']);//设置后台登录加密码	    
		parent::_initialize();
		$this->initMenu();
	}
	
    /**
     * 后台框架首页
     */
    public function index() {
    	$this->error("这里错啦");
        
    }

}

