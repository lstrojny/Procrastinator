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

    public function setUp()
    {
        $GLOBALS['fastcgi_finish_request'] = false;

        $this->executor = $this->getMockBuilder('Procrastinator\Executor\Executor')
                               ->getMock();
        $this->decorator = new PhpFpmExecutorDecorator($this->executor);
        $this->executable = $this->getMockBuilder('Procrastinator\Executable')
                                 ->getMock();
        $this->deferred = $this->getMockBuilder('Procrastinator\Deferred\Deferred')
                               ->getMock();
    }

    public function tearDown()
    {
        unset($GLOBALS['fastcgi_finish_request']);
    }

    public function testStartExecutionCallsFinishRequestAndThanWrapped()
    {
        $this->assertFalse($GLOBALS['fastcgi_finish_request']);
        $this->executor->expects($this->once())->method('startExecution')->with($this->executable);
        $this->decorator->startExecution($this->executable);
        $this->assertTrue($GLOBALS['fastcgi_finish_request']);
    }

    public function testEndExecutionCallsWrapped()
    {
        $this->executor->expects($this->once())->method('endExecution')->with($this->executable);
        $this->decorator->endExecution($this->executable);
    }

    public function testExecuteCallsWrapped()
    {
        $this->executor->expects($this->once())->method('execute')->with($this->deferred);
        $this->decorator->execute($this->deferred);
    }
}

function fastcgi_finish_request()
{
    $GLOBALS['fastcgi_finish_request'] = true;
}