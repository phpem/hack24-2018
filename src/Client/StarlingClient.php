<?php declare(strict_types=1);

namespace App\Client;

use Starling\Api\Client;
use Starling\Api\Request\Accounts\Balance;
use Starling\Api\Request\Transactions\Card;
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
        $body = $this->doRequest($request);

        return $body['effectiveBalance'];
    }

    public function getCardTransactions()
    {
        $request = new Card();
        $body = $this->doRequest($request);

        return array_map(function($transaction){
            unset($transaction['_links']);
            return $transaction;

        }, $body['_embedded']['transactions']);
    }

    private function doRequest($request)
    {
        $result = $this->client->request($request);

        return json_decode((string)$result->getBody(), true);
    }

    public static function instance(string $authToken): StarlingClient
    {
        return new StarlingClient($authToken);
    }
}