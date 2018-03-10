<?php

namespace App\EventListener;

use App\Event\RoundUpCalculatedEvent;
use App\Notifications\Client;
use App\Notifications\Message;

class SendSavedNotificationListener
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function onRoundupCalculated(RoundUpCalculatedEvent $event)
    {
        $message = new Message();
        $message->setRecipient((string)$event->getRoundUp()->transaction()->customer()->deviceId());
        $message->setData([
            'roundUp' => $event->getRoundUp()->value(),
            'merchant' => 'DoughNotts'
        ]);
        $message->setHighPriority();

        $this->client->send($message);
    }
}