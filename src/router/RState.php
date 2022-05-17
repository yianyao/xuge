<?php

namespace xuge\router;

/**
 * 路由状态接口
 */
abstract class RState
{
    protected IStrategy $strategy;
    abstract public function run(RContext $context);
}