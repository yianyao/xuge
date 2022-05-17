<?php


namespace xuge\common\reflection;

/**
 * 构造器无参状态，返回待反射类实例
 */
class NoArgument implements State
{
    public function run(Context $context)
    { 
        return $context->createInstance();
    }
}