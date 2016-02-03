EventSource
=========

EventSource is a simple library for PHP 5.4+ to create event source objects.

Usage
---------

### EventSource trait

When you wish to make one of your classes an event source, simply use the EventSource trait in them and call the
initializer method.

    class SomeClass {
        use EventSource\EventSource;

        public function __construct() {
            //initialize defines the events that can be used
            $this->initialize(['fooEvent', 'barEvent']);
        }

        public function someMethod() {
            $this->raise('fooEvent', $someOptionalParameter);
        }
    }

You can use the `on($eventName, $callback)` method to define event handlers which will be notified if the given event is raised.

    $someObject = new SomeClass();
    $someObject->on('fooEvent', function($someParameter = null) {
        //do something
    });

You can also remove event handlers using the `remove($eventName, $callback)` method.

### Event class

Alternatively, you have the option to manually create Event objects that are used by EventSource to manage the event handlers.
The Event class has the following methods:

 * `on($callback)` - register a new callback to handle the event
 * `remove($callback)` - removes a previously registered callback
 * `raise(optional $parameter)` - raises the event

One downside is when using the Event class directly is that `raise()` is a public method, so any outside code may
trigger events.

Installation
---------

### Using Composer

    "require": {
        "bugadani/event_source": "dev-master"
    }
