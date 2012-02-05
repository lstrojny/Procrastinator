<?php
namespace Procrastinator\Executor\Decorator;

use Procrastinator\Executable;

class PhpFpmExecutorDecorator extends ExecutorDecorator
{
    public function startExecution(Executable $manager)
    {
        fastcgi_finish_request();
        parent::startExecution($manager);
    }
}