<?php

namespace xuge\common\reflection;

/**
 * 反射对象状态接口
 */
interface State
{
    public function run(Context $context);
}