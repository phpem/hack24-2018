<?php

namespace App\Controller\Webhook;

use App\Entity\Transaction;
use App\Repository\TransactionRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StarlingController
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var TransactionRepository
     */
    private $repository;

    public function __construct(LoggerInterface $logger, TransactionRepository $repository)
    {
        $this->logger = $logger;
        $this->repository = $repository;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $transaction = Transaction::fromStarling($request->getContent());
        } catch (\Throwable $e) {
            return new JsonResponse([], Response::HTTP_BAD_REQUEST);
        }

        $this->repository->save($transaction);

        return new JsonResponse([], Response::HTTP_CREATED);
    }
}
