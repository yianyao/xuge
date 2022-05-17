<?php

namespace xuge\common\traits;

use xuge\common\reflection\Context;
use xuge\common\reflection\InitState;

/**
 * 绑定方法的参数
 * 非
 */
trait MethodParam
{
    /**
     * 绑定方法的实参到形参中
     */
    use BindParam;
    public function bindParam(array $parameters, array $arguments) : array
    {
        return $this->bind($parameters, $arguments);
    }

    private function getInstanceParam(string $className, array &$vars)
    {
        $args = $vars;
        $value = array_shift($args);

        if($value instanceOf $className){
            array_shift($vars);
            return $value;
        }

        $context = new Context(new InitState, [], new \ReflectionClass($className));
        return $context->operator();
    }

    /**
     * 天下岂有重名之参数乎
     *
     * @param string $argName
     * @param array $vars
     * @return void
     */
    private function getNormalParam(string $argName, array &$vars)
    {
        if (array_key_exists($argName, $vars)){      
            $tmp = $vars[$argName];
            unset($vars[$argName]);
            return $tmp;
        }
    }
}