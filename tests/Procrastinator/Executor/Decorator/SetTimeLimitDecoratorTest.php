<?php
namespace Procrastinator\Executor\Decorator;

use PHPUnit\Extension\FunctionMocker;
use PHPUnit\Framework\TestCase;
use Procrastinator\Deferred\CallbackDeferred;
use Procrastinator\Deferred\Deferred;
use Procrastinator\Executor\Executor;
use Procrastinator\Executable;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class SetTimeLimitDecoratorTest extends TestCase
{
    /** @var SetTimeLimitDecorator */
    private $decorator;

    /** @var Executor|MockObject */
    private $executor;

    /** @var Executable|MockObject */
    private $executable;

    /** @var Deferred|MockObject */
    private $deferred;

    /** @var MockObject */
    private $functions;

    protected function setUp()
    {
        $this->executor = $this->createMock(Executor::class);
        $this->decorator = new SetTimeLimitDecorator($this->executor, 120);
        $this->executable = $this->createMock(Executable::class);
        $this->deferred = $this->createMock(Deferred::class);
        $this->functions = FunctionMocker::start($this, __NAMESPACE__)
            ->mockFunction('set_time_limit')
            ->getMock();
    }

    public function testStartExecutionCallsFinishRequestAndThanWrapped()
    {
        $this->assertSame(120, $this->decorator->getTimeout());
        $this->functions
            ->expects($this->once())
            ->method('set_time_limit')
            ->with(120);
        $this->executor
            ->expects($this->once())
            ->method('startExecution')
            ->with($this->executable);
        $this->decorator->startExecution($this->executable);
        $this->assertSame(120, $this->decorator->getTimeout());
    }

    public function testEndExecutionCallsWrapped()
    {
        $this->executor
            ->expects($this->once())
            ->method('endExecution')
            ->with($this->executable);
        $this->decorator->endExecution($this->executable);
    }

    public function testExecuteCallsWrapped()
    {
        $this->executor
            ->expects($this->once())
            ->method('execute')
            ->with($this->deferred);
        $this->decorator->execute($this->deferred);
    }
}
