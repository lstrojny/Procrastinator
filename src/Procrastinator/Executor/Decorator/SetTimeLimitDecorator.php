<?php
namespace Procrastinator\Executor\Decorator;

use Procrastinator\Executor\Executor;
use Procrastinator\Executable;

class SetTimeLimitDecorator extends ExecutorDecorator
{
    protected $timeout;

    /**
     * @param Executor $wrapped
     * @param $timeout int
     */
    public function __construct(Executor $wrapped, $timeout)
    {
        $this->timeout = (int) $timeout;
        parent::__construct($wrapped);
    }

    /**
     * @param Executable $manager
     *
     * remember: calling set_time_limit() restarts the timer at 0
     */
    public function startExecution(Executable $manager)
    {
        set_time_limit($this->timeout);

        parent::startExecution($manager);
    }

    /**
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }
}
