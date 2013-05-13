<?php
namespace Procrastinator;

interface Manageable
{
    public function has($name);
    public function get($name);
    public function getAll();
}
