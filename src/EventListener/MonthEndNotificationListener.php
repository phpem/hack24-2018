<?php

namespace App\EventListener;

use App\Event\MonthEndedEvent;
use App\Notifications\Client;
use App\Notifications\Message;
use App\Repository\RoundUpRepository;

class MonthEndNotificationListener
{
    /**
     * @var Client
     */
    private $client;
    /**
     * @var RoundUpRepository
     */
    private $roundUpRepository;

    public function __construct(Client $client, RoundUpRepository $roundUpRepository)
    {
        $this->client = $client;
        $this->roundUpRepository = $roundUpRepository;
    }

    public function onMonthEnded(MonthEndedEvent $event)
    {
        $customer = $event->getCustomer();
        $period = $event->getPeriod();
        $totalSaved = $this->roundUpRepository->calculateMonthEnd(
            $customer->getId(),
            $period->getStart(),
            $period->getEnd()
        );

        $message = new Message();
        $message->setHighPriority();
        $message->setRecipient($customer->deviceId());
        $message->setData([
            'notification_type' => 'monthly_summary',
            'total_saved' => 10
        ]);

        $this->client->send($message);
    }


}