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
class ImportController extends AdminbaseController {
	
	private $data_modal;
	private $customer;
	
	function _initialize() {
		parent::_initialize();
		$this->data_modal=M("salary_file");
	}
	
    //查询导入批次
	public function index() {
		$where=array(
			"isdel"=>0
		);
    	$count=$this->data_modal->where($where)->count();
    	$page = $this->page($count, 20);
		
    	$lists = $this->data_modal
    	->where($where)
    	->order("id DESC")
    	->limit($page->firstRow . ',' . $page->listRows)
    	->select();
		
    	$this->assign('lists', $lists);
    	$this->assign("page", $page->show('Admin'));
		$this->display();
    }
	
	public function info(){
		$id=$_GET["id"];
		if($id){
			$file=$this->data_modal->find($id);
			
			$this->assign("fileinfo",$file);
			$this->display();
		}else{
			$this->error("选择要查看批次");
		}
	}

	public function detail(){
		$id=$_GET["id"];
		if($id){
			$data=M("salary_list");
			$count=$data->where(["fileid"=>$id])->count();
	        $page = $this->page($count, 15);
	        $dataList=$data->where(["fileid"=>$id])
	        	->limit($page->firstRow . ',' . $page->listRows)
	        	->select();

			$this->assign("dataList", $dataList);
			$this->assign("id", $id);
			$this->display();
		}else{
			$this->error("数据错误");
		}
	}
	
	/**
	 * 发送通知
	 */
	public function sendNotice(){
		$salarylistM=M("salary_list");
		$fileid=$_GET["id"];
		
		if(empty($fileid)){
			$resArr=array(
				"success"=>false
			);
			exit(json_encode($resArr));
		}
		//查询所有工资及要发送人的列表
		$salarylist=$salarylistM->alias("esl")
		->field("esl.*,em.postname,em.openid,em.name")
		->join("ejd_member em on em.phone=esl.phone","left")
		->where("esl.fileid='".$fileid."' and em.status=1 and em.isdel=0")
		->select();
		
		\Think\Log::record(json_encode($salarylist));
		//筛选有效的工资数据
		foreach($salarylist as $value){
			if(!empty($value["openid"])){
				$sendArr[]=$value;
			}
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
			//发过通知的编号
			$modifyId[]=$value["id"];
		}
		
		//修改发送状态
		if(!empty($modifyId)){
			$idstr=implode(",",$modifyId);
			$salarylistM->where("id in (".$idstr.")")->save(array(
				"gettime"=>time()
			));
			$this->data_modal->where(array("id"=>$fileid))->save(array(
				"status"=>1
			));
		}
		
		$resArr=array(
			"success"=>true,
			"message"=>$_GET["id"]
		);
		exit(json_encode($resArr));
	}
	
	//导入数据
	public function importSave(){
		if(IS_POST){
			$id=$_POST["id"];
			if($id){
				$file=$this->data_modal->find($id);
				if($file&&$file["status"]==0&&$file["fileurl"]){
					//解析文件
					$resArr=$this->readdata($file["id"],$file["fileurl"]);
					if(count($resArr["dataarr"])>0){//文件中有值
						\Think\Log::record(json_encode($resArr["dataarr"]),'WARN');
						$row=M("data_list")->addAll($resArr["dataarr"]);
						if($row){
							$this->data_modal->where(array(
								"id"=>$id
							))->save(array(
								"status"=>1,
								"importtime"=>time()
							));
							if($_POST['sendtime']==1){
								sp_import_fans_data($id);
							}
							$this->success("导入成功",U("import/index"));
						}
					}else{
						$this->error("文件中没有正确的数据，无法导入。");
					}
				}else{
					$this->error("数据已经导入，无法重复操作");
				}
			}else{
				$this->error("选择要导入的数据");
			}
		}else{
			$this->error("操纵错误");
		}
	}
	
	public function delete(){
		$id=$_GET["id"];
		if($id){
			$row=$this->data_modal->where(array(
				"id"=>$id
			))->save(array(
				"isdel"=>1
			));
			if($row){
				$this->success("删除成功");
			}else{
				$this->error("删除失败");
			}
		}else{
			$this->error("选择要查看批次");
		}
	}
	
	//上传页面
	public function upfile(){
		
		$this->display();
	}
	
