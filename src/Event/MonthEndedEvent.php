<?php


namespace App\Event;


use App\Entity\Customer;
use App\Value\Period;
use Symfony\Component\EventDispatcher\Event;

class MonthEndedEvent extends Event
{
    const NAME = 'month.ended';

    /**
     * @var Customer
     */
    private $customer;
    /**
     * @var Period
     */
    private $period;

    public function __construct(Customer $customer, Period $period)
    {
        $this->customer = $customer;
        $this->period = $period;
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function getPeriod()
    {
        return $this->period;
    }
}