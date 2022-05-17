<?php

namespace xuge\common\reflection;

/**
 * 初始化状态类
 * 如果待反射类可实例化则调用实例化状态对象操作方法
 * 否则判断是否单例并调用待反射类的init方法返回单例，无法调用则抛出无法实例化异常
 */
class InitState implements State
{
    public function run(Context $context)
    {
        if ($context->isInstantiable()){
            $context->setState(new Instance);
            return $context->operator();
        }else{
            /**
             * 实例化单例类 ： 要求使用$instance存储单例； 并使用静态方法init实现单例
             */
            if ($context->getRef()->hasMethod('init') && $context->getRef()->hasProperty('instance') && $context->getRef()->getMethod('init')->isStatic()) {
               return $context->getRef()->getMethod('init')->invoke(null);
            };
            throw new \Exception("The Class : $context->getRef() is not instantiable");
        }
    }
}