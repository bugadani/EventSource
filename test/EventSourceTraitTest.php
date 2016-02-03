<?php

namespace EventSource\Test;

use EventSource\Test\Mocks\TestClass;

class EventSourceTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testUninitializedThrowsException()
    {
        $source = new TestClass();
        $source->on(
            'event',
            function () {
            }
        );
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testDoubleInitThrowsException()
    {
        $source = new TestClass();
        $source->init();
        $source->init();
    }

    public function testInitializedDoesNotThrow()
    {
        $source = new TestClass();
        $source->init();
        $source->trigger('event');

        return $source;
    }

    /**
     * @depends testInitializedDoesNotThrow
     */
    public function testCallbackIsCalled(TestClass $source)
    {
        $called = 0;
        $source->on(
            'event',
            function () use (&$called) {
                $called = 5;
            }
        );
        $source->on(
            'otherEvent',
            function () use (&$called) {
                $called = 3;
            }
        );
        $source->on(
            'otherEvent',
            function () use (&$called) {
                $called++;
            }
        );

        $source->trigger('event');
        $this->assertEquals(5, $called);

        $source->trigger('otherEvent');

        $this->assertEquals(4, $called);
    }

    public function testCallbackCanBeRemoved()
    {
        $called      = false;
        $otherCalled = false;

        $callback    = function () use (&$called) {
            $called = true;
        };
        $source      = new TestClass();
        $source->init();

        $source->on(
            'event',
            function () use (&$otherCalled) {
                $otherCalled = true;
            }
        );
        $source->on('event', $callback);
        $source->remove('event', $callback);

        $source->trigger('event');
        $this->assertFalse($called);
        $this->assertTrue($otherCalled);
    }
}
