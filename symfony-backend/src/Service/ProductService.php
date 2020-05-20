<?php

namespace App\Service;

use App\Dto\Product\ProductDto;
use App\Dto\Request\CursorDto;
use App\Dto\Request\IncludesDto;
use App\Dto\Request\PaginationDto;
use App\Dto\Request\SortDto;
use App\Entity\Product\Product;
use App\Exception\ItemNotFoundInDatabaseException;
use App\Repository\Product\ProductCategoryRepository;
use App\Repository\Product\ProductRepository;
use App\Transformer\ProductTransformer;
use Doctrine\ORM\EntityManagerInterface;
use League\Fractal\Manager;
use League\Fractal\Pagination\Cursor;
use League\Fractal\Pagination\PagerfantaPaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class ProductService
{
    const PRODUCTS_STATISTICS_CACHE_KEY = 'products_statistics';

    private $entityManager;
    private $productRepository;
    private $fractal;
    private $router;
    private $cache;
    private $productCategoryRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProductRepository $productRepository,
        RouterInterface $router,
        CacheInterface $cache,
        ProductCategoryRepository $productCategoryRepository
    ) {
        $this->entityManager = $entityManager;
        $this->productRepository = $productRepository;
        $this->router = $router;
        $this->cache = $cache;
        $this->productCategoryRepository = $productCategoryRepository;
        $this->fractal = new Manager();
    }

    /**
     * @param CursorDto $cursorDto
     * @param SortDto $sortDto
     * @return array
     * @todo Rethink that method
     */
    public function getCursorLimitedProducts(CursorDto $cursorDto, SortDto $sortDto): array
    {
        $products = $this->productRepository->findWithCursor($cursorDto, $sortDto);

        if ($products) {
            if ($sortDto !== null) {
                switch ($sortDto->getSortField()) {
                    case 'id':
                        $newCursor = end($products)->getId();
                        break;
                    case 'name':
                        $newCursor = sprintf('%s,%s', end($products)->getName(), end($products)->getId());
                        break;
                    case 'weight':
                        $newCursor = sprintf('%s,%s', end($products)->getWeight(), end($products)->getId());
                        break;
                    case 'price':
                        $newCursor = sprintf('%s,%s', end($products)->getPrice(), end($products)->getId());
                        break;
                    default:
                        throw new \InvalidArgumentException('cannot sort by current field');
                }
            } else {
                $newCursor = end($products)->getId();
            }
            $cursor = new Cursor($cursorDto->getCursor(), $cursorDto->getPrevious(), $newCursor, count($products));
            $resource = new Collection($products, new ProductTransformer());
            $resource->setCursor($cursor);
        } else {
            $cursor = new Cursor(
                $cursorDto->getPrevious(),
                $cursorDto->getPrevious() - $cursorDto->getLimit(),
                $cursorDto->getPrevious(),
                0
            );
            $resource = new Collection([]);
            $resource->setCursor($cursor);
        }

        return $this->fractal->createData($resource)->toArray();
    }

    public function getPaginatedProducts(PaginationDto $paginationDto, SortDto $sortDto, IncludesDto $includesDto)
    {
        $productsQueryBuilder = $this->productRepository->getSortedProductsQueryBuilder($sortDto);

        $doctrineAdapter = new DoctrineORMAdapter($productsQueryBuilder, true, false);
        $paginator = new Pagerfanta($doctrineAdapter);
        $paginator->setMaxPerPage($paginationDto->getPageSize());
        $paginator->setCurrentPage($paginationDto->getPage());
        $paginatorResult = $paginator->getCurrentPageResults();
        $resource = new Collection($paginatorResult, new ProductTransformer());

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

        $resource->setPaginator($paginatorAdapter);

        if ($includesDto->getIncludes() !== null) {
            $this->fractal->parseIncludes($includesDto->getIncludes());
        }

        return $this->fractal->createData($resource)->toArray();
    }

    /**
     * @param int $id
     * @throws ItemNotFoundInDatabaseException
     */
    public function deleteProduct(int $id): void
    {
        $product = $this->productRepository->find($id);

        if ($product === null) {
            throw new ItemNotFoundInDatabaseException();
        }

        $this->entityManager->remove($product);
        $this->entityManager->flush();
    }

    public function addProduct(ProductDto $productDto): int
    {
        $product = new Product();
        $product->setName($productDto->getName());
        $product->setPrice($productDto->getPrice());
        $product->setWeight($productDto->getWeight());

        if ($productDto->getCategoryId() !== null) {
            $product->setCategory(
                $this->productCategoryRepository->find($productDto->getCategoryId())
            );
        }

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product->getId();
    }

    public function getProductsStatistics()
    {
        $productsStatistics = $this->cache->get(
            self::PRODUCTS_STATISTICS_CACHE_KEY,
            function (ItemInterface $item) {
                $item->expiresAfter(3600);

                $resource = new Collection(
                    $this->productRepository->getNewestProducts(10),
                    new ProductTransformer()
                );
                $newestProducts = $this->fractal->createData($resource)->toArray();

                return [
                    'count' => $this->productRepository->getProductsCount()['products_count'],
                    'new' => $newestProducts
                ];
            }
        );

        return $productsStatistics;
    }

    public function getProduct($id, IncludesDto $includesDto)
    {
        $this->fractal->parseIncludes($includesDto->getIncludes());

        $resource = new Item($this->productRepository->find($id), new ProductTransformer());

        return $this->fractal->createData($resource)->toArray();
    }
}