	//保存导入文件
	public function upload(){
		$upload = new \Think\Upload();// 实例化上传类
	    $upload->maxSize   =     3145728 ;// 设置附件上传大小
	    $upload->exts      =     array('xls', 'xlsx');// 设置附件上传类型
	    $upload->rootPath  =     './data/upload/'; // 设置附件上传根目录
	    $upload->savePath  =     ''; // 设置附件上传（子）目录
	    // 上传文件 
	    $info   =   $upload->upload();
	    if(!$info) {// 上传错误提示错误信息
	        $this->error($upload->getError());
	    }else{// 上传成功
	        
	        $file=$info["filename"];
	        $newfile="data/upload/".$file['savepath'].$file['savename'];
			//解析文件
			$resArr=$this->readdata(0,$newfile);
			\Think\Log::record(json_encode($resArr),'WARN');
			//如果导入行数为0，导入失败
			if($resArr["total"]==0){
				$this->error("文件中无数据");
			}else{
				//准备数据
				$data=array(
					"title"=>$file["name"],
					"mon"=>$_POST["mon"],
					"fileurl"=>$newfile,
					"created"=>time(),
					"status"=>0,
					"linenum"=>$resArr["total"],
					"rightnum"=>intval($resArr["total"])-count($resArr["errData"]),
					"isdel"=>0
				);
				$row=$this->data_modal->add($data);
				if($row){
					$data["id"]=$row;
					//保存导入的数据
					$sarayArr=$resArr["dataarr"];
					foreach($sarayArr as $key=>$value){
						$sarayArr[$key]["fileid"]=$row;
					}
					M("salary_list")->addAll($sarayArr);//批量保存工资明细
					
					$this->success("导入成功",U("import/index",array("id"=>$row)));
				}else{
					$this->error("上传文件失败");
				}
			}
	    }
	}
	
	//解析数据
	private function readdata($dataid,$fileurl){
        vendor("PHPExcel.PHPExcel");
		$objReader = \PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load($fileurl,$encode='utf-8');
		
		$sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumn = $sheet->getHighestColumn(); // 取得总列数
        
        //此处应该检查模版是否正确
        
        //查重复
        for($i=2;$i<=$highestRow;$i++){
        	
        	$mon=$objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue();
			$name=$objPHPExcel->getActiveSheet()->getCell("B".$i)->getValue();
			$phone=$objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue();
			$bumen=$objPHPExcel->getActiveSheet()->getCell("D".$i)->getValue();
			$biaozhun=$objPHPExcel->getActiveSheet()->getCell("E".$i)->getValue();
			$jineng=$objPHPExcel->getActiveSheet()->getCell("F".$i)->getValue();
			$jiabanfei=$objPHPExcel->getActiveSheet()->getCell("G".$i)->getValue();
			$kaohe=$objPHPExcel->getActiveSheet()->getCell("H".$i)->getValue();
			$duzifei=$objPHPExcel->getActiveSheet()->getCell("I".$i)->getValue();
			$gudingjintie=$objPHPExcel->getActiveSheet()->getCell("J".$i)->getValue();
			$bancibuzhu=$objPHPExcel->getActiveSheet()->getCell("K".$i)->getValue();
			$shijia=$objPHPExcel->getActiveSheet()->getCell("L".$i)->getValue();
			$bingshijia=$objPHPExcel->getActiveSheet()->getCell("M".$i)->getValue();
			$qita=$objPHPExcel->getActiveSheet()->getCell("N".$i)->getValue();
			$yingfa=$objPHPExcel->getActiveSheet()->getCell("O".$i)->getCalculatedValue();
			$yanglao=$objPHPExcel->getActiveSheet()->getCell("P".$i)->getValue();
			$shiye=$objPHPExcel->getActiveSheet()->getCell("Q".$i)->getValue();
			$yiliao=$objPHPExcel->getActiveSheet()->getCell("R".$i)->getValue();
			$gongjijin=$objPHPExcel->getActiveSheet()->getCell("S".$i)->getValue();
			$geshui=$objPHPExcel->getActiveSheet()->getCell("T".$i)->getValue();
			$qitakoukuan=$objPHPExcel->getActiveSheet()->getCell("U".$i)->getValue();
			$shifa=$objPHPExcel->getActiveSheet()->getCell("V".$i)->getCalculatedValue();
			
			if($phone&&strlen(trim($phone))==11){
				if(in_array($phone, $phoneArr)){//重复的手机号
	        		$reData[]=array(
						"line"=>$i,
						"phone"=>$phone
					);
	        	}else{
	        		$phoneArr[]=$phone;
					$data=array(
						"mon"=>$mon,
						"name"=>$name,
						"phone"=>$phone,
						"bumen"=>$bumen,
						"biaozhun"=>$biaozhun,
						"jineng"=>$jineng,
						"jiabanfei"=>$jiabanfei,
						"kaohe"=>$kaohe,
						"duzifei"=>$duzifei,
						"gudingjintie"=>$gudingjintie,
						"bancibuzhu"=>$bancibuzhu,
						"shijia"=>$shijia,
						"bingshijia"=>$bingshijia,
						"qita"=>$qita,
						"yingfa"=>$yingfa,
						"yanglao"=>$yanglao,
						"shiye"=>$shiye,
						"yiliao"=>$yiliao,
						"gongjijin"=>$gongjijin,
						"geshui"=>$geshui,
						"qitakoukuan"=>$qitakoukuan,
						"shifa"=>$shifa,
					);
					$dataArr[]=$data;
	        	}
			}else{//错误手机号
				$error[]=array(
					"line"=>$i,
					"phone"=>$phone
				);
			}
        }
		
		$resArr=array(
			"total"=>$highestRow-1,
			"reData"=>$reData,
			"errData"=>$error,
			"dataarr"=>$dataArr
		);
		
		return $resArr;
	}
}


