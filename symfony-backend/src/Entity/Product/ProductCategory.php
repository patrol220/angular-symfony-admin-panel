<?php

namespace App\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Table(name="category", schema="products", uniqueConstraints={@UniqueConstraint(name="category_idx", columns={"name", "parent_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\Product\ProductCategoryRepository")
 */
class ProductCategory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var $parent ProductCategory|null
     * @ORM\ManyToOne(targetEntity="ProductCategory")
     */
    private $parent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getParent(): ?ProductCategory
    {
        return $this->parent;
    }

    public function setParent(?ProductCategory $parent): void
    {
        $this->parent = $parent;
    }
}
