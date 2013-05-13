<?php
namespace Procrastinator;

interface Executable extends Manageable
{
    public function execute();
    public function getExecutor();
}
