<?php

namespace App\Entity;

use App\Value\Money;
use Doctrine\ORM\Mapping as ORM;
use App\Value\Uuid;

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

    /**
     * @var array
     * @ORM\Column(type="json")
     */
    private $rawPayload;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime")
     */
    private $transactionDate;

    /**
     * @var Customer
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="transactions")
     */
    private $customer;

    private function __construct(Uuid $id, Customer $customer, Money $amount, \DateTimeImmutable $transactionDate,
        string $rawPayload)
    {
        $this->id = $id;
        $this->customer = $customer;
        $this->amount = $amount;
        $this->rawPayload = $rawPayload;
        $this->transactionDate = $transactionDate;
    }

    public static function fromStarling(Customer $customer, string $payload): Transaction
    {
        $decodedPayload = json_decode($payload, true);

        return new self(
            new Uuid($decodedPayload['uid']),
            $customer,
            new Money(
                $decodedPayload['content']['sourceCurrency'],
                $decodedPayload['content']['amount']
            ),
            new \DateTimeImmutable($decodedPayload['timestamp']),
            $payload
        );
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function amount(): Money
    {
        return $this->amount;
    }

    public function isOutgoing(): bool
    {
        return $this->amount->value() < 0;
    }

    /**
     * @return Customer
     */
    public function customer(): Customer
    {
        return $this->customer;
    }
}
