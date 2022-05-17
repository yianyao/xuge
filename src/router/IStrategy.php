<?php

namespace xuge\router;


/**
 * 路径参数配置策略对象接口
 */
interface IStrategy
{          
    public function judgeRequest() : string | array;    
}



