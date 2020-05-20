<?php

namespace App\Transformer;

use App\Entity\Product\ProductCategory;
use League\Fractal\TransformerAbstract;

class ProductCategoryTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'parent',
    ];

    public function transform(?ProductCategory $category)
    {
        if ($category === null) {
            return null;
        }

        return [
            'id' => $category->getId(),
            'name' => $category->getName(),
        ];
    }

    public function includeParent(ProductCategory $category)
    {
        return $category->getParent() !== null ? $this->item($category->getParent(), $this) : null;
    }
}
