<?php

namespace App\EventListener;

use App\Calculator\RoundupCalculator;
use App\Event\RoundUpCalculatedEvent;
use App\Event\TransactionCreatedEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CalculateRoundupListener
{

    /**
     * @var RoundupCalculator
     */
    private $calculator;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    public function __construct(RoundupCalculator $calculator, EventDispatcherInterface $dispatcher)
    {
        $this->calculator = $calculator;
        $this->dispatcher = $dispatcher;
    }

    public function onTransactionCreated(TransactionCreatedEvent $event)
    {
        $transaction = $event->getTransaction();

        $roundup = $this->calculator->calculate($transaction);

        $this->dispatcher->dispatch(RoundUpCalculatedEvent::NAME, new RoundUpCalculatedEvent($roundup));
    }
}
