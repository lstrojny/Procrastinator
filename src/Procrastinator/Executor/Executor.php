<?php
namespace Procrastinator\Executor;

use Procrastinator\Deferred\Deferred;
use Procrastinator\Executable;

interface Executor
{
    public function startExecution(Executable $manager);

    public function execute(Deferred $deferred);

    public function endExecution(Executable $manager);
}
