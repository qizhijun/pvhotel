<?php
namespace Demo\Controller;
use Common\Controller\HomebaseController;

class IndexController extends HomebaseController{
	
	function index(){
		$pwd='###7e898672182297088164a2bf3aa9547a';
		echo sp_password("diangu2016");
		echo "hello";
	}
}
