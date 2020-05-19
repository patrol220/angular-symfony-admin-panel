<?php

namespace App\Service;

use App\Dto\Request\FiltersDto;
use App\Dto\Request\IncludesDto;
use App\Dto\Request\PaginationDto;
use App\Dto\Request\SortDto;
use App\Entity\Product\ProductCategory;
use App\Repository\Product\ProductCategoryRepository;
use App\Transformer\ProductCategoryTransformer;
use Doctrine\ORM\EntityManagerInterface;
use League\Fractal\Manager;
use League\Fractal\Pagination\PagerfantaPaginatorAdapter;
use League\Fractal\Resource\Collection;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\Routing\RouterInterface;

class ProductCategoryService
{
    private $router;
    private $fractal;
    private $productCategoryRepository;
    private $entityManager;

    public function __construct(
        RouterInterface $router,
        ProductCategoryRepository $productCategoryRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->router = $router;
        $this->productCategoryRepository = $productCategoryRepository;
        $this->entityManager = $entityManager;
        $this->fractal = new Manager();
    }

    public function getPaginatedCategories(
        PaginationDto $paginationDto,
        SortDto $sortDto,
        FiltersDto $filtersDto,
        IncludesDto $includesDto
    ) {
        $productsQueryBuilder = $this->productCategoryRepository
            ->getSortedAndFilteredCategoriesQueryBuilder($sortDto, $filtersDto);

        $doctrineAdapter = new DoctrineORMAdapter($productsQueryBuilder, true, false);
        $paginator = new Pagerfanta($doctrineAdapter);
        $paginator->setMaxPerPage($paginationDto->getPageSize());
        $paginator->setCurrentPage($paginationDto->getPage());
        $paginatorResult = $paginator->getCurrentPageResults();
        $resource = new Collection($paginatorResult, new ProductCategoryTransformer());

        $router = $this->router;

        $paginatorAdapter = new PagerfantaPaginatorAdapter(
            $paginator, function (int $page) use ($paginationDto, $router) {
            $route = $paginationDto->getRoute();
            $inputParams = $paginationDto->getRouteParams();
            $newParams = array_merge($inputParams, $paginationDto->getQueryParams());
            $newParams['page'] = $page;
            return $router->generate($route, $newParams, 0);
        }
        );
        if($includesDto->getIncludes() !== null) {
            $this->fractal->parseIncludes($includesDto->getIncludes());
        }
        $resource->setPaginator($paginatorAdapter);
        return $this->fractal->createData($resource)->toArray();
    }

    public function addCategory(string $categoryName, ?int $categoryParentId): int
    {
        $category = new ProductCategory();
        $category->setName($categoryName);

        if($categoryParentId !== null) {
            $category->setParent(
                $this->productCategoryRepository->find($categoryParentId)
            );
        }

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return $category->getId();
    }
}
