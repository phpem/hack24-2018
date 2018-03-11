<?php

namespace App;

use App\Value\Money;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Ramsey\Uuid\Uuid;

class Starling
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var string
     */
    private $savingsGoal;

    public function __construct(Client $client, string $accessToken, string $savingsGoal)
    {
        $this->client = $client;
        $this->accessToken = $accessToken;
        $this->savingsGoal = $savingsGoal;
    }

    public function addToSavingsGoal(Money $amount)
    {
        $transferId = (string) Uuid::uuid4();
        $this->client->put(
            "https://api-sandbox.starlingbank.com/api/v1/savings-goals/{$this->savingsGoal}/add-money/{$transferId}",
            [
                'headers' => [
                    'Authorization' => "Bearer {$this->accessToken}",
                    'Content-Type' => 'application/json'
                ],
                RequestOptions::JSON => [
                    'amount' => [
                        'currency' => $amount->currency(),
                        'minorUnits' => round($amount->value() * 100)
                    ]
                ],
            ]
        );
    }
}
