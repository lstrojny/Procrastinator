<?php
namespace Procrastinator\Scheduler;

use PHPUnit_Framework_TestCase as TestCase;

class ImmediateSchedulerTest extends TestCase
{
    function setUp()
    {
        $this->manager = $this
            ->getMockBuilder('Procrastinator\ExecutableManager')
            ->disableOriginalConstructor()
            ->getMock();

        $this->strategy = new ImmediateScheduler();
    }

    function testImmediatelyExecutedOnSchedule()
    {
        $this->manager
            ->expects($this->once())
            ->method('execute');
        $this->strategy->schedule($this->manager);
    }
}
