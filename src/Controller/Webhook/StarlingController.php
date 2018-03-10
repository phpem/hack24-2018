<?php

namespace App\Controller\Webhook;

use App\Entity\Transaction;
use App\Event\TransactionCreatedEvent;
use App\Repository\TransactionRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
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

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    public function __construct(
        TransactionRepository $repository,
        EventDispatcherInterface $dispatcher
    ) {
        $this->repository = $repository;
        $this->dispatcher = $dispatcher;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $transaction = Transaction::fromStarling($request->getContent());

            if ( ! $transaction->isOutgoing() || $this->repository->find($transaction->id()) instanceof Transaction) {
                return new JsonResponse([], Response::HTTP_ACCEPTED);
            }

        } catch (\Throwable $e) {
            return new JsonResponse([], Response::HTTP_BAD_REQUEST);
        }

        $this->repository->save($transaction);
        $this->dispatcher->dispatch(TransactionCreatedEvent::NAME, new TransactionCreatedEvent($transaction));

        return new JsonResponse([], Response::HTTP_CREATED);
    }
}
