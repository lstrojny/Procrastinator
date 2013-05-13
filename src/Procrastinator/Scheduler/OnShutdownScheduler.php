<?php
namespace Procrastinator\Scheduler;

use Procrastinator\Executable;

class OnShutdownScheduler implements Scheduler
{
    public function schedule(Executable $manager)
    {
        register_shutdown_function(array($manager, 'execute'));
    }
}
