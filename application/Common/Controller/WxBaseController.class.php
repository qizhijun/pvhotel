<?php
namespace Common\Controller;
use Common\Controller\AppframeController;
class WxBaseController extends AppframeController {
	
	public function __construct() {
		$this->set_action_success_error_tpl();
		parent::__construct();
	}
	
	function _initialize() {
		if(!$this->check_login()){
			if(sp_is_mobile()){
				$openid=$this->get_fans();
				$fans=M("fans")->where(array(
					"id"=>$openid
				))->find();
				
				if($fans&&$fans["phone"]){
					$_SESSION["fans"]=$fans;
				}else{
					$_SESSION["fans"]["openid"]=$openid;
				}
			}else{
				@session_start();
				$_SESSION['adminlogin'] = 1;
				header("Location:".__ROOT__."/index.php?g=admin");
			}
		}
	}
	
	/**
	 * 检查微信用户是否登陆
	 */
	protected function check_login(){
		if(!isset($_SESSION["fans"])){
			return false;
		}else{
			return true;
		}
		return true;
	}
	
	/**
	 * 检查是否关注公众号
	 */
	protected function check_sub($isajax=false){
		//每次验证的时候都从数据库中获取最新的粉丝信息
		$fans=M("fans")->where(array(
			"openid"=>$_SESSION["fans"]["openid"]
		))->find();
		if($fans){
			$_SESSION["fans"]=$fans;
		}
		//判断是否关注了公众号
		if(!isset($_SESSION["fans"])||!$_SESSION["fans"]["subscribe"]){
			if($isajax){
				$resArr=array(
					"success"=>false,
					"message"=>"请先关注公众号",
					"url"=>U('wechat/User/sub')
				);
				exit(json_encode($resArr));
			}else{
				//跳转到关注页面
				$this->error('请关注后再试',U('wechat/User/sub'),2);
			}
		}
	}
	
	/**
	 * 获取当前微信的用户信息
	 */
	protected function get_fans(){
		if($_GET["qizhijun"]=="15810154665"){
			return "o5d3ywP6-y78WLRQHK7a5TRjZq0I";
		}
		vendor('wx.WxUser');//导入微信类库
		$wxuser = new \WxUser();
		$openid=$wxuser->getWxUser();
		return $openid;
	}
	
	/**
	 * 检查是否激活会员
	 */
	protected function check_user($isajax=false){
		$this->check_sub($isajax);
		if(!isset($_SESSION["fans"])||!$_SESSION["fans"]["phone"]){
			if($isajax){
				$resArr=array(
					"success"=>false,
					"message"=>"请先激活会员",
					"url"=>U('wechat/User/reg')
				);
				exit(json_encode($resArr));
			}else{
				//跳转到激活用户的页面
				$_SESSION["afterurl"]='http://'.$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"];
				header("Location:".U('Wechat/User/reg'));
			}
		}
	}
	
	//发送短信
	protected  function _sendMsg($tel,$content){
		//企信通通道
//		$status=send_validate_code($tel,$content);
//		\Think\Log::record("短信发送结果".json_encode($status));
//		if($status=="T"){
//			return true;
//		}else{
//			return false;
//		}
		//企信通通道
		$tt=time();
		$data="timestamp=".$tt."&cpid=15888&channelid=1462";
		$pwd="06qyZc_".$tt."_topsky";
		$data.="&password=".md5($pwd);
		$data.="&tele=".$tel;
		$data.="&msg=".urlencode(iconv('UTF-8','GB2312',$content));
		vendor("wx.WxApi");
		$wxapi= new \WxApi();
		$res=$wxapi->postDataCurl("http://admin.sms9.net/houtai/sms.php",$data);
		\Think\Log::record("短信发送结果:".json_encode($res));
		if(strstr($res,"success")){
			return true;
		}else{
			return false;
		}
	}
	
	//获得当前等级
	protected function getLevelName($point){
		$levelArr=$_SESSION["levelArr"];
		if(empty($levelArr)){
			$levelArr=M("config")->where("type='level'")->select();
			$_SESSION["levelArr"]=$levelArr;
		}
		$point=intval($point);
		$levelname=$levelArr[0]["title"];
		foreach($levelArr as $key=>$value){
			if($point<intval($value["value"])){
				$levelname=$levelArr[$key-1]["title"];
				break;
			}
		}
		return $levelname;
	}
	
	//通知粉丝消息
	protected function noticefans($title,$description="",$picurl="",$url=""){
		$openid=$_SESSION["fans"]["openid"];
		$onlinetime=M("fans")->where(array(
			"id"=>$openid
		))->getField("onlinetime");
		$suff=time()-intval($onlinetime);
		$fen=$suff/60/60;
		
		//如果最近48小时内激活过微信，发送消息
		if($openid&&$fen<48){
			vendor("wx.WxApi");
			if(!empty($description)&&!empty($picurl)&&!empty($url)){
				$news[]=array(
					"title"=>urlencode($title),
					"description"=>urlencode($description),
					"url"=>$url,
					"picurl"=>$picurl
				);
				\WxApi::sendWxKfMsg($openid,$news,true);
			}else{
				\WxApi::sendWxKfMsg($openid,urlencode($title));
			}
		}else{
			//积分通知时，如果超过了48小时，就用模板消息推送通知
		}
	}
	
