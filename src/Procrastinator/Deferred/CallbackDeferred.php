<?php
namespace Procrastinator\Deferred;

use Procrastinator\Exception\InvalidArgumentException;

class CallbackDeferred implements Deferred
{
    protected $name;

    protected $callback;

    public function __construct($name, callable $callback)
    {
        $this->name = $name;
        $this->callback = $callback;
    }

    public function getCallback()
    {
        return $this->callback;
    }

    public function getName()
    {
        return $this->name;
    }
}
