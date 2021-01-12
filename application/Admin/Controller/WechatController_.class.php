<?php

/**
 * Menu(菜单管理)
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class WechatController extends AdminbaseController {

    protected $menu_model;

    function _initialize() {
        parent::_initialize();
        $this->menu_model = M("public_menu");
    }

    /**
     *  显示菜单
     */
    public function index() {
    	$_SESSION['admin_menu_index']="Wechat/index";
        $result = $this->menu_model->order(array("listorder" => "ASC"))->select();
        import("Tree");
        $tree = new \Tree();
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        
        $newmenus=array();
        foreach ($result as $m){
        	$newmenus[$m['id']]=$m;
        	 
        }
        foreach ($result as $n=> $r) {
        	
        	$result[$n]['level'] = $this->_get_level($r['id'], $newmenus);
        	$result[$n]['parentid_node'] = ($r['parentid']) ? ' class="child-of-node-' . $r['parentid'] . '"' : '';
        	
			if($r['parentid']>0){
	            $result[$n]['str_manage'] = '<a target="_blank" href="' . U("Wechat/edit", array("id" => $r['id'], "menuid" => $_GET['menuid'])) . '">修改</a> | <a class="js-ajax-delete" href="' . U("Wechat/delete", array("id" => $r['id'], "menuid" => I("get.menuid")) ). '">删除</a> ';
	            $result[$n]['status'] = $r['status'] ? "显示" : "隐藏";
	            if(APP_DEBUG){
	            	$result[$n]['app']=$r['app']."/".$r['model']."/".$r['action'];
	            }
			}else{
	            $result[$n]['str_manage'] = '<a href="' . U("Wechat/add", array("parentid" => $r['id'], "menuid" => $_GET['menuid'])) . '">添加子菜单</a> | <a target="_blank" href="' . U("Wechat/edit", array("id" => $r['id'], "menuid" => $_GET['menuid'])) . '">修改</a> | <a class="js-ajax-delete" href="' . U("Wechat/delete", array("id" => $r['id'], "menuid" => I("get.menuid")) ). '">删除</a> ';
	            $result[$n]['status'] = $r['status'] ? "显示" : "隐藏";
	            if(APP_DEBUG){
	            	$result[$n]['app']=$r['app']."/".$r['model']."/".$r['action'];
	            }
			}
        }

        $tree->init($result);
        $str = "<tr id='node-\$id' \$parentid_node>
					<td style='padding-left:20px;'><input name='listorders[\$id]' type='text' size='3' value='\$listorder' class='input input-order'></td>
					<td>\$id</td>
					<td>\$spacer\$name</td>
        			<td>\$url</td>
        			<td>\$keyword</td>
				    <td>\$status</td>
					<td>\$str_manage</td>
				</tr>";
        $categorys = $tree->get_tree(0, $str);
        $this->assign("categorys", $categorys);
        $this->display();
    }
    
    /**
     * 获取菜单深度
     * @param $id
     * @param $array
     * @param $i
     */
    protected function _get_level($id, $array = array(), $i = 0) {
    
    	if ($array[$id]['parentid']==0 || empty($array[$array[$id]['parentid']]) || $array[$id]['parentid']==$id){
    		return  $i;
    	}else{
    		$i++;
    		return $this->_get_level($array[$id]['parentid'],$array,$i);
    	}
    
    }
    
    public function lists(){
    	$_SESSION['admin_menu_index']="Wechat/lists";
    	$result = $this->menu_model->order(array("app" => "ASC","model" => "ASC","action" => "ASC"))->select();
    	$this->assign("menus",$result);
    	$this->display();
    }

    /**
     *  添加
     */
    public function add() {
    	import("Tree");
    	$tree = new \Tree();
    	$parentid = intval(I("get.parentid"));
    	$result = $this->menu_model->where(array("parentid" => 0, "status" => 1))->order(array("listorder" => "ASC"))->select();
    	foreach ($result as $r) {
    		$r['selected'] = $r['id'] == $parentid ? 'selected' : '';
    		$array[] = $r;
    	}
    	$str = "<option value='\$id' \$selected>\$spacer \$name</option>";
    	$tree->init($array);
    	$count = $this->menu_model->where(array("parentid" => 0, "status" => 1))->count();
		if($count < 3){
	    	$select_categorys = '<option value="0">作为一级菜单</option>';
		}
    	$select_categorys .= $tree->get_tree(0, $str);
    	$this->assign("select_categorys", $select_categorys);
    	$this->display();
    }
    
    /**
     *  添加
     */
    public function add_post() {
    	if (IS_POST) {
    		if ($this->menu_model->create()) {
		        $keyword = intval(I("post.keyword"));
		        $url = intval(I("post.url"));
				if(!empty($keyword) && !empty($url)){
					$this->error("关键字和链接不能同时存在！");
				}
    			if ($this->menu_model->add()!==false) {
    				$to=empty($_SESSION['admin_menu_index'])?"Wechat/index":$_SESSION['admin_menu_index'];
    				$this->success("添加成功！", U($to));
    			} else {
    				$this->error("添加失败！");
    			}
    		} else {
    			$this->error($this->menu_model->getError());
    		}
    	}
    }

    /**
     *  删除
     */
    public function delete() {
        $id = intval(I("get.id"));
        $count = $this->menu_model->where(array("parentid" => $id))->count();
        if ($count > 0) {
            $this->error("该菜单下还有子菜单，无法删除！");
        }
        if ($this->menu_model->delete($id)!==false) {
            $this->success("删除菜单成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    /**
     *  编辑
     */
    public function edit() {
        import("Tree");
        $tree = new \Tree();
        $id = intval(I("get.id"));
        $rs = $this->menu_model->where(array("id" => $id))->find();
        $result = $this->menu_model->where("parentid = 0 and id != $id")->order(array("listorder" => "ASC"))->select();
        foreach ($result as $r) {
        	$r['selected'] = $r['id'] == $rs['parentid'] ? 'selected' : '';
        	$array[] = $r;
        }
        $str = "<option value='\$id' \$selected>\$spacer \$name</option>";
        $tree->init($array);
    	$select_categorys = '<option value="0">作为一级菜单</option>';
        $select_categorys .= $tree->get_tree(0, $str);
        $this->assign("data", $rs);
        $this->assign("select_categorys", $select_categorys);
        $this->display();
    }
    
    /**
     *  编辑
     */
    public function edit_post() {
    	if (IS_POST) {
    		if ($this->menu_model->create()) {
		        $id = intval(I("id"));
				$pid = $this->menu_model->where("id = $id")->getField("parentid");
				if($pid == 0 || $_POST['parentid'] == 0){
			    	$count = $this->menu_model->where("parentid = 0 and id != $id and status = 1")->count();
					if($count >= 3){
						$this->error("微信主菜单不能超过3个！");
					}
				}
		        $keyword = intval(I("post.keyword"));
		        $url = intval(I("post.url"));
				if(!empty($keyword) && !empty($url)){
					$this->error("关键字和链接不能同时存在！");
				}
    			if ($this->menu_model->save() !== false) {
    				$this->success("更新成功！");
    			} else {
    				$this->error("更新失败！");
    			}
    		} else {
    			$this->error($this->menu_model->getError());
    		}
    	}
    }

    //排序
    public function listorders() {
        $status = parent::_listorders($this->menu_model);
        if ($status) {
            $this->success("排序更新成功！");
        } else {
            $this->error("排序更新失败！");
        }
    }
    
    //生成为微信菜单
    public function setmenu() {
        $result = $this->menu_model->where(array("status" => 1))->order(array("listorder" => "ASC"))->field("id, parentid, name, keyword, url")->select();
		$button = array();
		foreach($result as $value){
			if($value['parentid'] == 0){
				$sub_button = array();
				foreach($result as $val){
					if($val['parentid'] == $value['id']){
						if(!empty($val['url'])){
							$sub_button[] = array(
								"name" => urlencode($val['name']), 
								"url" => htmlspecialchars_decode($val['url']), 
								"type" => "view"
							);
						}else{
							$sub_button[] = array(
								"name" => urlencode($val['name']), 
								"key" => urlencode($val['keyword']), 
								"type" => "click"
							);
						}
					}
				}
				if(count($sub_button) > 0){
					$button[] = array(
						"sub_button" =>	$sub_button, 
						"name" => urlencode($value['name']),
					);
				}else{
					if(!empty($value['url'])){
						$button[] = array(
							"name" => urlencode($value['name']),
							"url" => htmlspecialchars_decode($value['url']), 
							"type" => "view"
						);
					}else{
						$button[] = array(
							"name" => urlencode($value['name']), 
							"key" => urlencode($value['keyword']), 
							"type" => "click"
						);
					}
				}
			}
		}
		$list = array("button" => $button);
		vendor("wx.WxApi");
		$res=\WxApi::setMenu($list);
		\Think\Log::record(json_encode($res),'WARN');
		$resArr = json_decode($res[1],true);
        if ($resArr && $resArr['errcode'] == 0) {
            $this->success("菜单更新成功！");
        } else {
            $this->error("菜单更新失败！");
        }
		
//		{"errcode":0,"errmsg":"ok"}
    }

	public function getWechat(){
//		查询菜单的方法：
		vendor("wx.WxApi");
		$res=\WxApi::getMenu($menuArr);
//		$res即使菜单结果json
		$Wechat = json_decode($res, TRUE);
		$this->assign("Wechat", $Wechat);
		$this->display();
	}
    
}

