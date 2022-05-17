<?php

namespace xuge\common\reflection;

/**
 * 绑定参数状态并调用其方法返回待反射类的实例
 * 调用构造器方法绑定traits
 */
class BindParameters implements State
{
    use \xuge\common\traits\ConstructorParam;
    public function run(Context $context)
    {
        $args = [];
        $parameters = $context->getParameters();
        $arguments = $context->getArguments();

        $args = $this->bindParam($parameters, $arguments);
        $context->setArguments($args);
        return $context->createInstance();        
    }

   
}