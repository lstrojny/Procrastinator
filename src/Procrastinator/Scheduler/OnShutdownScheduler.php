<?php
namespace Procrastinator\Scheduler;

use Procrastinator\Managable;

class OnShutdownScheduler implements Scheduler
{
    public function schedule(Managable $manager)
    {
        register_shutdown_function(array($manager, 'execute'));
    }
}