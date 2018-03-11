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
            'notification_type' => 'savings',
            'round_up' => round($event->getRoundUp()->value()->value() * 100, 2),
            'merchant' => $this->getMerchant($event->getRoundUp()->transaction()->getRawPayload())
        ]);
        $message->setHighPriority();

        $this->client->send($message);
    }

    protected function getMerchant(array $payload)
    {
        return $payload['content']['counterParty'];
    }
}