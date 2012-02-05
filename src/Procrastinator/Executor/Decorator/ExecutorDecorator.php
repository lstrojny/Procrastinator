<?php
namespace Procrastinator\Executor\Decorator;

use Procrastinator\Executor\Executor;

use Procrastinator\Executable;
use Procrastinator\Deferred\Deferred;

abstract class ExecutorDecorator implements Executor
{
    protected $wrapped;

    public function __construct(Executor $wrapped)
    {
        $this->wrapped = $wrapped;
    }

    public function startExecution(Executable $manager)
    {
        $this->wrapped->startExecution($manager);
    }

    public function execute(Deferred $deferred)
    {
        $this->wrapped->execute($deferred);
    }

    public function endExecution(Executable $manager)
    {
        $this->wrapped->endExecution($manager);
    }
}
