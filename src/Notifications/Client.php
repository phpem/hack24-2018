<?php

namespace App\Notifications;

interface Client
{
    public function send(Message $message);
}