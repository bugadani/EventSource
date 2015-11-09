<?php

namespace EventSource;

trait EventSourceTrait
{
    /**
     * @var Event[]
     */
    private $events = [];

    /**
     * @param string[] $eventNames
     */
    protected function initialize(array $eventNames)
    {
        if (!empty($this->events)) {
            throw new \BadMethodCallException('Event source is already initialized');
        }
        foreach ($eventNames as $eventName) {
            $this->events[ $eventName ] = new Event();
        }
    }

    /**
     * Add a handler to a specific event
     *
     * @param          $eventName
     * @param callable $handler
     */
    public function on($eventName, callable $handler)
    {
        $this->guardEvent($eventName);
        $this->events[ $eventName ]->on($handler);
    }

    /**
     * Remove an event handler
     *
     * @param          $eventName
     * @param callable $handler
     */
    public function remove($eventName, callable $handler)
    {
        if (isset($this->events[ $eventName ])) {
            $this->events[ $eventName ]->remove($handler);
        }
    }

    /**
     * Raise an event with an additional optional parameter
     *
     * @param          $eventName
     * @param mixed $parameter
     */
    protected function raise($eventName, $parameter = null)
    {
        $this->guardEvent($eventName);
        $this->events[ $eventName ]->raise($parameter);
    }

    /**
     * @param $eventName
     */
    private function guardEvent($eventName)
    {
        if (!isset($this->events[ $eventName ])) {
            throw new \InvalidArgumentException("Event '{$eventName}' is not defined");
        }
    }
}