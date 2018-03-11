<?php declare(strict_types=1);

namespace App\Controller;

use App\Repository\TransactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TransactionListController extends Controller
{

    /** @var TransactionRepository */
    private $repository;

    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke()
    {
        return $this->render('transactions.html.twig', [
            'transactions' => $this->repository->findAll(),
        ]);
    }
}