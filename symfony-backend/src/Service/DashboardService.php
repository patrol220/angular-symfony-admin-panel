<?php

namespace App\Service;

class DashboardService
{

    private $productService;

    public function __construct(
        ProductService $productService
    ) {
        $this->productService = $productService;
    }

    public function getStatistics(): array
    {
        return [
            'products' => $this->productService->getProductsStatistics()
        ];
    }
}
