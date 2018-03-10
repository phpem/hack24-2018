<?php declare(strict_types=1);

namespace App\Tests;

use Symfony\Component\HttpFoundation\Response;

class AuthControllerTest extends Hack24TestCase
{
    public function testAuth()
    {
        $queryParams = [
            'access_token' => 'chicken',
            'refresh_token' => '🐔',
        ];

        $this->doRequest('GET', '/auth?' . http_build_query($queryParams), '');

        $response = $this->getDecodedResponse();

        $this->assertStatusCode(Response::HTTP_OK);
        $this->assertEquals(['balance' => -71108.39], $response);
    }
}