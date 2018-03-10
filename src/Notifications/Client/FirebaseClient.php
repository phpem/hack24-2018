<?php

namespace App\Notifications\Client;

use App\Notifications\Client;
use App\Notifications\Message;
use sngrl\PhpFirebaseCloudMessaging\Client as PhpFirebaseCloudMessagingClient;
use sngrl\PhpFirebaseCloudMessaging\Message as FirebaseMessage;
use sngrl\PhpFirebaseCloudMessaging\Notification;
use sngrl\PhpFirebaseCloudMessaging\Recipient\Device;

class FirebaseClient implements Client
{
    /**
     * @var PhpFirebaseCloudMessagingClient
     */
    private $client;

    public function __construct(PhpFirebaseCloudMessagingClient $client)
    {

        $this->client = $client;
    }

    public function send(Message $message)
    {
        $firebaseMessage = new FirebaseMessage();
        $firebaseMessage->setPriority($message->getPriority());
        $firebaseMessage->addRecipient(new Device($message->getRecipient()));
        $firebaseMessage->setNotification(new Notification($message->getTitle(), $message->getMessage()));

        if (!is_null($message->getData())) {
            $firebaseMessage->setData($message->getData());
        }

        $this->client->send($firebaseMessage);
    }
}