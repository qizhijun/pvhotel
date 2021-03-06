<?php
return array (
  'app' => 'User',
  'model' => 'Indexadmin',
  'action' => 'default',
  'data' => '',
  'type' => '1',
  'status' => '1',
  'name' => '会员管理',
  'icon' => 'group',
  'remark' => '',
  'listorder' => '20',
  'children' => 
  array (
    array (
      'app' => 'User',
      'model' => 'WxAdmin',
      'action' => 'index',
      'data' => '',
      'type' => '1',
      'status' => '1',
      'name' => '微信粉丝',
      'icon' => '',
      'remark' => '',
      'listorder' => '0',
    ),
    array (
      'app' => 'User',
      'model' => 'Indexadmin',
      'action' => 'index',
      'data' => '',
      'type' => '1',
      'status' => '1',
      'name' => '网站会员',
      'icon' => 'leaf',
      'remark' => '',
      'listorder' => '0',
      'children' => 
      array (
        array (
          'app' => 'User',
          'model' => 'Indexadmin',
          'action' => 'ban',
          'data' => '',
          'type' => '1',
          'status' => '0',
          'name' => '拉黑会员',
          'icon' => '',
          'remark' => '',
          'listorder' => '0',
        ),
        array (
          'app' => 'User',
          'model' => 'Indexadmin',
          'action' => 'cancelban',
          'data' => '',
          'type' => '1',
          'status' => '0',
          'name' => '启用会员',
          'icon' => '',
          'remark' => '',
          'listorder' => '0',
        ),
      ),
    ),
  ),
);