<?php

namespace xuge\router;

/**
 * 策略工厂
 * 根据策略名返回策略对象
 * 支持为策略对象定义构造器参数
 */
class StrategyFactory
{
    public static function create(string $strategyName, array $args)
    {
        switch ($strategyName){
            case 'uriJudge':
                $strategy = new UriJudge ;
                break;            
            case 'PathJudge':
                $strategy = new PathJudge ;
                break;
            case 'Path':
                $strategy = new PathStrategy;
                break;
            case 'Args':
                $strategy = new ArgStrategy;
                break;
            default:
                $strategy = new DefaultStrategy;
                break;           
        }
        return $strategy;
    }
}