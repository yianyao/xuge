<?php

namespace xuge\common\reflection;

/**
 * 有参状态对象
 * 如果参数数量无误（参数可知且初始化环境类时已传入）则设置参数匹配状态否则设置参数绑定状态并调用对应方法
 */
class Argument implements State
{
    public function run(Context $context)
    {    
        $parameters = $context->getParameters();
        if(count($parameters) == count($context->getArguments())){
            $context->setState(new MatchParameters);
        }else{
            $context->setState(new BindParameters);
        }
        return $context->operator();
    }


}