<?php

/**
 * 默认配置
 */

return [
    //项目根目录
    'root'  => '',
    //项目命名空间
    'namespace' => 'app',
    //应用列表
    'app_list' => ['admin'],
    //默认应用
    'default_app' => 'admin',
    //默认访问层(存储访问控制器的目录)
    'default_access' => 'controller',
    //默认控制器
    'default_controller' => 'index',
    //默认方法
    'default_action' => 'index',
    //url访问模式 ： 1、pathinfo（URL路径和参数均以反斜杠分隔） 2、query_string（URL访问字符串）
    'url_type' => 1,
    //URI兼容模式（不用路由）1；URI路由模式2
    'forceRouter' => 2
];