<?php

namespace CMEsteban\Lib;

abstract class Calendar
{
    public function __construct($name, $events)
    {
        $this->events = $events;

        $this->calendar = \Spatie\IcalendarGenerator\Components\Calendar::create($name);

        $this->parseEvents();
    }

    protected function parseEvents()
    {
        foreach ($this->events as $event) {
            $this->parseEvent($event);
        }
    }

    protected function parseEvent($event)
    {
    }

    public function __toString()
    {
        return $this->calendar->get();
    }
}
