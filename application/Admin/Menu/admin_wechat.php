<?php
return array (
  'app' => 'Admin',
  'model' => 'Wechat',
  'action' => 'default',
  'data' => '',
  'type' => '1',
  'status' => '1',
  'name' => '微信管理',
  'icon' => 'weixin',
  'remark' => '',
  'listorder' => '50',
  'children' => 
  array (
    array (
      'app' => 'Admin',
      'model' => 'Wechat',
      'action' => 'index',
      'data' => '',
      'type' => '1',
      'status' => '1',
      'name' => '微信菜单',
      'icon' => '',
      'remark' => '',
      'listorder' => '0',
    ),
    array (
      'app' => 'Admin',
      'model' => 'Wechat',
      'action' => 'wx_message',
      'data' => '',
      'type' => '1',
      'status' => '1',
      'name' => '微信留言',
      'icon' => '',
      'remark' => '',
      'listorder' => '0',
      'children' => 
      array (
        array (
          'app' => 'Admin',
          'model' => 'Wechat',
          'action' => 'message_post',
          'data' => '',
          'type' => '1',
          'status' => '0',
          'name' => '回复消息',
          'icon' => '',
          'remark' => '',
          'listorder' => '0',
        ),
        array (
          'app' => 'Admin',
          'model' => 'Wechat',
          'action' => 'wx_delete',
          'data' => '',
          'type' => '1',
          'status' => '0',
          'name' => '删除',
          'icon' => '',
          'remark' => '',
          'listorder' => '0',
        ),
      ),
    ),
    array (
      'app' => 'Admin',
      'model' => 'Shake',
      'action' => 'shake_list',
      'data' => '',
      'type' => '1',
      'status' => '1',
      'name' => '摇奖记录',
      'icon' => '',
      'remark' => '',
      'listorder' => '0',
    ),
    array (
      'app' => 'Admin',
      'model' => 'Shake',
      'action' => 'shake_prize',
      'data' => '',
      'type' => '1',
      'status' => '1',
      'name' => '中奖记录',
      'icon' => '',
      'remark' => '',
      'listorder' => '0',
    ),
    array (
      'app' => 'Admin',
      'model' => 'WxContent',
      'action' => 'index',
      'data' => '',
      'type' => '1',
      'status' => '1',
      'name' => '素材管理',
      'icon' => '',
      'remark' => '',
      'listorder' => '0',
      'children' => 
      array (
        array (
          'app' => 'Admin',
          'model' => 'WxContent',
          'action' => 'add_post',
          'data' => '',
          'type' => '1',
          'status' => '0',
          'name' => '添加',
          'icon' => '',
          'remark' => '',
          'listorder' => '0',
        ),
        array (
          'app' => 'Admin',
          'model' => 'WxContent',
          'action' => 'delete',
          'data' => '',
          'type' => '1',
          'status' => '0',
          'name' => '删除',
          'icon' => '',
          'remark' => '',
          'listorder' => '0',
        ),
        array (
          'app' => 'Admin',
          'model' => 'Wechat',
          'action' => 'setmenu',
          'data' => '',
          'type' => '1',
          'status' => '0',
          'name' => '设置菜单',
          'icon' => '',
          'remark' => '',
          'listorder' => '0',
        ),
      ),
    ),
  ),
);