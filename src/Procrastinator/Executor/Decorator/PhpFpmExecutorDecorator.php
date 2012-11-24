<?php
namespace Procrastinator\Executor\Decorator;

use Procrastinator\Executable;

class PhpFpmExecutorDecorator extends ExecutorDecorator
{
    public function startExecution(Executable $manager)
    {
        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }
        parent::startExecution($manager);
    }
}
