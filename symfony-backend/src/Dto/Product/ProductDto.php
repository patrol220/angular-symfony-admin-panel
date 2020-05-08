<?php

namespace App\Dto\Product;

class ProductDto {
    /**
     * @var string
     */
    private $name;

    /**
     * @var int|null
     */
    private $categoryId;

    /**
     * @var float|null
     */
    private $price;

    /**
     * @var float|null
     */
    private $weight;

    /**
     * ProductDto constructor.
     * @param string $name
     * @param int|null $categoryId
     * @param float|null $price
     * @param float|null $weight
     */
    public function __construct(string $name, ?int $categoryId, ?float $price, ?float $weight)
    {
        $this->name = $name;
        $this->categoryId = $categoryId;
        $this->price = $price;
        $this->weight = $weight;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int|null
     */
    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @return float|null
     */
    public function getWeight(): ?float
    {
        return $this->weight;
    }

}
