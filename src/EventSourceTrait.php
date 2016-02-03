<?php

namespace EventSource;

/**
 * EventSourceTrait adds event source functionality to an object. To define events, one must call the {@code initialize}
 * method with an array of event names. Event handlers can be added and removed via the {@code EventSourceTrait::on}
 * and {@code EventSourceTrait::remove} methods.
 *
 * @package EventSource
 */
trait EventSourceTrait
{
    /**
     * @var Event[]
     */
    private $events;

    /**
     * @param string[] $eventNames
     */
    protected function initialize(array $eventNames)
    {
        if ($this->events !== null) {
            throw new \BadMethodCallException('Event source is already initialized');
        }
        $this->events = [];
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
     * @param mixed    $parameter
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