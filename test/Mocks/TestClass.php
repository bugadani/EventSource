<?php

namespace EventSource\Test\Mocks;

use EventSource\EventSourceTrait;

class TestClass
{
    use EventSourceTrait;

    public function init()
    {
        $this->initialize(['event', 'otherEvent']);
    }

    public function trigger($eventName, $param = null)
    {
        //publish the otherwise protected raise()
        $this->raise($eventName, $param);
    }
}