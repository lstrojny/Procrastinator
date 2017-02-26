<?php
namespace Procrastinator\Deferred;

use PHPUnit\Framework\TestCase;
use Procrastinator\Exception\InvalidArgumentException;

class DoctrineEventConditionalDeferredTest extends TestCase
{
    public function testEventsMustBeGiven()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('No events specified');
        new DoctrineEventConditionalDeferred('test', [$this, __FUNCTION__], null);
    }

    public function testEventsMustBeGiven2()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('No events specified');
        new DoctrineEventConditionalDeferred('test', [$this, __FUNCTION__], []);
    }

    public function testEventsAreCastedToArray()
    {
        $deferred = new DoctrineEventConditionalDeferred('test', [$this, __FUNCTION__], 'evt');
        $this->assertSame(['evt'], $deferred->getEvents());
        $this->assertSame('test', $deferred->getName());
        $this->assertSame([$this, __FUNCTION__], $deferred->getCallback());
    }

    public function testSpecifyingMoreThanOneEventIsPossible()
    {
        $deferred = new DoctrineEventConditionalDeferred('test', [$this, __FUNCTION__], ['evt1', 'evt2']);
        $this->assertSame(['evt1', 'evt2'], $deferred->getEvents());
        $this->assertSame('test', $deferred->getName());
        $this->assertSame([$this, __FUNCTION__], $deferred->getCallback());
    }
}
