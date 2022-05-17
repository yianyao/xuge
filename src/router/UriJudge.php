<?php

namespace xuge\router;


/**
 * 根据请求参数返回默认、全路由、半路由状态名字
 */
class UriJudge implements IStrategy
{
    use \xuge\common\traits\Controller;
    public function judgeRequest() :  string | array
    {       
        $pathinfo = $this->path();
        $query = $this->getQuery();

       if (is_null($query) && ( $pathinfo === '/' || is_null($pathinfo) ) ) return 'DefaultAccess';        
        if (!is_null($pathinfo) && !is_null($query)) return 'Completely';
        if (is_null($pathinfo) || is_null($query)) return 'Semi';
    }
}
