<?php

namespace EventSource;

trait EventSourceTrait
{
    private $handlers = [];

    /**
     * @param string[] $eventNames
     */
    protected function initialize(array $eventNames)
    {
        if (!empty($this->handlers)) {
            throw new \BadMethodCallException('Event source is already initialized');
        }
        foreach ($eventNames as $eventName) {
            $this->handlers[ $eventName ] = [];
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
        $this->handlers[ $eventName ][] = $handler;
    }

    /**
     * Remove an event handler
     *
     * @param          $eventName
     * @param callable $handler
     */
    public function remove($eventName, callable $handler)
    {
        if (isset($this->handlers[ $eventName ])) {
            $index = array_search($handler, $this->handlers[ $eventName ]);
            if ($index !== false) {
                unset($this->handlers[ $eventName ][ $index ]);
            }
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
        foreach ($this->handlers[ $eventName ] as $handler) {
            call_user_func($handler, $parameter);
        }
    }

    /**
     * @param $eventName
     */
    private function guardEvent($eventName)
    {
        if (!isset($this->handlers[ $eventName ])) {
            throw new \InvalidArgumentException("Event '{$eventName}' is not defined");
        }
    }
}