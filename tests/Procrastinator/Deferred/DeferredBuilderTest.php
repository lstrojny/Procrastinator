<?php
namespace Procrastinator\Deferred;

use PHPUnit_Framework_TestCase as TestCase;

class BuilderTest extends TestCase
{
    public function setUp()
    {
        $this->builder = new Builder();
    }

    public function testExceptionIsThrownWithoutName()
    {
        $this->setExpectedException('InvalidArgumentException', 'No name given. Call name()');
        $this->builder->call(array($this, __FUNCTION__));
        $this->builder->build();
    }

    public function testExceptionIsThrownWithoutCallback()
    {
        $this->setExpectedException('InvalidArgumentException', 'No callback given. Call call()');
        $this->builder->name('test');
        $this->builder->build();
    }

    public function testCallbackDeferredIsBuiltWithoutDoctrineCondition()
    {
        $this->assertSame($this->builder, $this->builder->name('test'));
        $this->assertSame($this->builder, $this->builder->call(array($this, __FUNCTION__)));
        $deferred = $this->builder->build();
        /** We want to test for the class exactly */
        $this->assertSame('Procrastinator\Deferred\CallbackDeferred', get_class($deferred));
        $this->assertSame('test', $deferred->getName());
        $this->assertSame(array($this, __FUNCTION__), $deferred->getCallback());
    }

    public function testDoctrineConditionalDeferredIsBuiltWithDoctrineCondition()
    {
        $this->assertSame($this->builder, $this->builder->name('test'));
        $this->assertSame($this->builder, $this->builder->call(array($this, __FUNCTION__)));
        $this->assertSame($this->builder, $this->builder->ifDoctrineEvent('postLoad'));
        $deferred = $this->builder->build();
        /** We want to test for the class exactly */
        $this->assertSame('Procrastinator\Deferred\DoctrineEventConditionalDeferred', get_class($deferred));
        $this->assertSame('test', $deferred->getName());
        $this->assertSame(array($this, __FUNCTION__), $deferred->getCallback());
    }
}
