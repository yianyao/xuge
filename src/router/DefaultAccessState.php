<?php

namespace xuge\router;

/**
 * 默认路由状态
 * 调用默认应用、默认控制器的默认方法并返回结果
 */
class DefaultAccessState extends RState
{
    public function run(RContext $context)
    {        
        $context->setStrategy('Default', []);
        $info = $context->judgeRequest();
                
        $context->setRefContext($info['fqdn']);
        $context->setMethodName($info['action']);

        $context->setState('Invoke');
        return $context->operator();
    }
}