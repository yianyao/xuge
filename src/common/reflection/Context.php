<?php

namespace xuge\common\reflection;

/**
 * 反射调用状态环境类
 * 通过反射实例化类（支持依赖注入）和调用类的方法
 * 待实例化的类前提
 *  1、只支持依赖注入对象和默认参数
 *  2、支持单例：构造方法私有，通过init方法调用，存储单例变量名instance
 * 

 */
class Context
{
    private State $state;    

    /**
     * 反射类
     *
     * @var \ReflectionClass
     */
    private \ReflectionClass $ref;

    /**
     * 实参列表
     *
     * @var array
     */
    private array $arguments;


    /**
     * 环境构造函数
     *
     * @param State $state  初始状态对象
     * @param array $arguments  需要使用反射获取实例的类的构造函数参数列表
     * @param \ReflectionClass $ref 需要反射的类
     */
    public function __construct(State $state, array $arguments, \ReflectionClass $ref)
    {
        $this->state = $state;
        $this->ref = $ref;
        $this->arguments = $arguments;
    }

    /**
     * 判断属性指向的反射类能被实例化
     *
     * @return boolean
     */
    public function isInstantiable() : bool
    {
        return $this->ref->isInstantiable();
    }

    /**
     * 返回类的构造函数或NULL
     *
     * @return mixed
     */
    public function getConstruct() : ?\ReflectionMethod
    {
        return $this->ref->getConstructor();
    }

    /**
     * 获取反射类
     *
     * @return \ReflectionClass
     */
    public function getRef() : \ReflectionClass
    {
        return $this->ref;
    }

    /**
     * 设置构造方法实参
     *
     * @param array $argmments
     * @return void
     */
    public function setArguments(array $argmments) : void
    {
        $this->arguments = $argmments;
    }

    /**
     * 获取构造方法实参
     *
     * @return array
     */
    public function getArguments() : array
    {
        return $this->arguments;
    }

    /**
     * 返回方法形参的反射对象列表
     *
     * @return array
     */
    public function getParameters() : array
    {        
        return $this->parameters = $this->getConstruct()->getParameters();
    }

    /**
     * 生成实例
     */
    public function createInstance()
    {
        return $this->instance = $this->instance ?? $this->ref->newInstanceArgs($this->arguments);
    }

    /**
     * 获取实例
     */
    public function getInstance()
    {
        return $this->createInstance();
    }

    /**
     * 调用反射方法
     *
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function invoke(string $method, array $args)
    {
        if (!$this->ref->hasMethod($method))throw new \Exception("Method $method is not defined");
        return $this->instance ? $this->ref->getMethod($method)->invokeArgs($this->instance, $args) : $this->ref->getMethod($method)->invokeArgs($this->createInstance(), $args);
    }

    /**
     * 设置状态对象
     *
     * @param State $state
     * @return void
     */
    public function setState(State $state)
    {
        $this->state = $state;
    }

    public function operator()
    {
        return $this->state->run($this);
    }
}