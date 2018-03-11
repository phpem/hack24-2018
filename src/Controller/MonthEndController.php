<?php


namespace App\Controller;


use App\Event\MonthEndedEvent;
use App\Repository\CustomerRepository;
use App\Value\Period;
use DateTimeImmutable;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Flex\Response;

class MonthEndController
{
    protected $dispatcher;
    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    public function __construct(EventDispatcherInterface $dispatcher, CustomerRepository $customerRepository)
    {
        $this->dispatcher = $dispatcher;
        $this->customerRepository = $customerRepository;
    }
    
    public function __invoke()
    {
        $customer = $this->customerRepository->find('652321fe-5168-455e-a2db-dff081b32d04');

        $period = new Period(new DateTimeImmutable('now - 1 month'), new DateTimeImmutable());

        $this->dispatcher->dispatch(MonthEndedEvent::NAME, new MonthEndedEvent($customer, $period));

        return new Response('');
    }
}