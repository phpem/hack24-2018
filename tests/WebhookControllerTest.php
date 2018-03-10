<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\HttpFoundation\Response;

class WebhookControllerTest extends WebTestCase {

    /** @var Client */
    private $client;

    public function setUp()
    {
        parent::setUp();

        $this->client = static::createClient();
    }

    public function testReturnsBadRequestForInvalidPayload()
    {
        $this->client->request('POST', '/webhook/transaction', [], [], [], 'BAD CONTENT');

        $this->assertStatusCode(Response::HTTP_BAD_REQUEST);
        $this->assertEquals([], $this->getDecodedResponse());
    }

    protected function assertStatusCode(int $statusCode): void
    {
        $response = $this->client->getResponse();
        $this->assertEquals($statusCode, $response->getStatusCode());
    }

    protected function getDecodedResponse(): ?array
    {
        $response = $this->client->getResponse()->getContent();

        return json_decode($response, true);
    }
}