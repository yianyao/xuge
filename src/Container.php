<?php

namespace xuge;

use xuge\config\Config;
use xuge\request\Request;
use xuge\router\Dispatch;

/**
 * 基础容器类
 * 定义框架运行所需的各个实例
 */
class Container
{
    private static Config $config;

    private static Request $request;

    private static Dispatch $dispatch;

    private static $instance = null;

    /**
     * 初始化所有运行时实例
     */
    private function __construct()
    {
        static::$config = Config::init();
        static::$request = Request::init();
        static::$dispatch = Dispatch::init();
    }

    public static function init()
    {
        return self::$instance ?? self::$instance = new static;
    }

    public static function factory(string $name)
    {
        switch($name){
            case 'request':
                $product = static::request();
                break;
            case 'dispatch':
                $product = static::dispatch();
                break;
            default:
                break;
        }
        return $product;
    }

    /**
     * 返回请求对象
     *
     * @return Request
     */
    public function request() : Request
    {
        return static::$request ?? static::getRequest();
    }

    /**
     * 返回调度对象
     *
     * @return Dispatch
     */
    public function dispatch() : Dispatch
    {
        return static::$dispatch ?? static::getDispatch();
    }

    private static function getRequest() : Request
    {
        return static::$request = Request::init();
    }

    public static function getDispatch() : Dispatch
    {
        return static::$dispatch = Dispatch::init();
    }

}