<?php

namespace App\Value;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
final class Money
{

    /**
     * @var
     * @ORM\Column(type="string")
     */
    private $value;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $currency;

    public function __construct(string $currency, $amount)
    {
        $this->value = round((float) $amount, 2);
        $this->currency = $currency;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function currency(): string
    {
        return $this->currency;
    }
}
