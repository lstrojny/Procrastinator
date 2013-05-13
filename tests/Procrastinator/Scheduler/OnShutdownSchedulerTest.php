<?php
namespace Procrastinator\Scheduler;

use PHPUnit_Framework_TestCase as TestCase;
use Procrastinator\Executable;

class OnShutdownSchedulerTest extends TestCase
{
    /** @var Executable */
    private $manager;

    /** @var OnShutdownScheduler */
    private $scheduler;

    function setUp()
    {
        $this->manager = $this->getMock('Procrastinator\Executable');
        $this->scheduler = new OnShutdownScheduler();
    }

    function tearDown()
    {
        unset($GLOBALS['register_shutdown_function']);
    }

    function testCallRegisterShutdownOnSchedule()
    {
        $this->assertArrayNotHasKey('register_shutdown_function', $GLOBALS);
        $this->manager
            ->expects($this->never())
            ->method('execute');
        $this->scheduler->schedule($this->manager);

        $this->assertSame(array($this->manager, 'execute'), $GLOBALS['register_shutdown_function']);
    }
}

function register_shutdown_function($callback)
{
    $GLOBALS['register_shutdown_function'] = $callback;
}
