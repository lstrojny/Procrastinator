<?php
namespace Procrastinator\Deferred;

use PHPUnit\Framework\TestCase;
use Procrastinator\Exception\InvalidArgumentException;

class CallbackDeferredTest extends TestCase
{
    /** @var CallbackDeferred */
    private $deferred;

    public function procrastinatorCallback()
    {
    }

    protected function setUp()
    {
        $this->deferred = new CallbackDeferred('name', [$this, 'procrastinatorCallback']);
    }

    public function testGetName()
    {
        $this->assertSame('name', $this->deferred->getName());
    }

    public function testGetCallback()
    {
        $this->assertSame([$this, 'procrastinatorCallback'], $this->deferred->getCallback());
    }
}
