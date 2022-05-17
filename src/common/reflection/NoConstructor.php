<?php

namespace xuge\common\reflection;

/**
 * 无构造器对象，使用反射返回待反射类的实例
 */
class NoConstructor implements State
{
    public function run(Context $context)
    {      
        return $context->getRef()->newInstanceWithoutConstructor();
    }
}