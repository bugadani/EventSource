EventSource
=========

EventSource is a simple library for PHP 5.4 and later to create event source objects.

Usage
---------
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

Installation
---------

### Using Composer

    "require": {
        "bugadani/event_source": "dev-master"
    }
