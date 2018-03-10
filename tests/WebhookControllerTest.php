<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

class WebhookControllerTest extends WebTestCase {

    /** @var Client */
    private $client;

    public function setUp()
    {
        parent::setUp();

        $this->client = static::createClient();
    }

    public function testWebHookForTransaction()
    {
        $this->client->request('POST', '/webhook/transaction');

        $response = $this->client->getResponse()->getContent();

        $this->assertEquals('', $response);
    }
}