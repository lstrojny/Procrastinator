<?php
namespace Procrastinator\Scheduler;

use PHPUnit_Framework_TestCase as TestCase;

class OnShutdownSchedulerTest extends TestCase
{
    function setUp()
    {
        $this->manager = $this
            ->getMockBuilder('Procrastinator\DeferralManager')
            ->disableOriginalConstructor()
            ->getMock();
        $this->strategy = new OnShutdownScheduler();
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
        $this->strategy->schedule($this->manager);

        $this->assertSame(array($this->manager, 'execute'), $GLOBALS['register_shutdown_function']);
    }
}

function register_shutdown_function($callback)
{
    $GLOBALS['register_shutdown_function'] = $callback;
}
