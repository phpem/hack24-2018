<?php

namespace App\Entity;

use App\Value\Money;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction
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
    private $amount;


    private function __construct(Money $amount)
    {
        $this->id = Uuid::uuid4();
        $this->amount = $amount;
    }

    public static function forAmount(Money $amount): Transaction
    {
        return new self($amount);
    }

    public function amount(): Money
    {
        return $this->amount;
    }
}
