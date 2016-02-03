<?php

namespace EventSource;

/**
 * Encapsulates an event. Handlers can be added and/or removed using the {@code Event::on} and {@code Event::remove} methods.
 *
 * @package EventSource
 */
class Event
{
    /**
     * @var callable[]
     */
    private $handlers = [];

    /**
     * Add an event handler
     *
     * @param callable $handler
     */
    public function on(callable $handler)
    {
        $this->handlers[] = $handler;
    }

    /**
     * Remove an event handler
     *
     * @param callable $handler
     */
    public function remove(callable $handler)
    {
        $index = array_search($handler, $this->handlers, true);
        if ($index !== false) {
            unset($this->handlers[ $index ]);
        }
    }

    /**
     * Trigger the event
     *
     * @param $parameter
     */
    public function raise($parameter = null)
    {
        foreach ($this->handlers as $handler) {
            $handler($parameter);
        }
    }
}