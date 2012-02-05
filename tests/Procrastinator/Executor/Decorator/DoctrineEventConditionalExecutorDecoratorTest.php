<?php
namespace Procrastinator\Executor\Decorator;

namespace Procrastinator\Executor\Decorator;

use PHPUnit_Framework_TestCase as TestCase;
use Procrastinator\Deferred\CallbackDeferred;
use Doctrine\Common\EventArgs;
use ReflectionClass;

class DoctrineEventConditionalExecutorDecoratorTest extends TestCase
{
    private $executor;
    private $decorator;
    private $executable;
    private $deferred;
    private $doctrineDeferred;

    public function setUp()
    {
        if (!class_exists('Doctrine\ORM\Events')) {
            $this->markTestSkipped('Doctrine not present');
        }

        $this->executor = $this->getMockBuilder('Procrastinator\Executor\Executor')
                               ->getMock();
        $this->decorator = new DoctrineEventConditionalExecutorDecorator($this->executor);
        $this->executable = $this->getMockBuilder('Procrastinator\Executable')
                                 ->getMock();
        $this->deferred = $this->getMockBuilder('Procrastinator\Deferred\Deferred')
                               ->getMock();
        $this->doctrineDeferred = $this->getMockBuilder('Procrastinator\Deferred\DoctrineEventConditionalDeferred')
                                       ->disableOriginalConstructor()
                                       ->getMock();
    }

    public function testStartExecutionCallsFinishRequestAndThanWrapped()
    {
        $this->executor->expects($this->once())->method('startExecution')->with($this->executable);
        $this->decorator->startExecution($this->executable);
    }

    public function testEndExecutionCallsWrapped()
    {
        $this->executor->expects($this->once())->method('endExecution')->with($this->executable);
        $this->decorator->endExecution($this->executable);
    }

    public function testExecuteCallsWrappedForNormalDeferreds()
    {
        $this->executor->expects($this->once())->method('execute')->with($this->deferred);
        $this->decorator->execute($this->deferred);
    }

    public function testDoctrineConditionalDeferredIsNotExecutedIfEventNotFired()
    {
        $this->doctrineDeferred->expects($this->once())->method('getEvents')->will($this->returnValue(array('evt')));
        $this->executor->expects($this->never())->method('execute');
        $this->decorator->execute($this->doctrineDeferred);
    }

    public function provideDoctrineEvents()
    {
        $events = array();
        $dbalEvents = new ReflectionClass('Doctrine\DBAL\Events');
        foreach ($dbalEvents->getConstants() as $constant) {
            $this->assertSame($constant, constant('Doctrine\DBAL\Events::' . $constant));
            $events[] = $constant;
        }

        $ormEvents = new ReflectionClass('Doctrine\ORM\Events');
        foreach ($ormEvents->getConstants() as $constant) {
            $this->assertSame($constant, constant('Doctrine\ORM\Events::' . $constant));
            $events[] = $constant;
        }

        $this->assertSame($events, array_unique($events));

        foreach ($events as $k => $v) {
            $events[$k] = array($v);
        }

        return $events;
    }

    /**
     * @dataProvider provideDoctrineEvents
     */
    public function testDoctrineConditionalDeferredIsExecutedIfEventFired($event)
    {
        $this->doctrineDeferred->expects($this->once())->method('getEvents')->will($this->returnValue(array('evt1', $event, 'evt2')));
        $this->decorator->{$event}(EventArgs::getEmptyInstance());
        $this->executor->expects($this->once())->method('execute')->with($this->doctrineDeferred);
        $this->decorator->execute($this->doctrineDeferred);
    }
}