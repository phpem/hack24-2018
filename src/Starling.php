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

    public function addToSavingsGoal(Money $amount): void
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

    public function getBalance()
    {
        $response = $this->client->get(
            'https://api-sandbox.starlingbank.com/api/v1/accounts/balance',
            [
                'headers' => [
                    'Authorization' => "Bearer {$this->accessToken}",
                    'Content-Type' => 'application/json'
                ],
            ]
        );

        $content = $response->getBody()->getContents();

        $content = json_decode($content, true);

        return $content['effectiveBalance'];
    }

    public function getCardTransactions(): array
    {
        $response = $this->client->get(
            'https://api-sandbox.starlingbank.com/api/v1/transactions/mastercard',
            [
                'headers' => [
                    'Authorization' => "Bearer {$this->accessToken}",
                    'Content-Type' => 'application/json'
                ],
            ]
        );

        $content = $response->getBody()->getContents();

        $content = json_decode($content, true);

        return array_map(function($transaction){
            unset($transaction['_links']);
            return $transaction;

        }, $content['_embedded']['transactions']);
    }

    public function getMerchant(string $merchantId): array
    {
        $response = $this->client->get(
            "https://api-sandbox.starlingbank.com/api/v1/merchants/{$merchantId}",
            [
                'headers' => [
                    'Authorization' => "Bearer {$this->accessToken}",
                    'Content-Type' => 'application/json'
                ],
            ]
        );

        $content = $response->getBody()->getContents();

        return json_decode($content, true);
    }

    public function getMerchantLocation(string $merchantId, string $locationId): array
    {
        $response = $this->client->get(
            "https://api-sandbox.starlingbank.com/api/v1/merchants/{$merchantId}/locations/{$locationId}",
            [
                'headers' => [
                    'Authorization' => "Bearer {$this->accessToken}",
                    'Content-Type' => 'application/json'
                ],
            ]
        );

        $content = $response->getBody()->getContents();

        return json_decode($content, true);
    }
}
