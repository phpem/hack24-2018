<?php

namespace App\EventListener;

use App\Event\RoundUpCalculatedEvent;
use App\Starling;

class AddToStarlingGoalListener
{
    /**
     * @var Starling
     */
    private $starling;

    public function __construct(Starling $starling)
    {
        $this->starling = $starling;
    }

    public function onRoundupCalculated(RoundUpCalculatedEvent $event)
    {
        $roundUp = $event->getRoundUp();

        $this->starling->addToSavingsGoal($roundUp->value());
    }
}
