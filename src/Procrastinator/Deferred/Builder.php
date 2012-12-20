<?php
namespace Procrastinator\Deferred;

use Procrastinator\Exception\InvalidArgumentException;

class Builder
{
    protected $name;

    protected $callback;

    protected $doctrineEvent;


    public function name($name)
    {
        $this->name = $name;

        return $this;
    }

    public function call($callback)
    {
        $this->callback = $callback;

        return $this;
    }

    public function ifDoctrineEvent($doctrineEvent)
    {
        $this->doctrineEvent = $doctrineEvent;

        return $this;
    }

    public function build()
    {
        if (!$this->name) {
            throw new InvalidArgumentException('No name given. Call name()');
        }

        if (!$this->callback) {
            throw new InvalidArgumentException('No callback given. Call call()');
        }

        if ($this->doctrineEvent) {
            return new DoctrineEventConditionalDeferred($this->name, $this->callback, $this->doctrineEvent);
        }

        return new CallbackDeferred($this->name, $this->callback);
    }
}
