<?php
namespace Procrastinator\Scheduler;

use Procrastinator\Executable;

interface Scheduler
{
    public function schedule(Executable $manager);
}
