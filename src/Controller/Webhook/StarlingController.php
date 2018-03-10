<?php

namespace App\Controller\Webhook;

use App\Entity\Customer;
use App\Entity\Transaction;
use App\Event\TransactionCreatedEvent;
use App\Repository\CustomerRepository;
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
    private $transactionRepository;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    public function __construct(
        TransactionRepository $repository,
        CustomerRepository $customerRepository,
        EventDispatcherInterface $dispatcher
    ) {
        $this->transactionRepository = $repository;
        $this->customerRepository = $customerRepository;
        $this->dispatcher = $dispatcher;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $content = $request->getContent();
            $decodedContent = json_decode($content, true);

            if ($decodedContent === false) {
                return new JsonResponse([], Response::HTTP_BAD_REQUEST);
            }

            $customerId = $decodedContent['customerUid'];
            $customer = $this->customerRepository->find($customerId);

            if ($customer === null) {
                return new JsonResponse([], Response::HTTP_BAD_REQUEST);
            }

            $transaction = Transaction::fromStarling($customer, $content);

            if ( ! $transaction->isOutgoing() || $this->transactionRepository->find($transaction->id()) instanceof Transaction) {
                return new JsonResponse([], Response::HTTP_ACCEPTED);
            }

        } catch (\Throwable $e) {
            return new JsonResponse([], Response::HTTP_BAD_REQUEST);
        }

        $this->transactionRepository->save($transaction);
        $this->dispatcher->dispatch(TransactionCreatedEvent::NAME, new TransactionCreatedEvent($transaction));

        return new JsonResponse([], Response::HTTP_CREATED);
    }
}
