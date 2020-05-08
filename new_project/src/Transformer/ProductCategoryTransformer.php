<?php

namespace App\Transformer;

use App\Entity\Product\ProductCategory;
use League\Fractal\TransformerAbstract;

class ProductCategoryTransformer extends TransformerAbstract
{
    public function transform(ProductCategory $category)
    {
        return [
            'id' => $category->getId(),
            'name' => $category->getName(),
            'parent' => $category->getParent() !== null ? $category->getParent()->getId() : null
        ];
    }
}
