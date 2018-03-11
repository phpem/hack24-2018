<?php declare(strict_types=1);

namespace App\Controller;

use App\Repository\TransactionRepository;
use App\Starling;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TransactionListController extends Controller
{

    /** @var TransactionRepository */
    private $repository;
    /** @var Starling */
    private $starling;

    public function __construct(Starling $starling, TransactionRepository $repository)
    {
        $this->repository = $repository;
        $this->starling = $starling;
    }

    public function __invoke()
    {
        $transactions  = $this->repository->findAll();

        /*
        foreach ($transactions as $transaction) {
            $rawPayload = $transaction->getRawPayload();
            dump($rawPayload);
            if (array_key_exists('merchantUid', $rawPayload)) {
                $merchant = $this->starling->getMerchant($rawPayload['merchantUid']);
                dump($merchant);
            }
            if (array_key_exists('merchantLocationUid', $rawPayload)) {
                $location = $this->starling->getMerchantLocation($rawPayload['merchantUid'], $rawPayload['merchantLocationUid']);
                dump($location);
            }
        }
        */

        return $this->render('transactions.html.twig', [
            'transactions' => $transactions,
        ]);
    }
}