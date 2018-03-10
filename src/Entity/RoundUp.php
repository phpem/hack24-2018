<?php

namespace App\Entity;

use App\Value\Money;
use App\Value\Uuid;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid as RamseyUuid;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoundUpRepository")
 */
class RoundUp
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    private $id;

    /**
     * @var Money
     * @ORM\Embedded(class="App\Value\Money")
     */
    private $value;

    /**
     * @var Transaction
     * @ORM\OneToOne(targetEntity="Transaction")
     */
    private $transaction;

    public function __construct(Money $value, Transaction $transaction)
    {
        $this->id = new Uuid(RamseyUuid::uuid4());
        $this->value = $value;
        $this->transaction = $transaction;
    }

    public static function forTransaction(Transaction $transaction): RoundUp
    {
        $currency = $transaction->amount()->currency();
        $transactionValue = $transaction->amount()->value();
        $value = ceil(0 - $transactionValue) - (0 - $transactionValue);

        return new self(new Money($currency, $value), $transaction);
    }
}
