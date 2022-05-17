<?php

namespace xuge\router;

class PathStrategy implements IStrategy
{
    /**
     * 返回PathInfo中的控制器
     */
    use \xuge\common\traits\Controller;
    public function judgeRequest(): string | array
    {
        $info = $this->appController();

        $fqdn = $this->controller($info);
        $method = $info['method'];

        return ['fqdn' => $fqdn, 'method' => $method];
    }

    /**
     * 返回配置文件定义的命名空间、默认应用、默认访问层、应用列表以及请求URL中的pathInfo
     *
     * @param array $app_controller
     * @return string
     */
    private function controller(array $app_controller): string
    {
        $app_controller = $this->appController();
        if (empty($app_controller)) throw new \Exception('Controller not found');
        return $app_controller['namespace'] . DIRECTORY_SEPARATOR . $app_controller['app'] . DIRECTORY_SEPARATOR . $app_controller['access'] . DIRECTORY_SEPARATOR . $app_controller['controller'];
    }
}
