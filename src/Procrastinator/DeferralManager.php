<?php
namespace Procrastinator;

use Procrastinator\Deferred\Deferred;
use Procrastinator\Scheduler\Scheduler;
use Procrastinator\Executor\Executor;
use DomainException;
use Procrastinator\Deferred\Builder;

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
            return;
        }

        $executableManager = new ExecutableManager($this->deferreds, $this->executor);
        $this->scheduler->schedule($executableManager);

        $this->deferreds = array();

        return $executableManager;
    }
}
