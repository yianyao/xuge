<?php

namespace xuge\common\traits;

/**
 * 绑定参数到方法上
 */
trait BindParam
{
    /**
     * 绑定实参到形参中
     *
     * @param array $parameters 方法参数的反射类型列表，其元素为\RefctionParameter对象
     * @param array $arguments  方法参数列表，环境类维护
     * @return array
     */
    public function bind(array $parameters, array $arguments) : array
    {
        $args = [];
        
        foreach ($parameters as $parameter){                        
            $paramType = $parameter->getType();
            if ($paramType && $paramType->isBuiltin() === false) {
                $arg = $this->getInstanceParam($paramType->getName(), $arguments);               
                if (!$arg)throw new \Exception('Parameter Object ' . $paramType->getName() . ' is not set');
                $args[] = $arg;
            }else if(!empty($arguments)){
                $args[] = $this->getNormalParam($parameter->getName(), $arguments);
            }else if ($parameter->isDefaultValueAvailable()){
                $args[] = $parameter->getDefaultValue();
            }else{
                //print_r($parameter);
                throw new \InvalidArgumentException("method param miss : " . $parameter->getName() . ' in bindParam to method function');
            }
        }

        return $args;
    }

    abstract protected function getInstanceParam(string $className, array &$vars);

    abstract protected function getNormalParam(string $argName, array &$vars);

}