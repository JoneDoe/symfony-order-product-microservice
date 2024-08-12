<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Request\OrderCreateRequest;
use App\Service\OrderService;
use App\Transformer\OrderTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Exception\ValidatorException;

#[Route('/api', name: 'api')]
class MainController extends AbstractController
{
    public function __construct(
        private readonly OrderService $orderService,
        private readonly OrderRepository $orderRepository,
        private readonly OrderTransformer $orderTransformer
    ) {
    }

    #[Route('/orders', name: 'order_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $orders = $this->orderRepository->findAll();

        return $this->json($this->orderTransformer->transformToList($orders));
    }

    #[Route('/orders/{id}', name: 'order_view', methods: ['GET'])]
    public function view(Order $order): JsonResponse
    {
        return $this->json($this->orderTransformer->transform($order));
    }

    #[Route('/orders', name: 'order_create', methods: ['POST'])]
    public function create(#[MapRequestPayload] OrderCreateRequest $productReview): JsonResponse
    {
        try {
            $order = $this->orderService->create($productReview);
        } catch (\InvalidArgumentException $e) {
            throw new HttpException(400, $e->getMessage());
        }

        return $this->json($this->orderTransformer->transform($order));
    }
}
