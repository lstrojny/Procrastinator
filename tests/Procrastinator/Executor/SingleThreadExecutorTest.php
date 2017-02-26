<?php
namespace Procrastinator\Executor;

use PHPUnit\Framework\TestCase;
use Procrastinator\Deferred\CallbackDeferred;

class SingleThreadExecutorTest extends TestCase
{
    /** @var SingleThreadExecutor */
    private $executor;

    /** @var CallbackDeferred */
    private $deferred;

    private $called = 0;

    protected function setUp()
    {
        $this->executor = new SingleThreadExecutor();
        $this->deferred = new CallbackDeferred('name', [$this, 'procrastinatorCallback']);
    }

    public function testExecuteCallsCallback()
    {
        $this->assertSame(0, $this->called);
        $this->executor->execute($this->deferred);
        $this->assertSame(1, $this->called);
    }

    public function procrastinatorCallback()
    {
        $this->called++;
    }
}
