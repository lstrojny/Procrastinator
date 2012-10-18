<?php
namespace Procrastinator\Deferred;

use PHPUnit_Framework_TestCase as TestCase;

class CallbackDeferredTest extends TestCase
{
    public function procrastinatorCallback()
    {
    }

    public function setUp()
    {
        $this->deferred = new CallbackDeferred('name', array($this, 'procrastinatorCallback'));
    }

    public function testGetName()
    {
        $this->assertSame('name', $this->deferred->getName());
    }

    public function testGetCallback()
    {
        $this->assertSame(array($this, 'procrastinatorCallback'), $this->deferred->getCallback());
    }

    public function testExceptionIsThrownWithInvalidCallback()
    {
        $this->setExpectedException('InvalidArgumentException', 'Invalid callback given');
        new CallbackDeferred('name', array($this, 'something'));
    }
}
