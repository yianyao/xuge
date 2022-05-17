<?php

namespace xuge\router;

class RException extends \Exception
{

}

/** 控制器不存在 */
class ControllerNotFoundException extends RException{}
/** 方法不存在 */
class MethodNotFoundException extends RException{}
/** 没有定义默认应用 */
class UndefinedApplicationException extends RException{}
/** 没有定义默认控制器 */
class UndefinedControllerException extends RException{}
/** 没有定义默认方法 */
class UndefinedMethodException extends RException{}
/** 缺少参数 */
class ParameterNotFoundException extends RException{}