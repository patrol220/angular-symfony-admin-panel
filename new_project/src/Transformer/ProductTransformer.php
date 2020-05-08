<?php

namespace App\Transformer;

use App\Entity\Product\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    public function transform(Product $product)
    {
        $category = $product->getCategory() === null ? null : [
            'id' => $product->getCategory()->getId(),
            'name' => $product->getCategory()->getName()
        ];

        return [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'weight' => $product->getWeight(),
            'price' => $product->getPrice(),
            'category' => $category
        ];
    }
}
