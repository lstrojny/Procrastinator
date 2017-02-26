<?php
namespace Procrastinator\Executor\Decorator;

use Procrastinator\Deferred\Deferred;
use Procrastinator\Deferred\DoctrineEventConditionalDeferred;

class DoctrineEventConditionalExecutorDecorator extends ExecutorDecorator
{
    private $events = [];

    public function postConnect()
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function onSchemaCreateTable()
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function onSchemaCreateTableColumn()
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function onSchemaDropTable()
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function onSchemaAlterTable()
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function onSchemaAlterTableAddColumn()
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function onSchemaAlterTableRemoveColumn()
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function onSchemaAlterTableChangeColumn()
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function onSchemaAlterTableRenameColumn()
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function onSchemaColumnDefinition()
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function onSchemaIndexDefinition()
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function preRemove()
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function postRemove()
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function prePersist()
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function postPersist()
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function preUpdate()
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function postUpdate()
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function postLoad()
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function loadClassMetadata()
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function preFlush()
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function onFlush()
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function postFlush()
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function onClear()
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function onClassMetadataNotFound()
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function execute(Deferred $deferred)
    {
        if (!$deferred instanceof DoctrineEventConditionalDeferred) {
            parent::execute($deferred);
            return;
        }

        foreach ($deferred->getEvents() as $event) {
            if ($this->eventWasFired($event)) {
                parent::execute($deferred);
                break;
            }
        }
    }

    private function eventWasFired($event)
    {
        return in_array($event, $this->events, true);
    }

    private function rememberEvent($event)
    {
        if (!$this->eventWasFired($event)) {
            $this->events[] = $event;
        }
    }
}
