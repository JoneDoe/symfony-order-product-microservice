<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Request\ProductCreateRequest;
use App\Service\ProductService;
use App\Transformer\ProductTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api', name: 'api')]
class ProductController extends AbstractController
{
    public function __construct(
        private readonly ProductService $productService,
        private readonly ProductRepository $productRepository,
        private readonly ProductTransformer $productTransformer
    ) {
    }

    #[Route('/products', name: 'product_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $products = $this->productRepository->findAll();

        return $this->json($this->productTransformer->transformToList($products));
    }

    #[Route('/products/{id}', name: 'product_view', methods: ['GET'])]
    public function view(Product $product): JsonResponse
    {
        return $this->json($this->productTransformer->transform($product));
    }

    #[Route('/products', name: 'product_create', methods: ['POST'])]
    public function create(#[MapRequestPayload] ProductCreateRequest $productReview): JsonResponse
    {
        $product = $this->productService->createProduct($productReview);

        return $this->json($this->productTransformer->transform($product));
    }

    #[Route('/products/{id}', name: 'product_update', methods: ['PUT'])]
    public function update(#[MapRequestPayload] ProductCreateRequest $productReview, Product $product): JsonResponse
    {
        $product = $this->productService->updateProduct($product, $productReview);

        return $this->json($this->productTransformer->transform($product));
    }
}
