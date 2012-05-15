<?php
namespace Procrastinator\Executor\Decorator;

use Procrastinator\Executable;

class PhpFpmTimeoutExecutorDecorator extends ExecutorDecorator
{
    protected $timeout = 0;

    /**
     * @param Executable $manager
     */
    public function startExecution(Executable $manager)
    {
        if (function_exists('fastcgi_finish_request')
            || function_exists('Procrastinator\Executor\Decorator\fastcgi_finish_request')) {
            fastcgi_finish_request();
        }
        // remember: calling set_time_limit() restarts the timer at 0
        set_time_limit($this->timeout);

        parent::startExecution($manager);
    }

    /**
     * @param $timeout int
     * @return PhpFpmTimeoutExecutorDecorator
     */
    public function setTimeout($timeout)
    {
        $this->timeout = (int)$timeout;

        return $this;
    }

    /**
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }
}
