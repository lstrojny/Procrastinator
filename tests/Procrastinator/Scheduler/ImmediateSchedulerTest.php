<?php
namespace Procrastinator\Scheduler;

use PHPUnit\Framework\TestCase;
use Procrastinator\Executable;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class ImmediateSchedulerTest extends TestCase
{
    /** @var Executable|MockObject */
    private $executable;

    /** @var ImmediateScheduler */
    private $strategy;

    protected function setUp()
    {
        $this->executable = $this->createMock(Executable::class);
        $this->strategy = new ImmediateScheduler();
    }

    public function testImmediatelyExecutedOnSchedule()
    {
        $this->executable
            ->expects($this->once())
            ->method('execute');
        $this->strategy->schedule($this->executable);
    }
}
