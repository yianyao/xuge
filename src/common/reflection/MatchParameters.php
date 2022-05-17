<?php

namespace xuge\common\reflection;

/**
 * 调用环境类方法返回实例
 */
class MatchParameters implements State
{
    public function run(Context $context)
    {
        return $context->createInstance();       
    }
}