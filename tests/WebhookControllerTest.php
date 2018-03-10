<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\HttpFoundation\Response;

class WebhookControllerTest extends Hack24TestCase {

    public function testReturnsBadRequestForInvalidPayload()
    {
        $this->doRequest('POST', '/webhook/transaction', 'BAD CONTENT');

        $this->assertStatusCode(Response::HTTP_BAD_REQUEST);
        $this->assertEquals([], $this->getDecodedResponse());
    }
}