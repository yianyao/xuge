<?php

namespace xuge\request;

class Request
{
    public static $pathInfo = null;
    public static $queryString = null;
    public static $requestUri = null;
    public static $requestMethod = null; 
    public static $documentRoot = null;
    public static $scriptName = null;
    private static $instance = null;

    /**
     * 查询字符串数组
     *
     * @var [type]
     */
    private static $queryArray = null;

    

    private function __construct()
    {
        static::$pathInfo = $_SERVER['PATH_INFO'] ?: null;
        static::$queryString = $_SERVER['QUERY_STRING'] ?: null;
        static::$requestUri = $_SERVER['REQUEST_URI'] ?: null;
        static::$requestMethod = $_SERVER['REQUEST_METHOD'] ?: null;
        static::$documentRoot = $_SERVER['DOCUMENT_ROOT'] ?: null;
        static::$scriptName = $_SERVER['SCRIPT_NAME'] ?: null;
    }

    /**
     * 返回请求对象的单例
     * 定义URI路径中的pathInfo、queryString、请求URL、请求方法、请求根目录、脚本名
     *
     * @return void
     */
    public static function init()
    {
        return self::$instance ?? self::$instance = new static;    
    }

    /**
     * 返回URI查询参数的值
     * @todo 可以添加一个回调参数来对返回的参数值进行过滤转义等操作
     * 
     * @param string $param
     * @return mixed
     */
    public static function get(string $param)
    {
        $array = static::queryArray();        
        if(empty($array))throw new \Exception('No query string');
        if(!\array_key_exists($param, $array))throw new \Exception('Invalid query string');
        return $array[$param];
    }

    /**
     * 返回requestURI
     *
     * @return void
     */
    public static function getUri()
    {
        return static::$requestUri;
    }

    /**
     * 返回pathInfo
     *
     * @return mixed
     */
    public static function getPathInfo() : ?string
    {
        return static::$pathInfo;
    }

    /**
     * 返回queryString
     *
     * @return string
     */
    public static function getQuery() : ?string
    {
        return static::$queryString;
    }

    /**
     * 返回documentRoot
     *
     * @return string
     */
    public static function getDocumentRoot()
    {
        return static::$documentRoot;
    }

    /**
     * 返回scriptName
     *
     * @return string
     */
    public static function getScriptName()
    {
        return static::$scriptName;
    }

    /**
     * 返回请求方法
     *
     * @return string
     */
    public static function getMethod()
    {
        return static::$requestMethod;
    }

    /**
     * 返回URI查询数组
     *
     * @return array
     */
    public static function queryArray() : array
    {
        return static::$queryArray ?? static::getQueryArray();
    }
 
    /**
     * 解码查询字符串并输出其数组格式
     *
     * @return array
     */
    private static function getQueryArray() : array 
    {      
        $rs = [];        
        if(!\is_null(self::$queryString)){
            \parse_str(self::$queryString, $rs);
        }
        static::$queryArray = $rs;
        return $rs;
    }














}