<?php
namespace Procrastinator\Scheduler;

use Procrastinator\Executable;

class ImmediateScheduler implements Scheduler
{
    public function schedule(Executable $manager)
    {
        $manager->execute();
    }
}
