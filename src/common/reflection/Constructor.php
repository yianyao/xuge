<?php

namespace xuge\common\reflection;

/**
 * 构造器状态对象
 * 判断构造器有无参数以返回有参状态对象或无参状态对象并调用对应方法
 */
class Constructor implements State
{
    public function run(Context $context)
    {
        if($context->getConstruct()->getNumberOfParameters() > 0){            
            $context->setState(new Argument);
        }else{
            $context->setState(new NoArgument);
        }

        return $context->operator();
    }
}