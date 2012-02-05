<?php
namespace Procrastinator\Deferred;

use InvalidArgumentException;

class CallbackDeferred implements Deferred
{
    protected $name;

    protected $callback;

    public function __construct($name, $callback)
    {
        if (!is_callable($callback)) {
            throw new InvalidArgumentException('Invalid callback given');
        }

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