<?php

namespace App\Calculator;

use App\Entity\RoundUp;
use App\Entity\Transaction;
use App\Event\RoundUpCalculatedEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class RoundupCalculator
{

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function calculate(Transaction $transaction): RoundUp
    {
        $roundup = RoundUp::forTransaction($transaction);

        $this->dispatcher->dispatch(RoundUpCalculatedEvent::NAME, new RoundUpCalculatedEvent($roundup));

        return $roundup;
    }
}
