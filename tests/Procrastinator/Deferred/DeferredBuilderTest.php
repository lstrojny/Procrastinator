<?php
namespace Procrastinator\Deferred;

use PHPUnit\Framework\TestCase;
use Procrastinator\Exception\InvalidArgumentException;

class BuilderTest extends TestCase
{
    /** @var Builder */
    private $builder;

    protected function setUp()
    {
        $this->builder = new Builder();
    }

    public function testExceptionIsThrownWithoutName()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('No name given. Call name()');
        $this->builder->call([$this, __FUNCTION__]);
        $this->builder->build();
    }

    public function testExceptionIsThrownWithoutCallback()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('No callback given. Call call()');
        $this->builder->name('test');
        $this->builder->build();
    }

    public function testCallbackDeferredIsBuiltWithoutDoctrineCondition()
    {
        $this->assertSame($this->builder, $this->builder->name('test'));
        $this->assertSame($this->builder, $this->builder->call([$this, __FUNCTION__]));
        $deferred = $this->builder->build();
        /** We want to test for the class exactly */
        $this->assertInstanceOf(CallbackDeferred::class, $deferred);
        $this->assertSame('test', $deferred->getName());
        $this->assertSame([$this, __FUNCTION__], $deferred->getCallback());
    }

    public function testDoctrineConditionalDeferredIsBuiltWithDoctrineCondition()
    {
        $this->assertSame($this->builder, $this->builder->name('test'));
        $this->assertSame($this->builder, $this->builder->call([$this, __FUNCTION__]));
        $this->assertSame($this->builder, $this->builder->ifDoctrineEvent('postLoad'));
        $deferred = $this->builder->build();
        /** We want to test for the class exactly */
        $this->assertInstanceOf(DoctrineEventConditionalDeferred::class, $deferred);
        $this->assertSame('test', $deferred->getName());
        $this->assertSame([$this, __FUNCTION__], $deferred->getCallback());
    }
}
