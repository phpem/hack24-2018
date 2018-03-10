<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\HttpFoundation\Response;

class StarlingControllerTest extends Hack24TestCase {

    public function testReturnsBadRequestForInvalidPayload(): void
    {
        $this->doRequest('POST', '/webhook/transaction', 'BAD CONTENT');

        $this->assertStatusCode(Response::HTTP_BAD_REQUEST);
        $this->assertEquals([], $this->getDecodedResponse());
    }

    public function testContactlessTransactionCreatesNewTransaction(): void
    {
        $payload = file_get_contents(__DIR__ . '/fixtures/card-payment.json');

        $this->doRequest('POST', '/webhook/transaction', $payload);

        $this->assertStatusCode(Response::HTTP_CREATED);
        $this->assertEquals([], $this->getDecodedResponse());
    }
}