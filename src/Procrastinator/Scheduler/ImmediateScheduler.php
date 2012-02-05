<?php
namespace Procrastinator\Scheduler;

use Procrastinator\Managable;

class ImmediateScheduler implements Scheduler
{
    public function schedule(Managable $manager)
    {
        $manager->execute();
    }
}