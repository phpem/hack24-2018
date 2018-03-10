<?php

namespace App\Calculator;

use App\Entity\RoundUp;
use App\Entity\Transaction;

class RoundupCalculator
{
    public function calculate(Transaction $transaction): RoundUp
    {
        return new RoundUp;
    }
}
