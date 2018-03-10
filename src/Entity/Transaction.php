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

    private function __construct(Uuid $id, Money $amount, \DateTimeImmutable $transactionDate, string $rawPayload)
    {
        $this->id = $id;
        $this->amount = $amount;
        $this->rawPayload = $rawPayload;
        $this->transactionDate = $transactionDate;
    }

    public static function fromStarling(string $payload): Transaction
    {
        $decodedPayload = json_decode($payload, true);

        return new self(
            new Uuid($decodedPayload['uid']),
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
}
