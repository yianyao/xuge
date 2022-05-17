<?php

namespace xuge\common\reflection;

/**
 * 判断待反射类是否有构造方法以定义构造器状态对象或无构造器状态对象并调用对应方法
 */
class Instance implements State
{
    public function run(Context $context)
    {
        if(is_null($context->getConstruct())){            
            $context->setState(new NoConstructor);
        }else{
            $context->setState(new Constructor);
        }

        return $context->operator();
    }
}