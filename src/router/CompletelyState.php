<?php

namespace xuge\router;

use xuge\config\Config;

/**
 * pathInfo & queryString
 */
class CompletelyState extends RState {
    public function run(RContext $context) 
    {
        $context->setStrategy('Path', []);
        $info = $context->judgeRequest();

        $context->setStrategy('Args', []);
        $args = $context->judgeRequest();

        $context->setMethodName($info['method']);
        $context->setMethodParameters($args);

        $context->setRefContext($info['fqdn']);
        
        $context->setState('Invoke');
        return $context->operator();  
    }
}