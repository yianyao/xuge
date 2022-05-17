<?php

namespace xuge\router;

/**
 * 默认应用/控制器/方法 无参数
 */
class DefaultStrategy implements IStrategy
{
    use \xuge\common\traits\controller;
    public function judgeRequest() : string | array
    {
        return ['fqdn' => $this->getDefaultController(), 'action' => $this->getDefaultAction(), 'query' => $this->getQueryArray()];
    }
}