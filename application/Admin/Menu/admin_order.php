<?php
return array (
  'app' => 'Admin',
  'model' => 'Order',
  'action' => 'default',
  'data' => '',
  'type' => '1',
  'status' => '1',
  'name' => '订单管理',
  'icon' => 'list',
  'remark' => '',
  'listorder' => '10',
  'children' => 
  array (
    array (
      'app' => 'Admin',
      'model' => 'Order',
      'action' => 'kflist',
      'data' => '',
      'type' => '1',
      'status' => '1',
      'name' => '客房订单',
      'icon' => '',
      'remark' => '',
      'listorder' => '0',
    ),
    array (
      'app' => 'Admin',
      'model' => 'Order',
      'action' => 'cylist',
      'data' => '',
      'type' => '1',
      'status' => '1',
      'name' => '餐饮订单',
      'icon' => '',
      'remark' => '',
      'listorder' => '0',
    ),
    array (
      'app' => 'Admin',
      'model' => 'Order',
      'action' => 'xyyllist',
      'data' => '',
      'type' => '1',
      'status' => '1',
      'name' => '休闲娱乐订单',
      'icon' => '',
      'remark' => '',
      'listorder' => '0',
    ),
    array (
      'app' => 'Admin',
      'model' => 'Order',
      'action' => 'hyyhlist',
      'data' => '',
      'type' => '1',
      'status' => '1',
      'name' => '会议宴会问询',
      'icon' => '',
      'remark' => '',
      'listorder' => '0',
    ),
  ),
);