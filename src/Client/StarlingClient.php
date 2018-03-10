<?php declare(strict_types=1);

namespace App\Client;

use Starling\Api\Client;
use Starling\Api\Request\Accounts\Balance;
use Starling\Identity;

class StarlingClient
{
    private $client;

    public function __construct(string $authToken)
    {
        $identity = new Identity($authToken);
        $this->client = new Client($identity, ['env' => 'sandbox']);
    }

    public function getBalance()
    {
        $request = new Balance();
        $result = $this->client->request($request);
        $body = json_decode((string)$result->getBody(), true);

        return $body['effectiveBalance'];
    }

    public static function instance(string $authToken): StarlingClient
    {
        return new StarlingClient($authToken);
    }
}