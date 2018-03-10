<?php declare(strict_types=1);

namespace App\Controller;

use App\Client\StarlingClient;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AuthController extends Controller
{
    /** @var StarlingClient */
    private $client;

    public function __construct(StarlingClient $client)
    {
        $this->client = $client;
    }

    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse([
            'balance' => $this->client->getBalance(),
            'transactions' => $this->client->getCardTransactions(),
        ]);
    }
}

