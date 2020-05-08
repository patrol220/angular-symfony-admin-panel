<?php

namespace App\Dto\Product\Factory;

use App\Dto\Product\ProductDto;
use Symfony\Component\HttpFoundation\Request;

class ProductDtoFactory
{
    public static function createFromRequest(Request $request): ProductDto
    {
        $requestContent = json_decode($request->getContent(), true);

        return new ProductDto(
            isset($requestContent['name']) ? $requestContent['name'] : null,
            isset($requestContent['category_id']) ? $requestContent['category_id'] : null,
            isset($requestContent['price']) ? $requestContent['price'] : null,
            isset($requestContent['weight']) ? $requestContent['weight'] : null
        );
    }
}
