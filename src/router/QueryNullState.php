<?php

namespace xuge\router;

/**
 * 调用空queryString参数状态对象
 * 设置请求的控制器、控制器构造方法参数、请求方法、方法参数
 */
class QueryNullState extends RState
{
   // use \xuge\common\traits\MethodParam;
    public function run(RContext $context)
    {
        $context->setStrategy('Path', []);
        $path = $context->judgeRequest();           

        $context->setStrategy('Args',[]);
        $args = $context->judgeRequest();
        
        $context->setMethodName($path['method']);
        $context->setMethodParameters($args);

        /**
         * 调用此方法设置反射状态环境对象时，需确保待反射对象构造函数没有要赋值的参数
         * （即非依赖注入或默认值外的其他内置类型参数），否则需传入第二个参数值或在
         * 后续调用其invoke()方法前先调用反射状态环境对象的setArguments()方法
         */
        $context->setRefContext($path['fqdn']);
        
        $context->setState('Invoke');
        return $context->operator();        
    }
}