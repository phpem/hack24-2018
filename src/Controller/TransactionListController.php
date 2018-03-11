<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\RoundUp;
use App\Icons;
use App\Repository\RoundUpRepository;
use App\Starling;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TransactionListController extends Controller
{

    /** @var RoundUpRepository */
    private $repository;

    /** @var Starling */
    private $starling;

    public function __construct(Starling $starling, RoundUpRepository $repository)
    {
        $this->repository = $repository;
        $this->starling = $starling;
    }

    public function __invoke()
    {
        $roundUps  = $this->repository->getList();
        $icons = new Icons();
        $transactions = [];

        /** @var RoundUp $roundUp */
        foreach ($roundUps as $roundUp) {
            $transaction = $roundUp->transaction();
            $rawPayload = $transaction->getRawPayload();
            $transactions[] = [
                'icon' => $icons->get($rawPayload['merchantUid']),
                'counterParty' => $rawPayload['content']['counterParty'],
                'amount' => round($roundUp->value()->value(), 2),
                'timestamp' => $transaction->getTransactionDate()
            ];
        }

        /*
        $locations = [];
        $merchants = [];

        foreach ($transactions as $transaction) {
            $rawPayload = $transaction->getRawPayload();
            if (array_key_exists('merchantUid', $rawPayload)) {
                $merchants[$rawPayload['merchantUid']] = $this->starling->getMerchant($rawPayload['merchantUid']);
            }
            if (array_key_exists('merchantLocationUid', $rawPayload)) {
                $locations[$rawPayload['merchantUid']] = $this->starling->getMerchantLocation($rawPayload['merchantUid'], $rawPayload['merchantLocationUid']);
            }
        }
        */

        return $this->render('transactions.html.twig', [
            'transactions' => $transactions
        ]);
    }
}