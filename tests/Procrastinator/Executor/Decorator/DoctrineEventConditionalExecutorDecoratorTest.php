<?php
namespace Procrastinator\Executor\Decorator;

namespace Procrastinator\Executor\Decorator;

use Doctrine\Common\EventArgs;
use Doctrine\DBAL\Events as DbalEvents;
use Doctrine\ORM\Events as OrmEvents;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Procrastinator\Deferred\Deferred;
use Procrastinator\Deferred\DoctrineEventConditionalDeferred;
use Procrastinator\Executable;
use Procrastinator\Executor\Executor;
use ReflectionClass;

class DoctrineEventConditionalExecutorDecoratorTest extends TestCase
{
    /** @var DoctrineEventConditionalExecutorDecorator */
    private $decorator;

    /** @var Executor|MockObject */
    private $executor;

    /** @var Executable|MockObject */
    private $executable;

    /** @var  Deferred|MockObject */
    private $deferred;

    /** @var DoctrineEventConditionalDeferred|MockObject */
    private $doctrineDeferred;

    protected function setUp()
    {
        if (!class_exists(OrmEvents::class)) {
            $this->markTestSkipped('Doctrine not present');
        }

        $this->executor = $this->createMock(Executor::class);
        $this->decorator = new DoctrineEventConditionalExecutorDecorator($this->executor);
        $this->executable = $this->createMock(Executable::class);
        $this->deferred = $this->createMock(Deferred::class);
        $this->doctrineDeferred = $this->createMock(DoctrineEventConditionalDeferred::class);
    }

    public function testStartExecutionCallsFinishRequestAndThanWrapped()
    {
        $this->executor
            ->expects($this->once())
            ->method('startExecution')
            ->with($this->executable);
        $this->decorator->startExecution($this->executable);
    }

    public function testEndExecutionCallsWrapped()
    {
        $this->executor
            ->expects($this->once())
            ->method('endExecution')
            ->with($this->executable);
        $this->decorator->endExecution($this->executable);
    }

    public function testExecuteCallsWrappedForNormalDeferreds()
    {
        $this->executor
            ->expects($this->once())
            ->method('execute')
            ->with($this->deferred);
        $this->decorator->execute($this->deferred);
    }

    public function testDoctrineConditionalDeferredIsNotExecutedIfEventNotFired()
    {
        $this->doctrineDeferred
            ->expects($this->once())
            ->method('getEvents')
            ->will($this->returnValue(['evt']));
        $this->executor
            ->expects($this->never())
            ->method('execute');
        $this->decorator->execute($this->doctrineDeferred);
    }

    public function provideDoctrineEvents()
    {
        $events = [];
        $dbalEvents = new ReflectionClass(DbalEvents::class);
        foreach ($dbalEvents->getConstants() as $constant) {
            $this->assertSame($constant, constant('Doctrine\DBAL\Events::' . $constant));
            $events[] = $constant;
        }

        $ormEvents = new ReflectionClass(OrmEvents::class);
        foreach ($ormEvents->getConstants() as $constant) {
            $this->assertSame($constant, constant('Doctrine\ORM\Events::' . $constant));
            $events[] = $constant;
        }

        $this->assertSame($events, array_unique($events));

        foreach ($events as $k => $v) {
            $events[$k] = [$v];
        }

        return $events;
    }

    /** @dataProvider provideDoctrineEvents */
    public function testDoctrineConditionalDeferredIsExecutedIfEventFired($event)
    {
        $this->doctrineDeferred
            ->expects($this->once())
            ->method('getEvents')
            ->will($this->returnValue(['evt1', $event, 'evt2']));
        $this->decorator->{$event}(EventArgs::getEmptyInstance());
        $this->executor
            ->expects($this->once())
            ->method('execute')
            ->with($this->doctrineDeferred);
        $this->decorator->execute($this->doctrineDeferred);
    }
}
