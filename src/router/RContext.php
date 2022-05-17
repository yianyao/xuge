<?php

namespace xuge\router;

use xuge\common\reflection\Context as RefContext;
use xuge\common\reflection\InitState as RefInit;

use xuge\config\Config;
use xuge\request\Request;

/**
 * 路由状态环境类
 * 实现功能：
 * 1、维护状态对象（即URI请求的各种场景）并调用其方法
 *  1.1、pathInfo和queryString均为空，默认控制器和方法
 *  1.2、pathInfo和queryString均非空
 *  1.3、pathInfo或queryString任一为空
 * 综上所述，最终实现：按照URI给定的控制器、方法和参数，实现自动调用
 * 
 * 2、维护策略对象并调用其方法，以实现
 *  2.1、pathInfo和queryString值的判断
 *  2.2、返回上述两参数定义的控制器、方法名和传入方法的实参列表
 *  2.3、实参与形参的绑定由策略方法调用trait实现
 * 
 * 3、维护反射状态环境对象，以实现策略对象返回的方法调用
 *  3.1、通过反射实例化策略对象返回的控制器
 *  3.2、通过反射调用策略对象返回的方法
 *  3.3、控制器构造器参数和方法参数要求参照反射状态及其环境定义
 */
class RContext
{
    private RState $state;

    private IStrategy $strategy;

    private RefContext $refContext;


    /**
     * 方法参数列表
     *
     * @var array
     */
    private array $methodParameters = [];

    /**
     * 路径（应用/控制器/方法）
     *
     * @var string
     */
    private string $fqdn;

    /**
     * 方法名
     *
     * @var string
     */
    private string $methodName;

    /**
     *  维护状态对象、路径参数配置策略对象、系统配置对象和请求对象
     */
    public function __construct()
    {
        $this->state = new InitState();
    }    

    /**
     * 设置路由状态对象
     *
     * @param string $state
     * @return void
     */
    public function setState(string $state)
    {
        $this->state = StateFactory::create($state);
    }

    /**
     * 设置路径参数配置策略对象
     *
     * @param string $strategy
     * @param array $arg
     * @return void
     */
    public function setStrategy(string $strategy, array $arg)
    {
       $this->strategy = StrategyFactory::create($strategy, $arg);
    }

    /**
     * 设置反射状态环境变量
     *
     * @param string $fqdn
     * @param array $arguments
     * @return void
     */
    public function setRefContext(string $fqdn, $arguments = [])
    {
        $this->refContext = new RefContext(new RefInit, $arguments, new \ReflectionClass($fqdn));
    }

    public function getRefContext() : RefContext
    {
        return $this->refContext;
    }

    /**
     * 调用环境维护的策略对象，返回对应的状态名字/完全类名/方法名称/参数
     *
     * @param [type] ...$parms
     * @return mixed
     */
    public function judgeRequest(...$parms) : string | array
    {
        return  $this->strategy->judgeRequest(...$parms);        
    }

    /**
     * 设置方法名称
     *
     * @param string $methodName
     * @return void
     */
    public function setMethodName(string $methodName)
    {
        $this->methodName = $methodName;
    }

    /**
     * 返回定义的方法名称
     *
     * @return string
     */
    public function getMethodName() : string
    {
        return $this->methodName;
    }

    /**
     * 设置方法参数
     *
     * @param array $params
     * @return void
     */
    public function setMethodParameters(array $params) : void
    {
        $this->methodParameters = $params;
    }

    /**
     * 获取方法参数
     *
     * @return array
     */
    public function getMethodParameter() : array
    {
        return $this->methodParameters;
    }


    /**
     * 调用请求路径的方法
     * 通过反射状态环境类实现
     *
     * @param array $args
     * @return mixed
     */
    public function invoke(array $args)
    {
        //$this->refContext->operator();
        //return $this->getMethodName();
        return $this->refContext->invoke($this->methodName, $args);
    }

    /**
     * 调用状态对象方法
     *
     * @return mixed
     */
    public function operator()
    {
        return $this->state->run($this);
    }
}