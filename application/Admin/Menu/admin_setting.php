<?php
return array (
  'app' => 'Admin',
  'model' => 'Setting',
  'action' => 'default',
  'data' => '',
  'type' => '0',
  'status' => '1',
  'name' => '设置',
  'icon' => 'cogs',
  'remark' => '',
  'listorder' => '0',
  'children' => 
  array (
    array (
      'app' => 'Admin',
      'model' => 'Setting',
      'action' => 'userdefault',
      'data' => '',
      'type' => '0',
      'status' => '1',
      'name' => '个人信息',
      'icon' => '',
      'remark' => '',
      'listorder' => '0',
      'children' => 
      array (
        array (
          'app' => 'Admin',
          'model' => 'User',
          'action' => 'userinfo',
          'data' => '',
          'type' => '1',
          'status' => '1',
          'name' => '修改信息',
          'icon' => '',
          'remark' => '',
          'listorder' => '0',
          'children' => 
          array (
            array (
              'app' => 'Admin',
              'model' => 'User',
              'action' => 'userinfo_post',
              'data' => '',
              'type' => '1',
              'status' => '0',
              'name' => '修改信息提交',
              'icon' => '',
              'remark' => '',
              'listorder' => '0',
            ),
          ),
        ),
        array (
          'app' => 'Admin',
          'model' => 'Setting',
          'action' => 'password',
          'data' => '',
          'type' => '1',
          'status' => '1',
          'name' => '修改密码',
          'icon' => '',
          'remark' => '',
          'listorder' => '0',
          'children' => 
          array (
            array (
              'app' => 'Admin',
              'model' => 'Setting',
              'action' => 'password_post',
              'data' => '',
              'type' => '1',
              'status' => '0',
              'name' => '提交修改',
              'icon' => '',
              'remark' => '',
              'listorder' => '0',
            ),
          ),
        ),
      ),
    ),
    array (
      'app' => 'Admin',
      'model' => 'Setting',
      'action' => 'site',
      'data' => '',
      'type' => '1',
      'status' => '1',
      'name' => '网站信息',
      'icon' => '',
      'remark' => '',
      'listorder' => '1',
      'children' => 
      array (
        array (
          'app' => 'Admin',
          'model' => 'Setting',
          'action' => 'site_post',
          'data' => '',
          'type' => '1',
          'status' => '0',
          'name' => '提交修改',
          'icon' => '',
          'remark' => '',
          'listorder' => '0',
        ),
        array (
          'app' => 'Admin',
          'model' => 'Route',
          'action' => 'index',
          'data' => '',
          'type' => '1',
          'status' => '0',
          'name' => '路由列表',
          'icon' => '',
          'remark' => '',
          'listorder' => '0',
        ),
        array (
          'app' => 'Admin',
          'model' => 'Route',
          'action' => 'add',
          'data' => '',
          'type' => '1',
          'status' => '0',
          'name' => '路由添加',
          'icon' => '',
          'remark' => '',
          'listorder' => '0',
          'children' => 
          array (
            array (
              'app' => 'Admin',
              'model' => 'Route',
              'action' => 'add_post',
              'data' => '',
              'type' => '1',
              'status' => '0',
              'name' => '路由添加提交',
              'icon' => '',
              'remark' => '',
              'listorder' => '0',
            ),
          ),
        ),
        array (
          'app' => 'Admin',
          'model' => 'Route',
          'action' => 'edit',
          'data' => '',
          'type' => '1',
          'status' => '0',
          'name' => '路由编辑',
          'icon' => '',
          'remark' => '',
          'listorder' => '0',
          'children' => 
          array (
            array (
              'app' => 'Admin',
              'model' => 'Route',
              'action' => 'edit_post',
              'data' => '',
              'type' => '1',
              'status' => '0',
              'name' => '路由编辑提交',
              'icon' => '',
              'remark' => '',
              'listorder' => '0',
            ),
          ),
        ),
        array (
          'app' => 'Admin',
          'model' => 'Route',
          'action' => 'delete',
          'data' => '',
          'type' => '1',
          'status' => '0',
          'name' => '路由删除',
          'icon' => '',
          'remark' => '',
          'listorder' => '0',
        ),
        array (
          'app' => 'Admin',
          'model' => 'Route',
          'action' => 'ban',
          'data' => '',
          'type' => '1',
          'status' => '0',
          'name' => '路由禁止',
          'icon' => '',
          'remark' => '',
          'listorder' => '0',
        ),
        array (
          'app' => 'Admin',
          'model' => 'Route',
          'action' => 'open',
          'data' => '',
          'type' => '1',
          'status' => '0',
          'name' => '路由启用',
          'icon' => '',
          'remark' => '',
          'listorder' => '0',
        ),
        array (
          'app' => 'Admin',
          'model' => 'Route',
          'action' => 'listorders',
          'data' => '',
          'type' => '1',
          'status' => '0',
          'name' => '路由排序',
          'icon' => '',
          'remark' => '',
          'listorder' => '0',
        ),
      ),
    ),
    array (
      'app' => 'Admin',
      'model' => 'Menu',
      'action' => 'index',
      'data' => '',
      'type' => '1',
      'status' => '1',
      'name' => '功能管理',
      'icon' => '',
      'remark' => '',
      'listorder' => '2',
      'children' => 
      array (
        array (
          'app' => 'Admin',
          'model' => 'Menu',
          'action' => 'add',
          'data' => '',
          'type' => '1',
          'status' => '0',
          'name' => '添加菜单',
          'icon' => '',
          'remark' => '',
          'listorder' => '0',
          'children' => 
          array (
            array (
              'app' => 'Admin',
              'model' => 'Menu',
              'action' => 'add_post',
              'data' => '',
              'type' => '1',
              'status' => '0',
              'name' => '提交添加',
              'icon' => '',
              'remark' => '',
              'listorder' => '0',
            ),
          ),
        ),
        array (
          'app' => 'Admin',
          'model' => 'Menu',
          'action' => 'listorders',
          'data' => '',
          'type' => '1',
          'status' => '0',
          'name' => '后台菜单排序',
          'icon' => '',
          'remark' => '',
          'listorder' => '0',
        ),
        array (
          'app' => 'Admin',
          'model' => 'Menu',
          'action' => 'export_menu',
          'data' => '',
          'type' => '1',
          'status' => '0',
          'name' => '菜单备份',
          'icon' => '',
          'remark' => '',
          'listorder' => '1000',
        ),
        array (
          'app' => 'Admin',
          'model' => 'Menu',
          'action' => 'edit',
          'data' => '',
          'type' => '1',
          'status' => '0',
          'name' => '编辑菜单',
          'icon' => '',
          'remark' => '',
          'listorder' => '1000',
          'children' => 
          array (
            array (
              'app' => 'Admin',
              'model' => 'Menu',
              'action' => 'edit_post',
              'data' => '',
              'type' => '1',
              'status' => '0',
              'name' => '提交编辑',
              'icon' => '',
              'remark' => '',
              'listorder' => '0',
            ),
          ),
        ),
        array (
          'app' => 'Admin',
          'model' => 'Menu',
          'action' => 'delete',
          'data' => '',
          'type' => '1',
          'status' => '0',
          'name' => '删除菜单',
          'icon' => '',
          'remark' => '',
          'listorder' => '1000',
        ),
        array (
          'app' => 'Admin',
          'model' => 'Menu',
          'action' => 'lists',
          'data' => '',
          'type' => '1',
          'status' => '0',
          'name' => '所有菜单',
          'icon' => '',
          'remark' => '',
          'listorder' => '1000',
        ),
      ),
    ),
    array (
      'app' => 'User',
      'model' => 'Indexadmin',
      'action' => 'default3',
      'data' => '',
      'type' => '1',
      'status' => '1',
      'name' => '管理组',
      'icon' => '',
      'remark' => '',
      'listorder' => '3',
      'children' => 
      array (
        array (
          'app' => 'Admin',
          'model' => 'Rbac',
          'action' => 'index',
          'data' => '',
          'type' => '1',
          'status' => '1',
          'name' => '角色管理',
          'icon' => '',
          'remark' => '',
          'listorder' => '0',
          'children' => 
          array (
            array (
              'app' => 'Admin',
              'model' => 'Rbac',
              'action' => 'member',
              'data' => '',
              'type' => '1',
              'status' => '0',
              'name' => '成员管理',
              'icon' => '',
              'remark' => '',
              'listorder' => '1000',
            ),
            array (
              'app' => 'Admin',
              'model' => 'Rbac',
              'action' => 'authorize',
              'data' => '',
              'type' => '1',
              'status' => '0',
              'name' => '权限设置',
              'icon' => '',
              'remark' => '',
              'listorder' => '1000',
              'children' => 
              array (
                array (
                  'app' => 'Admin',
                  'model' => 'Rbac',
                  'action' => 'authorize_post',
                  'data' => '',
                  'type' => '1',
                  'status' => '0',
                  'name' => '提交设置',
                  'icon' => '',
                  'remark' => '',
                  'listorder' => '0',
                ),
              ),
            ),
            array (
              'app' => 'Admin',
              'model' => 'Rbac',
              'action' => 'roleedit',
              'data' => '',
              'type' => '1',
              'status' => '0',
              'name' => '编辑角色',
              'icon' => '',
              'remark' => '',
              'listorder' => '1000',
              'children' => 
              array (
                array (
                  'app' => 'Admin',
                  'model' => 'Rbac',
                  'action' => 'roleedit_post',
                  'data' => '',
                  'type' => '1',
                  'status' => '0',
                  'name' => '提交编辑',
                  'icon' => '',
                  'remark' => '',
                  'listorder' => '0',
                ),
              ),
            ),
            array (
              'app' => 'Admin',
              'model' => 'Rbac',
              'action' => 'roledelete',
              'data' => '',
              'type' => '1',
              'status' => '1',
              'name' => '删除角色',
              'icon' => '',
              'remark' => '',
              'listorder' => '1000',
            ),
            array (
              'app' => 'Admin',
              'model' => 'Rbac',
              'action' => 'roleadd',
              'data' => '',
              'type' => '1',
              'status' => '1',
              'name' => '添加角色',
              'icon' => '',
              'remark' => '',
              'listorder' => '1000',
              'children' => 
              array (
                array (
                  'app' => 'Admin',
                  'model' => 'Rbac',
                  'action' => 'roleadd_post',
                  'data' => '',
                  'type' => '1',
                  'status' => '0',
                  'name' => '提交添加',
                  'icon' => '',
                  'remark' => '',
                  'listorder' => '0',
                ),
              ),
            ),
          ),
        ),
        array (
          'app' => 'Admin',
          'model' => 'User',
          'action' => 'index',
          'data' => '',
          'type' => '1',
          'status' => '1',
          'name' => '管理员',
          'icon' => '',
          'remark' => '',
          'listorder' => '0',
          'children' => 
          array (
            array (
              'app' => 'Admin',
              'model' => 'User',
              'action' => 'ban',
              'data' => '',
              'type' => '1',
              'status' => '0',
              'name' => '禁用管理员',
              'icon' => '',
              'remark' => '',
              'listorder' => '0',
            ),
            array (
              'app' => 'Admin',
              'model' => 'User',
              'action' => 'cancelban',
              'data' => '',
              'type' => '1',
              'status' => '0',
              'name' => '启用管理员',
              'icon' => '',
              'remark' => '',
              'listorder' => '0',
            ),
            array (
              'app' => 'Admin',
              'model' => 'User',
              'action' => 'delete',
              'data' => '',
              'type' => '1',
              'status' => '0',
              'name' => '删除管理员',
              'icon' => '',
              'remark' => '',
              'listorder' => '1000',
            ),
            array (
              'app' => 'Admin',
              'model' => 'User',
              'action' => 'edit',
              'data' => '',
              'type' => '1',
              'status' => '0',
              'name' => '管理员编辑',
              'icon' => '',
              'remark' => '',
              'listorder' => '1000',
              'children' => 
              array (
                array (
                  'app' => 'Admin',
                  'model' => 'User',
                  'action' => 'edit_post',
                  'data' => '',
                  'type' => '1',
                  'status' => '0',
                  'name' => '编辑提交',
                  'icon' => '',
                  'remark' => '',
                  'listorder' => '0',
                ),
              ),
            ),
            array (
              'app' => 'Admin',
              'model' => 'User',
              'action' => 'add',
              'data' => '',
              'type' => '1',
              'status' => '0',
              'name' => '管理员添加',
              'icon' => '',
              'remark' => '',
              'listorder' => '1000',
              'children' => 
              array (
                array (
                  'app' => 'Admin',
                  'model' => 'User',
                  'action' => 'add_post',
                  'data' => '',
                  'type' => '1',
                  'status' => '0',
                  'name' => '添加提交',
                  'icon' => '',
                  'remark' => '',
                  'listorder' => '0',
                ),
              ),
            ),
          ),
        ),
      ),
    ),
    array (
      'app' => 'Admin',
      'model' => 'Backup',
      'action' => 'default',
      'data' => '',
      'type' => '1',
      'status' => '1',
      'name' => '备份管理',
      'icon' => '',
      'remark' => '',
      'listorder' => '4',
      'children' => 
      array (
        array (
          'app' => 'Admin',
          'model' => 'Backup',
          'action' => 'restore',
          'data' => '',
          'type' => '1',
          'status' => '1',
          'name' => '数据还原',
          'icon' => '',
          'remark' => '',
          'listorder' => '0',
        ),
        array (
          'app' => 'Admin',
          'model' => 'Backup',
          'action' => 'index',
          'data' => '',
          'type' => '1',
          'status' => '1',
          'name' => '数据备份',
          'icon' => '',
          'remark' => '',
          'listorder' => '0',
          'children' => 
          array (
            array (
              'app' => 'Admin',
              'model' => 'Backup',
              'action' => 'index_post',
              'data' => '',
              'type' => '1',
              'status' => '0',
              'name' => '提交数据备份',
              'icon' => '',
              'remark' => '',
              'listorder' => '0',
            ),
          ),
        ),
        array (
          'app' => 'Admin',
          'model' => 'Backup',
          'action' => 'download',
          'data' => '',
          'type' => '1',
          'status' => '0',
          'name' => '下载备份',
          'icon' => '',
          'remark' => '',
          'listorder' => '1000',
        ),
        array (
          'app' => 'Admin',
          'model' => 'Backup',
          'action' => 'del_backup',
          'data' => '',
          'type' => '1',
          'status' => '0',
          'name' => '删除备份',
          'icon' => '',
          'remark' => '',
          'listorder' => '1000',
        ),
        array (
          'app' => 'Admin',
          'model' => 'Backup',
          'action' => 'import',
          'data' => '',
          'type' => '1',
          'status' => '0',
          'name' => '数据备份导入',
          'icon' => '',
          'remark' => '',
          'listorder' => '1000',
        ),
      ),
    ),
    array (
      'app' => 'Admin',
      'model' => 'Mailer',
      'action' => 'default',
      'data' => '',
      'type' => '1',
      'status' => '1',
      'name' => '邮箱配置',
      'icon' => '',
      'remark' => '',
      'listorder' => '5',
      'children' => 
      array (
        array (
          'app' => 'Admin',
          'model' => 'Mailer',
          'action' => 'index',
          'data' => '',
          'type' => '1',
          'status' => '1',
          'name' => 'SMTP配置',
          'icon' => '',
          'remark' => '',
          'listorder' => '0',
          'children' => 
          array (
            array (
              'app' => 'Admin',
              'model' => 'Mailer',
              'action' => 'index_post',
              'data' => '',
              'type' => '1',
              'status' => '0',
              'name' => '提交配置',
              'icon' => '',
              'remark' => '',
              'listorder' => '0',
            ),
          ),
        ),
        array (
          'app' => 'Admin',
          'model' => 'Mailer',
          'action' => 'active',
          'data' => '',
          'type' => '1',
          'status' => '1',
          'name' => '邮件模板',
          'icon' => '',
          'remark' => '',
          'listorder' => '0',
          'children' => 
          array (
            array (
              'app' => 'Admin',
              'model' => 'Mailer',
              'action' => 'active_post',
              'data' => '',
              'type' => '1',
              'status' => '0',
              'name' => '提交模板',
              'icon' => '',
              'remark' => '',
              'listorder' => '0',
            ),
          ),
        ),
      ),
    ),
    array (
      'app' => 'Admin',
      'model' => 'Setting',
      'action' => 'clearcache',
      'data' => '',
      'type' => '1',
      'status' => '1',
      'name' => '清除缓存',
      'icon' => '',
      'remark' => '',
      'listorder' => '6',
    ),
  ),
);