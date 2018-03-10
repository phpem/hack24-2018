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
        $this->value = (string) $amount;
        $this->currency = $currency;
    }
}
