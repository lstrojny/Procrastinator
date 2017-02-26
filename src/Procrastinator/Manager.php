<?php
namespace Procrastinator;

abstract class Manager implements Manageable
{
    protected $deferreds = [];

    public function has($name)
    {
        return isset($this->deferreds[$name]);
    }

    public function get($name)
    {
        return $this->has($name) ? $this->deferreds[$name] : null;
    }

    public function getAll()
    {
        return array_values($this->deferreds);
    }
}
