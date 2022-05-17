<?php

namespace xuge\router;

/**
 * 参数计算策略
 */
class ArgStrategy implements IStrategy
{
    /**
     * 返回pathInfo中的参数
     */
    use \xuge\common\traits\Controller;
    public function judgeRequest() :  string | array
    {
        $query =  $this->getQueryArray();
        $info = $this->appController();        
        
        return empty($query) ? $this->pathInfo2Arg($info['pathInfo']) : $query;
    }
}