<?php
namespace Procrastinator;

interface Schedulable
{
    /** @return Manager|null */
    public function schedule();
}
