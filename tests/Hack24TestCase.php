<?php declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class Hack24TestCase extends WebTestCase
{
    /** @var Client */
    protected $client;

    public function setUp()
    {
        parent::setUp();

        $this->client = static::createClient();
    }

    protected function assertStatusCode(int $statusCode): void
    {
        $response = $this->client->getResponse();
        $this->assertEquals($statusCode, $response->getStatusCode());
    }

    protected function getDecodedResponse()
    {
        $response = $this->client->getResponse()->getContent();

        return json_decode($response, true);
    }

    protected function doRequest(string $method, string $url, string $body): void
    {
        $this->client->request($method, $url, [], [], [], $body);
    }
}