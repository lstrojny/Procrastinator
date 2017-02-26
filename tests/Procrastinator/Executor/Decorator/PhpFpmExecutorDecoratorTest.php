<?php
namespace Procrastinator\Executor\Decorator;

use PHPUnit\Extension\FunctionMocker;
use PHPUnit\Framework\TestCase;
use Procrastinator\Deferred\Deferred;
use Procrastinator\Executable;
use Procrastinator\Executor\Executor;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class PhpFpmExecutorDecoratorTest extends TestCase
{
    /** @var PhpFpmExecutorDecorator */
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
        $this->decorator = new PhpFpmExecutorDecorator($this->executor);
        $this->executable = $this->createMock(Executable::class);
        $this->deferred = $this->createMock(Deferred::class);
        $this->functions = FunctionMocker::start($this, __NAMESPACE__)
            ->mockFunction('function_exists')
            ->mockFunction('fastcgi_finish_request')
            ->getMock();
    }

    public function testStartExecutionCallsFinishRequestAndThanWrapped()
    {
        $this->executor
            ->expects($this->once())
            ->method('startExecution')
            ->with($this->executable);
        $this->functions
            ->expects($this->once())
            ->method('function_exists')
            ->with('fastcgi_finish_request')
            ->will($this->returnValue(true));
        $this->functions
            ->expects($this->once())
            ->method('fastcgi_finish_request');
        $this->decorator->startExecution($this->executable);
    }

    public function testStartExecutionDoesNotCallFinishRequestIfNotExist()
    {
        $this->executor
            ->expects($this->once())
            ->method('startExecution')
            ->with($this->executable);
        $this->functions
            ->expects($this->once())
            ->method('function_exists')
            ->with('fastcgi_finish_request')
            ->will($this->returnValue(false));
        $this->functions
            ->expects($this->never())
            ->method('fastcgi_finish_request');
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

    public function testExecuteCallsWrapped()
    {
        $this->executor
            ->expects($this->once())
            ->method('execute')
            ->with($this->deferred);
        $this->decorator->execute($this->deferred);
    }
}
