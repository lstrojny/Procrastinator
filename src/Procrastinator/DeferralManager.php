<?php
namespace Procrastinator;

use Procrastinator\Deferred\Builder;
use Procrastinator\Deferred\Deferred;
use Procrastinator\Executor\Executor;
use Procrastinator\Scheduler\Scheduler;

class DeferralManager extends Manager implements Schedulable
{
    protected $scheduler;
    protected $executor;

    public function __construct(Scheduler $scheduler, Executor $executor)
    {
        $this->scheduler = $scheduler;
        $this->executor = $executor;
    }

    public function register(Deferred $deferred)
    {
        $this->deferreds[$deferred->getName()] = $deferred;

        return $this;
    }

    public function newDeferred()
    {
        return new Builder();
    }

    public function schedule()
    {
        if (!$this->deferreds) {
            return null;
        }

        $executableManager = new ExecutableManager($this->deferreds, $this->executor);
        $this->scheduler->schedule($executableManager);

        $this->deferreds = [];

        return $executableManager;
    }
}
