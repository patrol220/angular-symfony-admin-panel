<?php

namespace App\Transformer;

use App\Entity\Product\Product;
use DateTime;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'category'
    ];

    public function transform(Product $product)
    {
        return [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'weight' => $product->getWeight(),
            'price' => $product->getPrice(),
            'created' => $product->getCreated()->format(DateTime::ISO8601),
            'updated' => $product->getUpdated()->format(DateTime::ISO8601),
        ];
    }

    public function includeCategory(Product $product)
    {
        if ($product->getCategory() === null) {
            return null;
        }

        return $this->item($product->getCategory(), new ProductCategoryTransformer());
    }
}
