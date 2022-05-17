<?php

namespace xuge\common\reflection;

/**
 * @todo 此类尚有bug
 * 当实例化环境$context时传入该类以期能直接调用反射类方法时，环境类的$arguments属性不会做任何验证
 * 因为，在调用$context->invoke()方法时会直接把$arguments作为newInstanceArgs的参数
 * 在这种情况下，不会去判断要反射的类是否可以实例化、有无构造函数、构造函数是否可调用；
 * 构造函数的参数是否匹配；如不匹配是否需注入等等
 */
class InvokeMethod implements State
{
    public function __construct(string $method, array $parameters)
    {
        $this->parameters = $parameters;
        $this->method = $method;
    }

    public function run(Context $context)
    {   
        return $context->invoke($this->method, $this->parameters);
    }
}