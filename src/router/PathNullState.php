<?php

namespace xuge\router;

/**
 * 调用空路径参数状态对象方法
 * 路径为空，是且仅是默认应用、默认控制器和默认方法
 */
class PathNullState extends RState
{
    public function run(RContext $context)
    {       
        $context->setStrategy('Default', []);
        $info = $context->judgeRequest();             
        
        $context->setMethodName($info['action']);
        $context->setMethodParameters($info['query']);

        $context->setRefContext($info['fqdn']);
        $context->setState('Invoke');
        return $context->operator();
        
    }
}