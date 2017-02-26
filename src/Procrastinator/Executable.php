<?php
namespace Procrastinator;

use Procrastinator\Executor\Executor;

interface Executable extends Manageable
{
    public function execute();

    /** @return Executor */
    public function getExecutor();
}
