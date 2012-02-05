<?php
namespace Procrastinator\Executor;

use PHPUnit_Framework_TestCase as TestCase;
use Procrastinator\Deferred\CallbackDeferred;

class SingleThreadExecutorTest extends TestCase
{
    private $executor;
    private $called = 0;

    public function setUp()
    {
        $this->executor = new SingleThreadExecutor();
        $this->deferred = new CallbackDeferred('name', array($this, 'callback'));
    }

    public function testExecuteCallsCallback()
    {
        $this->assertSame(0, $this->called);
        $this->executor->execute($this->deferred);
        $this->assertSame(1, $this->called);
    }

    public function callback()
    {
        $this->called++;
    }
}