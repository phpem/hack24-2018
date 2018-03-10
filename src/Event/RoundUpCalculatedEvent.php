<?php

namespace App\Event;

use App\Entity\RoundUp;
use Symfony\Component\EventDispatcher\Event;

class RoundUpCalculatedEvent extends Event
{

    const NAME = 'roundup.calculated';

    /**
     * @var RoundUp
     */
    private $roundUp;

    public function __construct(RoundUp $roundUp)
    {
        $this->roundUp = $roundUp;
    }

    public function getRoundUp(): RoundUp
    {
        return $this->roundUp;
    }
}
