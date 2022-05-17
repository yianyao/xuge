<?php

namespace xuge\router;

/**
 * 如果请求参数只设置了pathInfo，则设置空请求参数状态对象并调用其方法
 * 如果请求参数只设置了queryString则设置空路径参数状态对象并调用其方法
 */
class SemiState extends RState
{
    public function run(RContext $context) 
    {
        $context->setStrategy('PathJudge', []);
        $pathInfo = $context->judgeRequest();

        if (empty($pathInfo)){
            $context->setState('PathNull');
        }else{
            $context->setState('QueryNull');
        }
        return $context->operator();
    }
}