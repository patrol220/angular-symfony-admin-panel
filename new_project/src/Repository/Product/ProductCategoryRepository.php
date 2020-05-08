<?php

namespace App\Repository\Product;

use App\Dto\Request\FiltersDto;
use App\Dto\Request\SortDto;
use App\Entity\Product\ProductCategory;
use App\Repository\AbstractRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProductCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductCategory[]    findAll()
 * @method ProductCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductCategoryRepository extends AbstractRepository {
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductCategory::class);
    }

    public function getSortedAndFilteredCategoriesQueryBuilder(SortDto $sortDto, FiltersDto $filtersDto)
    {
        $queryBuilder = $this->createQueryBuilder('c');

        if($filtersDto->getFilters() !== null) {
            $filters = $filtersDto->getFilters();
            $this->addLikeFilter($queryBuilder, 'name', $filters['name']);
        }

        $this->addSort($queryBuilder, $sortDto);

        return $queryBuilder;
    }
}
