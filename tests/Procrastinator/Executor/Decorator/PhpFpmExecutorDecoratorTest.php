<?php
namespace Procrastinator\Executor\Decorator;

use PHPUnit_Framework_TestCase as TestCase;
use Procrastinator\Deferred\CallbackDeferred;

class PhpFpmExecutorDecoratorTest extends TestCase
{
    private $executor;
    private $decorator;
    private $executable;
    private $deferred;
    private $functions;

    public function setUp()
    {
        $this->executor = $this
            ->getMockBuilder('Procrastinator\Executor\Executor')
            ->getMock();
        $this->decorator = new PhpFpmExecutorDecorator($this->executor);
        $this->executable = $this
            ->getMockBuilder('Procrastinator\Executable')
            ->getMock();
        $this->deferred = $this
            ->getMockBuilder('Procrastinator\Deferred\Deferred')
            ->getMock();
        $this->functions = \PHPUnit_Extension_FunctionMocker::start($this, __NAMESPACE__)
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
