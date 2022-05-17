<?php

namespace xuge\router;

class PathJudge implements IStrategy
{
    use \xuge\common\traits\Controller;
    public function judgeRequest() : string | array
    {
        return $this->path() ?? [];
    }
}