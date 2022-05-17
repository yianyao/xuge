<?php

namespace xuge\common\traits;

use xuge\config\Config;
use xuge\request\Request;


trait Controller
{    
    /**
     * 返回命名空间、应用、访问控制层、控制器、方法名及PathInfo参数列表
     *
     * @return array
     */
    public function appController() : array
    {
        list ($namespace, $default_app, $default_access, $applist, $vars)  = $this->initPath();
        if (\class_exists($fqdn = $namespace . DIRECTORY_SEPARATOR . $default_app . DIRECTORY_SEPARATOR . $default_access . DIRECTORY_SEPARATOR . $vars[0])){
            $method = $vars[1] ?? null; 
            if (is_null($method))throw new \Exception('missing method');
            return ['namespace' => $namespace, 'app' => $default_app, 'access' => $default_access, 'controller' => $vars[0], 'pathInfo' => array_slice($vars, 2), 'method' => $method];
        }

        /**
         * 指定应用
         */
        if (\count($vars) < 2)throw new \Exception("Invalid path missing controller " . "$vars[0]/$vars[1]");        
        $app = $vars[0];
        $controller = $vars[1];
        
        if (!in_array($app, $applist))throw new \Exception("App $app is not found in applist which was defined as $applist");
        if (\class_exists($fqdn = $namespace . DIRECTORY_SEPARATOR . $app . DIRECTORY_SEPARATOR . $default_access . DIRECTORY_SEPARATOR . $controller)){
            $method = $vars[2] ?? null;
            if (is_null($method))throw new \Exception('missing method');
            return ['namespace' => $namespace, 'app' => $app, 'access' => $default_access, 'controller' => $controller, 'pathInfo' => array_slice($vars,3),  'method' => $method];
        }

        return [];
    }

    /**
     * 把pathInfo中参数部分转换为索引数组 参数 ： 参数值
     *
     * @param array $params  相邻的元素构成键值对（所以循环步长值为2）
     * @return array
     */
    public function pathInfo2Arg(array $params) : array
    {
        $args = [];
        $len = \count($params);
        if ($len < 2)throw new \Exception('Invalid parameters');
        for ($i = 0; $i < $len; $i = $i + 2){
            $args[$params[$i]] = $params[$i + 1];
        }        
        return array_filter($args);
    }

    /**
     * 返回默认配置以及经整理的URI->pathinfo信息
     *
     * @return void
     */
    public function initPath() : array
    {
        Config::init();
        

        $namespace = Config::get('namespace');
        $default_app = Config::get('default_app');
        $default_access = Config::get('default_access');
        $app_list = Config::get('app_list');

        $pathInfo = $this->path();
        if (is_null($pathInfo))throw new \Exception('missing pathInfo');

        $vars = \explode('/', trim($pathInfo, '/'));
        
        if (empty($vars))throw new \Exception("Invalid UrlPath $pathInfo");

        return [$namespace, $default_app,  $default_access,  $app_list,  $vars];
    }

    /**
     * 返回路径中的pathinfo信息
     *
     * @return string
     */
    public function path() : ?string
    {
        Request::init();
        return Request::getPathInfo();
    }

    /**
     * r返回默认控制器名称
     *
     * @return string
     */
    public function getDefaultController() : string
    {
        Config::init();
        return Config::getDefaultController();
    }

    /**
     * 返回默认方法
     *
     * @return string
     */
    public function getDefaultAction() : string
    {
        Config::init();
        return Config::getDefaultAction();
    }

    /**
     * 返回整理后的URI->queryString
     *
     * @return array
     */
    public function getQueryArray() : array
    {
        Request::init();
        return Request::queryArray();
    }

    public function getQuery() : ?string
    {
        Request::init();
        return Request::getQuery();
    }


}