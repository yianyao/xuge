<?php

namespace xuge\config;

/**
 * 支持以点语法或数组索引方法访问配置
 */
class Config
{
    private static array $config;

    /**
     * 默认控制器路径
     *
     * @var string
     */
    private static $defaultControllers = null;

    /**
     * 单例实例
     *
     * @var [type]
     */
    private static $instance = null;

    private function __construct(){}

    /**
     * 初始化配置类
     *
     * @return void
     */
    public static function init()
    {        
        if (!is_null(static::$instance))return static::$instance;
        static::$config = !empty(static::$config) ? static::$config : static::getConfig(); 
        static::validateConfig();        
        return self::$instance = new static;    
    }

    /**
     * 验证是否设置了基础配置
     *
     * @return void
     */
    private static function validateConfig()
    {
        $keys = ['namespace', 'default_app', 'default_access', 'default_controller', 'default_action'];
        foreach ($keys as $key){
            if (static::get($key) == '')throw new \InvalidArgumentException("config key $key undefined!");
        }
    }

    /**
     * 合并默认配置和用户配置
     *
     * @param string $name
     * @return void
     */
    private static function getConfig(string $name = 'app')
    {
        $default = include __DIR__ . '/default.php';
        $fname = $name . '.php';
        $defined = static::require($fname);
        return \array_merge($default, $defined);
    }   

    /**
     * @todo 设置配置
     *
     * @param array $config
     * @return void
     */
    public static function set(array $config)
    {
        //修改app配置后更新静态属性static::$config        
    } 

    /**
     * 返回指定配置内容
     * @todo 后续可扩展读取多维数组
     * @param string $filename
     * @param string $key
     * @return mixed
     */
    public static function get(string $key = '')
    {        
        if(empty($key))return static::$config;
        if(!array_key_exists($key, static::$config))throw new \Exception("Invalid config key $key");
        return static::$config[$key];
    }

    /**
     * 返回默认控制器完全限定类名
     *
     * @return string
     */
    public static function getDefaultController() : string
    {
        if (!is_null(static::$defaultControllers))return static::$defaultControllers;
        $namespace = static::get('namespace');
        $default_app = static::get('default_app');
        $default_access = static::get('default_access');
        $default_controller = static::get('default_controller');

        return static::$defaultControllers = $namespace . '\\' . $default_app . '\\' . $default_access . '\\' . $default_controller;        
    }

    /**
     * 返回默认控制层
     *
     * @return string
     */
    public static function getDefaultAction() : string
    {
        return static::get('default_action');
    }

    /**
     * @todo 解析点语法
     *
     * @param string $param
     * @return void
     */
    private static function parser(string $param)
    {
        $res = explode(".", $param);
    }

    /**
     * 返回配置文件
     *
     * @param string $name
     * @return mixed
     */
    private static function require(string $name)
    {
        $filename = static::hasConfig($name);
        return include $filename;
    }

    /**
     * 检查配置文件是否存在
     *
     * @param string $name
     * @return boolean
     */
    private static function hasConfig(string $name)
    {
        $filename = static::defineConfigDirectory() . $name;
        if(!is_file($filename))throw new \Exception("Config file $filename not found");
        return $filename;
    }

    /**
     * 定义项目配置路径
     *
     * @return string
     */
    private static function defineConfigDirectory() : string
    {
        $root = dirname(__DIR__, 5) . DIRECTORY_SEPARATOR . 'config';
        if(!is_dir($root))throw new \Exception("Invalid config directory");
        return $root . DIRECTORY_SEPARATOR ;        
    }


    
}