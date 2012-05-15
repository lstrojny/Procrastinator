<?php
namespace Procrastinator\Executor\Decorator;

use PHPUnit_Framework_TestCase as TestCase;
use Procrastinator\Deferred\CallbackDeferred;

class SetTimeLimitDecoratorTest extends TestCase
{
    protected $executor;
    protected $decorator;
    protected $executable;
    protected $deferred;

    public function setUp()
    {
        $GLOBALS['fastcgi_finish_request'] = false;

        $this->executor = $this
            ->getMockBuilder('Procrastinator\Executor\Executor')
            ->getMock();
        $this->decorator = new SetTimeLimitDecorator($this->executor, 120);
        $this->executable = $this
            ->getMockBuilder('Procrastinator\Executable')
            ->getMock();
        $this->deferred = $this
            ->getMockBuilder('Procrastinator\Deferred\Deferred')
            ->getMock();
    }

    public function testStartExecutionCallsFinishRequestAndThanWrapped()
    {
        $this->assertSame(120, $this->decorator->getTimeout());
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
