<?php
namespace Procrastinator\Scheduler;

use PHPUnit\Framework\TestCase;
use Procrastinator\Executable;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class OnShutdownSchedulerTest extends TestCase
{
    /** @var Executable|MockObject */
    private $executable;

    /** @var OnShutdownScheduler */
    private $scheduler;

    protected function setUp()
    {
        $this->executable = $this->createMock(Executable::class);
        $this->scheduler = new OnShutdownScheduler();
    }

    protected function tearDown()
    {
        unset($GLOBALS['register_shutdown_function']);
    }

    public function testCallRegisterShutdownOnSchedule()
    {
        $this->assertArrayNotHasKey('register_shutdown_function', $GLOBALS);
        $this->executable
            ->expects($this->never())
            ->method('execute');
        $this->scheduler->schedule($this->executable);

        $this->assertSame([$this->executable, 'execute'], $GLOBALS['register_shutdown_function']);
    }
}

function register_shutdown_function($callback)
{
    $GLOBALS['register_shutdown_function'] = $callback;
}
