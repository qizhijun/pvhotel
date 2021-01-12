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
class ImportController extends HomebaseController {
	
	/**
	 * 发送通知
	 */
	public function sendNotice(){
		$salarylistM=M("salary_list");
		$file = M('salary_file')->where("isdel = 0 and status=2")->order("id desc")->find();
		//查询所有工资及要发送人的列表
		$salarylist=$salarylistM->alias("esl")
		->field("esl.*,em.postname,em.openid,em.name")
		->join("ejd_member em on em.phone=esl.phone","left")
		->where("esl.fileid = '".$file['id']."' and em.status=1 and em.isdel=0 and esl.is_status = 0")
		->limit("10")
		->select();

		\Think\Log::record(json_encode($salarylist));
		//筛选有效的工资数据
		foreach($salarylist as $value){
			if(!empty($value["openid"])){
				$sendArr[]=$value;
			}
		}
		if(!$sendArr){
            M('salary_file')->where(array("id"=>$file['id']))->save(array(
                "status"=>1,
            ));
            exit("success");
        }
		\Think\Log::record("要发送的人：".json_encode($sendArr));
		//发送通知的处理
		vendor("wx.WxTemplate");
		foreach($sendArr as $value){
			$openid=$value["openid"];
			$url="http://diangu.yijiudian.cn/".U("Wechat/salary/index",array("id"=>$value["id"]));
			$name=$value["name"];
			$month=$value["mon"];
			$yingfa=$value["yingfa"];
			$shifa=$value["shifa"];
			$res=\WxTemplate::salaryMsg($openid,$url,$name."，您的工资已经发放完毕",$month."月份",$yingfa."元",$shifa."元","0元","0元","注：五险一金不在本页面显示，如果疑问，请联系人力资源部");
			\Think\Log::record("发送结果：".json_encode($res));
			if($res[0]==200){
				$resArr=json_decode($res[1],true);
				if($resArr["errcode"]==0){
					$modifyOne[]=$value["id"];
				}else{
					$modifyTwo[]=$value["id"];
				}
			}
			\Think\Log::record("发送通知的编号：".json_encode($modifyId));
            sleep(1);
		}
		
		//修改发送状态
		if(!empty($modifyOne)){
			$idstr=implode(",",$modifyOne);
			$data = array(
				"gettime"=>time(),
				"is_status" =>1
			);
			$salarylistM->where("id in (".$idstr.")")->save($data);
		}
		if(!empty($modifyTwo)){
			$idstrs=implode(",",$modifyTwo);
			$data1 = array(
				"gettime"=>time(),
				"is_status" =>2
			);
			$salarylistM->where("id in (".$idstrs.")")->save($data1);
		}
		
		$resArr=array(
			"success"=>true,
			"message"=>"成功"
		);
		exit(json_encode($resArr));
	}	
}


