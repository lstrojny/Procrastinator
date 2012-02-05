<?php
namespace Procrastinator;

use Procrastinator\Executor\Executor;

class ExecutableManager extends Manager implements Executable
{
    protected $executor;

    public function __construct(array $deferreds, Executor $executor)
    {
        $this->deferreds = $deferreds;
        $this->executor = $executor;
    }

    public function execute()
    {
        $this->executor->startExecution($this);

        foreach ($this->deferreds as $deferred) {
            $this->executor->execute($deferred);
        }

        $this->executor->endExecution($this);
    }

    public function getExecutor()
    {
        return $this->executor;
    }
}