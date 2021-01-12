<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Common\Controller\AdminbaseController; 
/**
 * 首页
 */
class TtController extends AdminbaseController {
	
    public function index(){
    	vendor('wx.WxApi');
		$filename = "Uploads/img/".time().".jpg";
		\WxApi::downImg("gEmw20vOxKtpD02-aYuZ_4XiA4jMR67tIn_LjFP7XK1UDLAawg80B1N19r1eTJbS",$filename);
    }
}


