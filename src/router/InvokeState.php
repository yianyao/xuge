<?php

namespace xuge\router;

/**
 * 调用状态类
 */
class InvokeState extends RState
{
    use \xuge\common\traits\MethodParam;
    public function run(RContext $context)
    {
        $rc = $context->getRefContext();
        $methodName = $context->getMethodName();
        if (!$rc->getRef()->hasMethod($methodName)) throw new \Exception("Method " . $methodName . " not found!");

        $parameters = $rc->getRef()->getMethod($methodName)->getParameters();
        $argumetns = $context->getMethodParameter();
        $args = $this->bindParam($parameters, $argumetns);
        
        /**
         * 因为前面状态对象没有为类构造函数设置参数，所以如果 类构造函数需要参数
         * 就必须调用setArguments()方法并传入正确值，否则无法通过反射创建实例
         */
        //$context->getRefContext()->setArguments([$context]);

        $context->getRefContext()->operator();
        return $context->invoke($args);
    }
}
