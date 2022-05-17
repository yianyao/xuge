<?php

namespace xuge\router;

/**
 * 初始化路由状态对象
 * 检查URI参数
 * 设置默认路由（应用根目录）或全路由（请求包含了pathInfo和queryString）或半路由（请求只包含了pathInfo或queryString）路由状态对象
 * 调用对应路由状态的方法
 */
class InitState extends RState
{
    public function run(RContext $context)
    {
        $context->setStrategy('uriJudge', []);
        $state = $context->judgeRequest();
        if (!in_array($state, ['Completely', 'DefaultAccess', 'Semi'])) throw new \Exception('Invalid state from InitState');
        $context->setState($state);
        
        return $context->operator();
    }
}
