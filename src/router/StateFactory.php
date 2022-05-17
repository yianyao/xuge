<?php

namespace xuge\router;

/**
 * 状态工厂
 * 返回参数对应的状态对象
 */
class StateFactory
{
    private static RState $state;

    public static function create(string $stateName) : RState
    {
        switch ($stateName){
            case 'Completely':
                static::$state = new CompletelyState;
                break;     
            case 'Semi':
                static::$state = new SemiState;
                break;
            case 'DefaultAccess':
                static::$state = new DefaultAccessState;
                break;
            case 'PathNull':
                static::$state = new PathNullState;
                break;
            case 'QueryNull':
                static::$state = new QueryNullState;
                break;
            case 'Invoke':
                static::$state = new InvokeState;
                break;
            default:
                static::$state = new InitState;
                break;
        }
        return static::$state;
    }

}