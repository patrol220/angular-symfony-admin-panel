<?php

namespace App\MessageHandler\Product;

use App\Message\Product\NewProductAdded;
use App\Service\ProductService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class HandleNewProductAdded implements MessageHandlerInterface
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function __invoke(NewProductAdded $newProductAdded)
    {
        $this->productService->refreshProductsStatisticsCache();
    }
}
