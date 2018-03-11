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
            'transactions' => $transactions,
         //   'locations'    => $locations,
         //   'merchants'    => $merchants,
        ]);
    }
}