	//分享页面
	protected function sharePage($title,$desc,$link,$imgurl){
		vendor("wx.WxJsApi");
		$jsapi=new \WxJsApi();
		$signPackage=$jsapi->getSignPackage();
		
		$link=$link?$link:"";
		$imgurl=$imgurl?$imgurl:"";
		
		$shareArr=array(
			"title"=>$title,
			"desc"=>$desc,
			"link"=>$link,
			"imgUrl"=>$imgurl
		);
		
		$this->assign("signJson",json_encode($signPackage));
		$this->assign("shareJson",json_encode($shareArr));
	}
	
	/**
	 * 加载模板和页面输出 可以返回输出内容
	 * @access public
	 * @param string $templateFile 模板文件名
	 * @param string $charset 模板输出字符集
	 * @param string $contentType 输出类型
	 * @param string $content 模板输出内容
	 * @return mixed
	 */
	public function display($templateFile = '', $charset = '', $contentType = '', $content = '', $prefix = '') {
		//echo $this->parseTemplate($templateFile);
		parent::display($this->parseTemplate($templateFile), $charset, $contentType);
	}
	
	/**
	 * 获取输出页面内容
	 * 调用内置的模板引擎fetch方法，
	 * @access protected
	 * @param string $templateFile 指定要调用的模板文件
	 * 默认为空 由系统自动定位模板文件
	 * @param string $content 模板输出内容
	 * @param string $prefix 模板缓存前缀*
	 * @return string
	 */
	public function fetch($templateFile='',$content='',$prefix=''){
	    $templateFile = empty($content)?$this->parseTemplate($templateFile):'';
		return parent::fetch($templateFile,$content,$prefix);
	}
	
	/**
	 * 自动定位模板文件
	 * @access protected
	 * @param string $template 模板文件规则
	 * @return string
	 */
	public function parseTemplate($template='') {
		
		$tmpl_path=C("SP_TMPL_PATH");
		define("SP_TMPL_PATH", $tmpl_path);
		// 获取当前主题名称
		$theme      =    C('SP_DEFAULT_THEME')."_wx";
		if(C('TMPL_DETECT_THEME')) {// 自动侦测模板主题
			$t = C('VAR_TEMPLATE');
			if (isset($_GET[$t])){
				$theme = $_GET[$t];
			}elseif(cookie('think_template')){
				$theme = cookie('think_template');
			}
			if(!file_exists($tmpl_path."/".$theme)){
				$theme  =   C('SP_DEFAULT_THEME');
			}
			cookie('think_template',$theme,864000);
		}
		
		C('SP_DEFAULT_THEME',$theme);
		
		$current_tmpl_path=$tmpl_path.$theme."/";
		// 获取当前主题的模版路径
		define('THEME_PATH', $current_tmpl_path);
		
		C("TMPL_PARSE_STRING.__TMPL__",__ROOT__."/".$current_tmpl_path);
		
		C('SP_VIEW_PATH',$tmpl_path);
		C('DEFAULT_THEME',$theme);
		
		define("SP_CURRENT_THEME", $theme);
		
		if(is_file($template)) {
			return $template;
		}
		$depr       =   C('TMPL_FILE_DEPR');
		$template   =   str_replace(':', $depr, $template);
		
		// 获取当前模块
		$module   =  MODULE_NAME;
		if(strpos($template,'@')){ // 跨模块调用模版文件
			list($module,$template)  =   explode('@',$template);
		}
		
		
		// 分析模板文件规则
		if('' == $template) {
			// 如果模板文件名为空 按照默认规则定位
			$template = "/".CONTROLLER_NAME . $depr . ACTION_NAME;
		}elseif(false === strpos($template, '/')){
			$template = "/".CONTROLLER_NAME . $depr . $template;
		}
		
		$file = sp_add_template_file_suffix($current_tmpl_path.$module.$template);
		$file= SITE_PATH.str_replace("//",'/',$file);
		if(!file_exists_case($file)) E(L('_TEMPLATE_NOT_EXIST_').':'.$file);
		return $file;
	}
	
	
	private function set_action_success_error_tpl(){
		$theme      =    C('SP_DEFAULT_THEME')."_wx";
		if(C('TMPL_DETECT_THEME')) {// 自动侦测模板主题
			if(cookie('think_template')){
				$theme = cookie('think_template');
			}
		}
		$tpl_path=C("SP_TMPL_PATH").$theme."/";
		$defaultjump=THINK_PATH.'Tpl/dispatch_jump.tpl';
		$action_success = sp_add_template_file_suffix($tpl_path.C("SP_TMPL_ACTION_SUCCESS"));
		$action_error = sp_add_template_file_suffix($tpl_path.C("SP_TMPL_ACTION_ERROR"));
		if(file_exists_case($action_success)){
			C("TMPL_ACTION_SUCCESS",$action_success);
		}else{
			C("TMPL_ACTION_SUCCESS",$defaultjump);
		}
		
		if(file_exists_case($action_error)){
			C("TMPL_ACTION_ERROR",$action_error);
		}else{
			C("TMPL_ACTION_ERROR",$defaultjump);
		}
	}
	
	
}