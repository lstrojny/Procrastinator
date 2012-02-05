<?php
namespace Procrastinator\Scheduler;

use Procrastinator\Managable;

interface Scheduler
{
    public function schedule(Managable $manager);
}
