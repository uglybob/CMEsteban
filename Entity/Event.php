<?php

namespace BH\Entity;

class Event extends Entity
{
    // {{{ variables
    protected $name;
    protected $bandId;
    protected $allDayEvent;
    protected $venueId; // or location
    protected $startTime;
    protected $endTime;
    // }}}
}
