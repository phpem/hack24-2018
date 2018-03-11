<?php declare(strict_types=1);

namespace App\Controller;

use App\Client\StarlingClient;
use App\Starling;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AuthController extends Controller
{
    /** @var Starling */
    private $starling;

    public function __construct( Starling $starling)
    {
        $this->starling = $starling;
    }

    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse([
            'balance' => $this->starling->getBalance(),
            'transactions' => $this->starling->getCardTransactions(),
        ]);
    }
}

