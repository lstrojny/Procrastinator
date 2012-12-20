<?php
namespace Procrastinator\Deferred;

use PHPUnit_Framework_TestCase as TestCase;

class DoctrineEventConditionalDeferredTest extends TestCase
{
    public function testEventsMustBeGiven()
    {
        $this->setExpectedException('Procrastinator\Exception\InvalidArgumentException', 'No events specified');
        new DoctrineEventConditionalDeferred('test', array($this, __FUNCTION__), null);
    }

    public function testEventsMustBeGiven2()
    {
        $this->setExpectedException('Procrastinator\Exception\InvalidArgumentException', 'No events specified');
        new DoctrineEventConditionalDeferred('test', array($this, __FUNCTION__), array());
    }

    public function testEventsAreCastedToArray()
    {
        $deferred = new DoctrineEventConditionalDeferred('test', array($this, __FUNCTION__), 'evt');
        $this->assertSame(array('evt'), $deferred->getEvents());
        $this->assertSame('test', $deferred->getName());
        $this->assertSame(array($this, __FUNCTION__), $deferred->getCallback());
    }

    public function testSpecifyingMoreThanOneEventIsPossible()
    {
        $deferred = new DoctrineEventConditionalDeferred('test', array($this, __FUNCTION__), array('evt1', 'evt2'));
        $this->assertSame(array('evt1', 'evt2'), $deferred->getEvents());
        $this->assertSame('test', $deferred->getName());
        $this->assertSame(array($this, __FUNCTION__), $deferred->getCallback());
    }
}
