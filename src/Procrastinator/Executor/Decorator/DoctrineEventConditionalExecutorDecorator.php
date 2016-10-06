<?php
namespace Procrastinator\Executor\Decorator;

use Procrastinator\Deferred\Deferred;
use Procrastinator\Deferred\DoctrineEventConditionalDeferred;
use Doctrine\Common\EventArgs;

class DoctrineEventConditionalExecutorDecorator extends ExecutorDecorator
{
    private $events = array();

    public function postConnect(EventArgs $args)
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function onSchemaCreateTable(EventArgs $args)
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function onSchemaCreateTableColumn(EventArgs $args)
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function onSchemaDropTable(EventArgs $args)
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function onSchemaAlterTable(EventArgs $args)
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function onSchemaAlterTableAddColumn(EventArgs $args)
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function onSchemaAlterTableRemoveColumn(EventArgs $args)
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function onSchemaAlterTableChangeColumn(EventArgs $args)
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function onSchemaAlterTableRenameColumn(EventArgs $args)
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function onSchemaColumnDefinition(EventArgs $args)
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function onSchemaIndexDefinition(EventArgs $args)
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function preRemove(EventArgs $args)
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function postRemove(EventArgs $args)
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function prePersist(EventArgs $args)
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function postPersist(EventArgs $args)
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function preUpdate(EventArgs $args)
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function postUpdate(EventArgs $args)
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function postLoad(EventArgs $args)
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function loadClassMetadata(EventArgs $args)
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function preFlush(EventArgs $args)
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function onFlush(EventArgs $args)
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function postFlush(EventArgs $args)
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function onClear(EventArgs $args)
    {
        $this->rememberEvent(__FUNCTION__);
    }

    public function onClassMetadataNotFound(EventArgs $args)
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
