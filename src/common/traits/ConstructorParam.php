<?php

namespace xuge\common\traits;

use xuge\common\reflection\Context;
use xuge\common\reflection\InitState;

/**
 * 绑定构造函数的参数，支持依赖注入
 */
trait ConstructorParam
{
    use BindParam;
    /**
     * 为构造器方法绑定实参
     *
     * @param array $parameters 形参的反射对象（\RefctionParameter对象）列表
     * @param array $arguments 用来绑定值到实参列表中的数组
     * @return array
     */
    public function bindParam(array $parameters, array $arguments) : array
    {
       return $this->bind($parameters, $arguments);
    }

    /**
     * 返回参数中注入的对象实例
     * 递归调用
     * @param string $className
     * @param array $vars
     * @return Object
     */
    private function getInstanceParam(string $className, array &$vars) : Object
    {
        $args = $vars;
        $value = array_shift($args);
        
        if($value instanceof $className){
            array_shift($vars);
            return $value;
        }
        
        $context = new Context(new InitState, [], new \ReflectionClass($className));       
        return $context->operator();
    }

    /**
     * 返回参数中内置类型的数值
     *
     * @param string $argName
     * @param array $vars
     * @return void
     */
    private function getNormalParam(string $argName, array &$vars)
    {
        return array_shift($vars);
    }

    private function getInstanceParams(string $className, array &$vars)
    {
        $args = $vars;
        $value = array_shift($args);

        if ($value instanceof $className){
            array_shift($vars);
            return $value;
        }else{
            $context = new Context(new InitState, [], new \ReflectionClass($className));
            return $context->operator();
        }
    }

    private function getArgsParam(string $paramName, array &$vars)
    {
        $args = $vars;
        if(key($args) === 0){
            return array_shift($vars);
        }elseif (\array_key_exists($paramName, $args)){
            $tmp = $vars[$paramName];
            unset($vars[$paramName]);
            return $tmp;
        }
    }
}