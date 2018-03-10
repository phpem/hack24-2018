<?php

namespace App\Event;

use App\Entity\Transaction;
use Symfony\Component\EventDispatcher\Event;

class TransactionCreatedEvent extends Event
{

    const NAME = 'transaction.created';

    /**
     * @var Transaction
     */
    private $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function getTransaction(): Transaction
    {
        return $this->transaction;
    }
}
