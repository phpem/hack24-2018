<?php

namespace App\EventListener;

use App\Calculator\RoundupCalculator;
use App\Event\TransactionCreatedEvent;
use App\Repository\RoundUpRepository;

class CalculateRoundupListener
{

    /**
     * @var RoundupCalculator
     */
    private $calculator;

    /**
     * @var RoundUpRepository
     */
    private $repository;

    public function __construct(RoundupCalculator $calculator, RoundUpRepository $repository)
    {
        $this->calculator = $calculator;
        $this->repository = $repository;
    }

    public function onTransactionCreated(TransactionCreatedEvent $event)
    {
        $roundup = $this->calculator->calculate($event->getTransaction());

        $this->repository->save($roundup);
    }
}
