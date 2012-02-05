<?php
namespace Procrastinator;

interface Executable extends Managable
{
    public function execute();
    public function getExecutor();
}