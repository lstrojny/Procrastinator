<?php
namespace Procrastinator\Executor;

use Procrastinator\Executable;
use Procrastinator\Deferred\Deferred;

class SingleThreadExecutor implements Executor
{
    public function startExecution(Executable $manager)
    {
    }

    public function execute(Deferred $deferred)
    {
        call_user_func($deferred->getCallback());
    }

    public function endExecution(Executable $manager)
    {
    }
}